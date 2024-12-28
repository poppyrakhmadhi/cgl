<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Chiller</title>
    <link rel="stylesheet" type="text/css" href="so.css">
</head>
<body>
    <nav>
        <a href="#home">Home</a>
        <a href="soh.php">SOH</a>
        <a href="mutasi.php">MutasiCS</a>
		<a href="idstock.php">IDstock</a>
		<a href="stockchiller.php">StockChillerID</a>
		<b><a href="mutasichiller.php" style="color: red;">MutasiChiller</a></b>
		<a href="rekaporder.php">RekapOrder</a>
    </nav>
    <form method="GET" action="">
        <div>
            <label for="start_date">Tgl Awal:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d',strtotime('-1 days')); ?>">
        </div>
		<div>
			<label for="end_date">Tgl Akhir:</label>
			<input type="date" id="end_date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); ?>"> 
        </div>
		<div>
			<label for="id_item">Item:</label>
				<select id="id_item" name="id_item">
					<?php
					// Include file konfigurasi
					require_once('config.php');
					$koneksi = new mysqli($hostname, $username, $password, $database);

					// Periksa koneksi
					if ($koneksi->connect_error) {
						die("Koneksi gagal: " . $koneksi->connect_error);
					}

					// Query untuk mengambil id dan nama dari tabel items
					$sql = "select distinct(item_name) as nama 
							from chiller 
							where item_name not like 'AY - S'
								and tanggal_potong>'2023-05-27'
							order by item_name";
					$result = $koneksi->query($sql);

					// Variabel untuk menyimpan nilai yang sudah dipilih sebelumnya
					$selected_value = isset($_GET['id_item']) ? $_GET['id_item'] : '';
					
					// Menampilkan Semua Item
					echo '<option value="%%">Semua</option>';
					
					// Jika hasil query tidak kosong, tampilkan opsi untuk setiap item
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$selected = ($selected_value == $row['nama']) ? 'selected' : ''; // Tandai opsi terpilih sebelumnya
							echo '<option value="' . $row['nama'] . '" ' . $selected . '>' .  $row['nama'] . '</option>';
						}
					} else {
						echo '<option value="">Tidak ada item tersedia</option>';
					}

					// Tutup koneksi
					$koneksi->close();
					?>
				</select><br>
		</div>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
				<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

				<script>
					$(document).ready(function () {
						$("#id_item").select2({
							placeholder: "Pilih atau ketik item",
							allowClear: true,
							tags: true,
							tokenSeparators: [','],
							createTag: function (params) {
								var term = $.trim(params.term);

								if (term === '') {
									return null;
								}

								return {
									id: term,
									text: term,
									newTag: true // add additional parameters
								}
							}
						});

						// Pencarian berbasis JavaScript
						$("#id_item").on("select2:open", function() {
							$(".select2-search__field").attr("placeholder", "Cari item...");
							$(".select2-search__field").on("keyup", function() {
								var input = $(this).val().toUpperCase();
								$("#id_item option").each(function() {
									var text = $(this).text().toUpperCase();
									if (text.indexOf(input) !== -1) {
										$(this).show();
									} else {
										$(this).hide();
									}
								});
							});
						});
					});
				</script>
		<div>
			<label for="asal_tujuan">Asal_Tujuan:</label>
			<select id="asal_tujuan" name="asal_tujuan">
				<option value="">Semua</option>
				<option value="abf">abf</option>
				<option value="bahan-baku">bahan-baku</option>
				<option value="evisgabungan">evisgabungan</option>
				<option value="free_stock">free_stock</option>
				<option value="gradinggabungan">gradinggabungan</option>
				<option value="hasilbeli">hasilbeli</option>
				<option value="karkasbeli">karkasbeli</option>
				<option value="order-fulfillment">order-fulfillment</option>
				<option value="retur">retur</option>
				<option value="thawing">thawing</option>
			</select>
		</div>
		<div>
			<label for="gudang">Chiller:</label>
			<select id="gudang" name="gudang">
				<option value="">Semua</option>
				<option value="bahan-baku">bahan-baku</option>
				<option value="hasil-produksi">hasil-produksi</option>
			</select>
		</div>
		<div>
			<label for="id_regu">Regu:</label>
			<select id="id_regu" name="id_regu">
				<option value="">Semua</option>
				<option value="boneless">boneless</option>
				<option value="byproduct">byproduct</option>
				<option value="frozen">frozen</option>
				<option value="marinasi">marinasi</option>
				<option value="parting">parting</option>
				<option value="whole">whole</option>
			</select>
		</div>
		<div>
			<label for="alokasi">Alokasi:</label>
			<select id="alokasi" name="alokasi">
				<option value="">Semua</option>
				<option value="abf">abf</option>
				<option value="chiller">chiller</option>
				<option value="ekspedisi">ekspedisi</option>
			</select>
		</div>
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Daftar ID elemen select
			var selectIds = ['asal_tujuan', 'gudang', 'id_regu', 'alokasi'];

			// Iterasi melalui setiap elemen select
			selectIds.forEach(function(selectId) {
				// Ambil elemen select
				var select = document.getElementById(selectId);

				// Cek apakah ada nilai tersimpan di localStorage
				var selectedValue = localStorage.getItem(selectId);

				// Jika ada, atur nilai select ke nilai yang tersimpan
				if (selectedValue) {
					select.value = selectedValue;
				}

				// Tambahkan event listener untuk menyimpan nilai yang dipilih ke localStorage
				select.addEventListener('change', function() {
					localStorage.setItem(selectId, select.value);
				});
			});
		});
		</script>
        <div>
            <label for="nama">Pencarian:</label>
            <input type="text" id="nama" name="nama" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>">
        </div>
		<div>
			<label for="inbound">Inbound:</label>
			<input type="checkbox" id="inbound" name="inbound" onchange="limitCheckbox(this)" <?php echo isset($_GET['inbound']) ? 'checked' : ''; ?>>
		</div>
		<div>
			<label for="outbound">Outbound:</label>
			<input type="checkbox" id="outbound" name="outbound" onchange="limitCheckbox(this)" <?php echo isset($_GET['outbound']) ? 'checked' : ''; ?>>
		</div>
			<script>
				function limitCheckbox(checkbox) {
					var checkboxes = document.querySelectorAll('input[type="checkbox"]');
					checkboxes.forEach(function(el) {
						if (el !== checkbox) {
							el.checked = false;
						}
					});
				}
			</script>
		<div>
            <label for="tgl_prod">Tgl prod sebelum:</label>
            <input type="date" id="tgl_prod" name="tgl_prod" value="<?php echo isset($_GET['tgl_prod']) ? $_GET['tgl_prod'] : date('Y-m-d',strtotime('-1 days')); ?>">
        </div>
		<div>
			<input type="submit" name="submit" value="Filter">
		</div>
    </form>
<?php
if(isset($_GET['submit'])){
	// Include file konfigurasi
	require_once('config.php');


	// Membuat koneksi
	$koneksi = new mysqli($hostname, $username, $password, $database);

	// Memeriksa koneksi
	if ($koneksi->connect_error) {
		die("Koneksi gagal: " . $koneksi->connect_error);
	}
		
	// Tangkap data dari form
	$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
	$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
	$id_item = isset($_GET['id_item']) ? $_GET ['id_item'] : '';
	$gudang = isset($_GET['gudang']) ? $_GET ['gudang'] : '';
	$asal_tujuan = isset($_GET['asal_tujuan']) ? $_GET ['asal_tujuan'] : '';
	$id_regu = isset($_GET['id_regu']) ? $_GET ['id_regu'] : '';
	$alokasi = isset($_GET['alokasi']) ? $_GET ['alokasi'] : '';
	$nama = isset($_GET['nama']) ? $_GET ['nama'] : '';
	$stock_nol = isset($_GET['stock_nol']) ? $_GET ['stock_nol'] : '';
	$inbound = isset($_GET['inbound']) ? $_GET ['inbound'] : '';
	$outbound = isset($_GET['outbound']) ? $_GET ['outbound'] : '';
	$tgl_prod = isset($_GET['tgl_prod']) ? $_GET['tgl_prod'] : '';

// Query untuk mengambil data dari database
	$query = " 
select * from (
	select 
		'Total' as id, '' as tgl, '' as item_name, '' as asal_tujuan, 
		'' as type, '' as regu, '' as alokasi, 
		sum(qty_item) as qty_item, sum(berat_item) as berat_item, '' as do, 
		'' as id_so,'' as so, '' as customer, '' as tgl_prod 
	from ( 
		select # barang masuk
			id, tgl, item_name, asal_tujuan, 
			type , regu, alokasi, qty_item, 
			berat_item, do, id_so, so, customer, tgl_prod
		from (	
			select 
				id,tanggal_produksi as tgl ,item_name,asal_tujuan,type, regu,
				qty_item,berat_item,'' as do, '' as id_so,'' as so, 
				'' as customer, '' as tgl_prod, table_id
			from chiller 
			where jenis like 'masuk'
				and item_name not like 'AY - S'
				and deleted_at is null
				and id<>617651 and id<>625598
		) as A
		left join (
			select id as id_B, 
				if(kategori=0,'chiller',
				if(kategori=1, 'abf',
				if(kategori=2, 'ekspedisi', ''))) as alokasi
			from free_stocktemp
		) as B
		on A.table_id=B.id_B
		
		union all
		select #siap kirim
			chiller_out,tgl_kirim_B,nama, type as asal_tujuan, type_C as type, 
			'' as regu,alokasi_C as alokasi, bb_item*-1,bb_berat*-1,no_do as do,id_B as id_so, no_so_B as so , 
			nama_B as customer, tgl_prod_C as tgl_prod
		from (	
			select * from (	
				select * from order_bahan_baku
				where deleted_at is null
					and nama not like 'AY - S'
					and nama not like '%FROZEN%'
			) as A
			left join (
				select
					id as id_B,tanggal_kirim as tgl_kirim_B, 
					no_so as no_so_B, nama as nama_B
				from orders
			) as B
			on A.order_id=B.id_B
			left join (
				select id_C, tgl_prod_C, alokasi as alokasi_C, type_C
				from (	
					select id as id_C,tanggal_produksi as tgl_prod_C,table_id, type as type_C
					from chiller
					where jenis like 'masuk' 
				) as A
				left join (
					select id as id_B, 
						if(kategori=0,'chiller',
						if(kategori=1, 'abf',
						if(kategori=2, 'ekspedisi', ''))) as alokasi
					from free_stocktemp
				) as B
				on A.table_id=B.id_B
			) as C
			on A.chiller_out=C.id_C
			order by id desc
		) as A
		
		union all
		select # abf
			table_id,tanggal_masuk,item_name,'abf' as asal_tujuan,type_B as type,regu_B as regu, 
			alokasi_B as alokasi,qty_awal*-1, berat_awal*-1, '' as do, '' as id_so,'' as so, '' as customer, tgl_prod_B as tgl_prod
		from (
			select * from (
				select * from abf
				where type not like 'gabungan'
					and deleted_at is null
			) as A
			left join (
				select id as id_B,tanggal_produksi as tgl_prod_B,
					if(kategori=0,'chiller',
					if(kategori=1, 'abf',
					if(kategori=2, 'ekspedisi', ''))) as alokasi_B,
					type as type_B, regu as regu_B
				from chiller 
				where jenis like 'masuk'
			) as B
			on A.table_id=B.id_B
		) as A
			
		union all
		select #bahan baku regu
			chiller_id,tgl_prod,nama,'bahan-baku' as asal_tujuan, 
			type_D as type , regu, alokasi_D as alokasi,qty*-1, berat*-1, '' as do,'' as id_so,
			'' as so, '' as customer, tgl_prod_D as tgl_prod
		from (
			select * from (
				select * from free_stocklist
				where deleted_at is null
			) as A
			left join (
				select id as id_B,nama from items
			) as B
			on A.item_id=B.id_B
			left join(
				select id as id_C,tanggal as tgl_prod from free_stock
			) as C
			on A.freestock_id=C.id_C
			left join (
				select id as id_D,tanggal_produksi as tgl_prod_D,
					if(kategori=0,'chiller',
					if(kategori=1, 'abf',
					if(kategori=2, 'ekspedisi', ''))) as alokasi_D,
					type as type_D
				from chiller 
				where jenis like 'masuk'
			) as D
			on A.chiller_id=D.id_D
		) as A
	) as A 
	where id is not null  ";
if (!empty($end_date)) {
	$query .= " and tgl<='$end_date' ";
}
if (!empty($start_date)) {
	$query .= " and tgl>='$start_date' ";
}
if (!empty($id_item)) {
	$query .= " and item_name like '$id_item' ";
}
if (!empty($asal_tujuan)) {
	$query .= " and asal_tujuan like '$asal_tujuan' ";
}
if (!empty($gudang)) {
	$query .= " and type like '$gudang' ";
}
if (!empty($id_regu)) {
	$query .= " and regu like '$id_regu' ";
}
if (!empty($alokasi)) {
	$query .= " and alokasi like '$alokasi' ";
}
if (!empty($inbound)) {
	$query .= " and berat_item>0 ";
}
if (!empty($outbound)) {
	$query .= " and berat_item<0 ";
}
if (!empty($nama)) {
	$query .= " and (do like '%$nama%' or so like '%$nama%' 
		or customer like '%$nama%' or asal_tujuan like '%$nama%' 
		or type like '%$nama%' or regu like '%$nama%' or id like '%$nama%' or item_name like '%$nama%' ) ";
}
if (!empty($tgl_prod)) {
	$query .= " and tgl_prod<='$tgl_prod' ";
}

$query .="
) as B

union all
select * from (
	select * from ( 
		select # barang masuk
			id, tgl, item_name, asal_tujuan, 
			type , regu, alokasi, qty_item, 
			berat_item, '' as do, id_so, '' as so, customer, tgl_prod
		from (	
			select 
				id,tanggal_produksi as tgl ,item_name,asal_tujuan,type, regu,
				qty_item,berat_item,'' as do, '' as id_so,'' as so, 
				'' as customer, '' as tgl_prod, table_id
			from chiller 
			where jenis like 'masuk'
				and item_name not like 'AY - S'
				and deleted_at is null
				and id<>617651 and id<>625598
		) as A
		left join (
			select id as id_B, 
				if(kategori=0,'chiller',
				if(kategori=1, 'abf',
				if(kategori=2, 'ekspedisi', ''))) as alokasi
			from free_stocktemp
		) as B
		on A.table_id=B.id_B
		
		union all
		select #siap kirim
			chiller_out,tgl_kirim_B,nama, type as asal_tujuan, type_C as type, 
			'' as regu,alokasi_C as alokasi, bb_item*-1,bb_berat*-1,no_do as do,id_B as id_so, no_so_B as so , 
			nama_B as customer, tgl_prod_C as tgl_prod
		from (	
			select * from (	
				select * from order_bahan_baku
				where deleted_at is null
					and nama not like 'AY - S'
					and nama not like '%FROZEN%'
			) as A
			left join (
				select
					id as id_B,tanggal_kirim as tgl_kirim_B, 
					no_so as no_so_B, nama as nama_B
				from orders
			) as B
			on A.order_id=B.id_B
			left join (
				select id_C, tgl_prod_C, alokasi as alokasi_C, type_C
				from (	
					select id as id_C,tanggal_produksi as tgl_prod_C,table_id, type as type_C
					from chiller
					where jenis like 'masuk' 
				) as A
				left join (
					select id as id_B, 
						if(kategori=0,'chiller',
						if(kategori=1, 'abf',
						if(kategori=2, 'ekspedisi', ''))) as alokasi
					from free_stocktemp
				) as B
				on A.table_id=B.id_B
			) as C
			on A.chiller_out=C.id_C
			order by id desc
		) as A
		
		union all
		select # abf
			table_id,tanggal_masuk,item_name,'abf' as asal_tujuan,type_B as type,regu_B as regu, 
			alokasi_B as alokasi,qty_awal*-1, berat_awal*-1, '' as do, '' as id_so,'' as so, '' as customer, tgl_prod_B as tgl_prod
		from (
			select * from (
				select * from abf
				where type not like 'gabungan'
					and deleted_at is null
			) as A
			left join (
				select id as id_B,tanggal_produksi as tgl_prod_B,
					if(kategori=0,'chiller',
					if(kategori=1, 'abf',
					if(kategori=2, 'ekspedisi', ''))) as alokasi_B,
					type as type_B, regu as regu_B
				from chiller 
				where jenis like 'masuk'
			) as B
			on A.table_id=B.id_B
		) as A
			
		union all
		select #bahan baku regu
			chiller_id,tgl_prod,nama,'bahan-baku' as asal_tujuan, 
			type_D as type , regu, alokasi_D as alokasi,qty*-1, berat*-1, '' as do,'' as id_so,
			'' as so, '' as customer, tgl_prod_D as tgl_prod
		from (
			select * from (
				select * from free_stocklist
				where deleted_at is null
			) as A
			left join (
				select id as id_B,nama from items
			) as B
			on A.item_id=B.id_B
			left join(
				select id as id_C,tanggal as tgl_prod from free_stock
			) as C
			on A.freestock_id=C.id_C
			left join (
				select id as id_D,tanggal_produksi as tgl_prod_D,
					if(kategori=0,'chiller',
					if(kategori=1, 'abf',
					if(kategori=2, 'ekspedisi', ''))) as alokasi_D,
					type as type_D
				from chiller 
				where jenis like 'masuk'
			) as D
			on A.chiller_id=D.id_D
		) as A
	) as A 
	where id is not null";
if (!empty($end_date)) {
	$query .= " and tgl<='$end_date' ";
}
if (!empty($start_date)) {
	$query .= " and tgl>='$start_date' ";
}
if (!empty($id_item)) {
	$query .= " and item_name like '$id_item' ";
}
if (!empty($asal_tujuan)) {
	$query .= " and asal_tujuan like '$asal_tujuan' ";
}
if (!empty($gudang)) {
	$query .= " and type like '$gudang' ";
}
if (!empty($id_regu)) {
	$query .= " and regu like '$id_regu' ";
}
if (!empty($alokasi)) {
	$query .= " and alokasi like '$alokasi' ";
}
if (!empty($inbound)) {
	$query .= " and berat_item>0 ";
}
if (!empty($outbound)) {
	$query .= " and berat_item<0 ";
}
if (!empty($nama)) {
	$query .= " and (do like '%$nama%' or so like '%$nama%' 
		or customer like '%$nama%' or asal_tujuan like '%$nama%' 
		or type like '%$nama%' or regu like '%$nama%' or id like '%$nama%' or item_name like '%$nama%' ) ";
}
if (!empty($tgl_prod)) {
	$query .= " and tgl_prod<='$tgl_prod' ";
}
$query .="
	order by tgl desc ,id desc, item_name asc
	limit 2000
) as B
	";



// Menjalankan query
	$result = $koneksi->query($query);
	// Memeriksa apakah query berhasil dijalankan
	if ($result) {
		// Memeriksa apakah ada baris hasil
		if ($result->num_rows > 0) {
			// Membuat tabel
			echo "<table border='1'>";
			echo "
				<tr>
					<th class='header'>No.</th>
					<th class='header'>ID</th>
					<th class='header'>Tanggal</th>
					<th class='header'>Nama</th>
					<th class='header'>Qty</th>
					<th class='header'>Berat(kg)</th>
					<th class='header'>asal_tujuan</th>
					<th class='header'>Chiller</th>
					<th class='header'>Regu</th>
					<th class='header'>Alokasi</th>
					<th class='header'>DO</th>
					<th class='header'>SO</th>
					<th class='header'>Customer</th>
					<th class='header'>Tgl Prod</th>
				</tr>";
			// Menampilkan data
			$counter = 0;
			while ($row = $result->fetch_assoc()) {
				$qty = $row["qty_item"];
				$qty_class = ($qty < -0.0001) ? 'warna-merah' : 'warna-biru';
				$berat = $row["berat_item"];
				$berat_class = ($berat < -0.0001) ? 'warna-merah' : 'warna-biru';
				echo "<tr>
						<td>" . $counter++ . "</td>
						<td><a href='$chiller_url" . $row["id"] . "'>" . $row["id"] . "</a></td>
						<td>" . $row["tgl"] . "</td>
						<td>" . $row["item_name"] . "</td>
						<td class='rata-kanan $qty_class'>" . number_format($qty, 0,'.',',') . "</td>
						<td class='rata-kanan $berat_class'>" . number_format($berat , 2,'.',',') . "</td>
						<td>" . $row["asal_tujuan"] . "</td>
						<td>" . $row["type"] . "</td>
						<td><a href='$regu_url" . $row["regu"] . "'>" . $row["regu"] . "</a></td>
						<td>" . $row["alokasi"] . "</td>
						<td>" . $row["do"] . "</td>
						<td><a href='$siapkirim_url" . $row["id_so"] . "'>" . $row["so"] . "</a></td>
						<td>" . $row["customer"] . "</td>
						<td>" . $row["tgl_prod"] . "</td>
					  </tr>";
			}
			echo "</table>";
		} else {
			echo "Tidak ada hasil yang ditemukan.";
		}
	}
}

?>

	</body>
</html>