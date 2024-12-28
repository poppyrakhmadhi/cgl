<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Cold Storage</title>
    <link rel="stylesheet" type="text/css" href="so.css">
</head>
<body>
	<nav>
		<a href="#home">Home</a>
		<a href="soh.php">SOH</a>
		<b><a href="mutasi.php" style="color: red;">MutasiCS</a></b>
		<a href="idstock.php">IDstock</a>
		<a href="stockchiller.php">StockChillerID</a>
		<a href="mutasichiller.php">MutasiChiller</a>
		<a href="rekaporder.php">RekapOrder</a>
	</nav>
    <form method="GET" action="">
		<div>
			<label for="start_date">Tgl Awal:</label>
			<input type="date" id="start_date" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
		</div>
		<div>
			<label for="end_date">Tgl Akhir:</label>
			<input type="date" id="end_date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
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
					$sql = "select distinct(nama) as nama from product_gudang 
							where nama like '%FROZEN%'
								and production_date>'2023-05-05'
							order by nama";
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
			<label for="id_subitem">Sub_Item:</label>
				<select id="id_subitem" name="id_subitem">
					<?php
					// Include file konfigurasi
					require_once('config.php');
					$koneksi = new mysqli($hostname, $username, $password, $database);

					// Periksa koneksi
					if ($koneksi->connect_error) {
						die("Koneksi gagal: " . $koneksi->connect_error);
					}

					// Query untuk mengambil id dan nama dari tabel items
					$sql = "select
								distinct(sub_item) as nama 
							from product_gudang 
							where nama like '%FROZEN%'
								and production_date>'2023-05-27'
							order by nama";
					$result = $koneksi->query($sql);

					// Variabel untuk menyimpan nilai yang sudah dipilih sebelumnya
					$selected_value = isset($_GET['id_subitem']) ? $_GET['id_subitem'] : '';
					
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
				</select>
			</div>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
				<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

				<script>
					$(document).ready(function () {
						$("#id_subitem").select2({
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
						$("#id_subitem").on("select2:open", function() {
							$(".select2-search__field").attr("placeholder", "Cari item...");
							$(".select2-search__field").on("keyup", function() {
								var input = $(this).val().toUpperCase();
								$("#id_subitem option").each(function() {
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
			<label for="part">Part:</label>
			<select id="part" name="part">
				<option value="">Semua</option>
				<option value="0">0</option>
				<option value="4">4</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="14">14</option>
				<option value="20">20</option>
			</select>
		</div>
		<div>
			<label for="plastik">Plastik:</label>
			<select id="plastik" name="plastik">
				<?php
				// Include file konfigurasi
				require_once('config.php');
				$koneksi = new mysqli($hostname, $username, $password, $database);

				// Periksa koneksi
				if ($koneksi->connect_error) {
					die("Koneksi gagal: " . $koneksi->connect_error);
				}

				// Query untuk mengambil id dan nama dari tabel items
				$sql = "select distinct(plastik_group) as plastik
						from product_gudang
						where production_date>='2024-04-27'
							and plastik_group is not null
						order by plastik_group ";
				$result = $koneksi->query($sql);

				// Variabel untuk menyimpan nilai yang sudah dipilih sebelumnya
				$selected_value = isset($_GET['plastik']) ? $_GET['plastik'] : '';
				
				// Menampilkan Semua Item
				echo '<option value="">Semua</option>';
				
				// Jika hasil query tidak kosong, tampilkan opsi untuk setiap item
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$selected = ($selected_value == $row['plastik']) ? 'selected' : ''; // Tandai opsi terpilih sebelumnya
						echo '<option value="' . $row['plastik'] . '" ' . $selected . '>' .  $row['plastik'] . '</option>';
					}
				} else {
					echo '<option value="">Tidak ada item tersedia</option>';
				}

				// Tutup koneksi
				$koneksi->close();
				?>
			</select>
		</div>
		<div>
			<label for="nama">Pencarian:</label>
			<input type="text" id="nama" name="nama" value="<?php echo isset($_GET['nama']) ? $_GET['nama'] : ''; ?>">
        </div>
		<div>
			<label for="gudang">Gudang:</label>
			<select id="gudang" name="gudang">
            <?php 
			
			require_once('config.php');
			if($subsidiary=='CGL'){
			echo "
				<option value=''>Semua</option>
				<option value='CGL - Cold Storage'>CGL - Cold Storage</option>
				<option value='CGL - Cold Storage 1'>CGL - Cold Storage 1</option>
				<option value='CGL - Cold Storage 2'>CGL - Cold Storage 2</option>
				<option value='CGL - Cold Storage 3'>CGL - Cold Storage 3</option>
				<option value='CGL - Cold Storage 4'>CGL - Cold Storage 4</option>
				<option value='CGL - Muara Baru'>CGL - Muara Baru</option>
				<option value='CGL - Manis'>CGL - Manis</option> ";
			}
			if($subsidiary=='EBA'){
			echo "
				<option value=''>Semua</option>
				<option value='EBA - Cold Storage'>EBA - Cold Storage</option>
				<option value='EBA - Cold Storage 1'>EBA - Cold Storage 1</option>
				<option value='EBA - Cold Storage 2'>EBA - Cold Storage 2</option>
				<option value='EBA - Cold Storage 3'>EBA - Cold Storage 3</option>
				<option value='EBA - Cold Storage 4'>EBA - Cold Storage 4</option>
				<option value='EBA - Cold Storage 5'>EBA - Cold Storage 5</option>
				<option value='EBA - Cold Storage 6'>EBA - Cold Storage 6</option> ";
			}
			?>
			</select>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					// Ambil elemen select
					var selectGudang = document.getElementById('gudang');
					var selectPart = document.getElementById('part');

					// Cek apakah ada nilai tersimpan di localStorage
					var selectedGudang = localStorage.getItem('selectedGudang');
					var selectedPart = localStorage.getItem('selectedPart');

					// Jika ada, atur nilai select ke nilai yang tersimpan
					if (selectedGudang) {
						selectGudang.value = selectedGudang;
					}
					if (selectedPart) {
						selectPart.value = selectedPart;
					}

					// Fungsi untuk menyimpan nilai ke localStorage
					function saveToLocalStorage() {
						localStorage.setItem('selectedGudang', selectGudang.value);
						localStorage.setItem('selectedPart', selectPart.value);
					}

					// Tambahkan event listener untuk menyimpan nilai yang dipilih ke localStorage
					selectGudang.addEventListener('change', saveToLocalStorage);
					selectPart.addEventListener('change', saveToLocalStorage);
				});
			</script>
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
			<label for="tanggal_sebelum_so">Sort tanggal bahan baku sebelum SO:</label>
			<input type="date" id="tanggal_sebelum_so" name="tanggal_sebelum_so" value="<?php echo isset($_GET['tanggal_sebelum_so']) ? $_GET['tanggal_sebelum_so'] : ''; ?>">
		</div>
		<div>
			<input type="submit" name="submit" value="Filter">
		</div>
	</form>

	<?php
	
	if(isset($_GET['submit'])||isset($_GET['tes_submit'])) {
		// Konfigurasi database 
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
		$nama = isset($_GET['nama']) ? $_GET ['nama'] : '';
		$inbound = isset($_GET['inbound']) ? $_GET ['inbound'] : '';
		$outbound = isset($_GET['outbound']) ? $_GET ['outbound'] : '';
		$id_item = isset($_GET['id_item']) ? $_GET ['id_item'] : '';
		$id_subitem = isset($_GET['id_subitem']) ? $_GET ['id_subitem'] : '';
		$gudang = isset($_GET['gudang']) ? $_GET ['gudang'] : '';
		$part = isset($_GET['part']) ? $_GET ['part'] : '';
		$plastik = isset($_GET['plastik']) ? $_GET ['plastik'] : '';
		$tanggal_sebelum_so = isset($_GET['tanggal_sebelum_so']) ? $_GET ['tanggal_sebelum_so'] : '';

		// Query untuk mengambil data dari database
		$query = "
	select * from (
		select * from (
			select * from( # siap kirim
				select gudang_id_keluar,  tgl_kirim_B ,nama,qty_awal*-1 as qty_awal, berat_awal*-1 as berat_awal, 
					sub_item,plastik_group, parting,  nama_B, type, id_B as id_so, no_so_B, no_do_B, production_date_D,code_C
				from (
					select 
						gudang_id_keluar,production_date,sub_item,parting, nama, plastik_group, 
						qty_awal, berat_awal, type,order_id, gudang_id
					from product_gudang
					where jenis_trans like 'keluar'
						and deleted_at is null
				) as A
				left join (
					select  id as id_B, no_so as no_so_B, no_do as no_do_B, 
						nama as nama_B, tanggal_kirim as tgl_kirim_B
					from orders
				) as B
				on A.order_id=B.id_B
				left join (
					select id as id_C, code as code_C from gudang
				) as C
				on A.gudang_id=C.id_C
				left join (
					select distinct(id) as id_D,production_date as production_date_D
					from product_gudang
					where jenis_trans='masuk'
				) as D
				on A.gudang_id_keluar=D.id_D
				where type like 'siapkirim'
			) as A
			union all
			select * from ( # thawing
				select gudang_id_keluar,  production_date ,nama,qty_awal*-1, 
					berat_awal*-1, sub_item_D,plastik_group_D, parting_D,  
					nama_B, type, '' as id_so ,no_so_B, no_do_B, production_date_D,code_C
				from (
					select 
						gudang_id_keluar,production_date,sub_item,parting, nama, 
						plastik_group, qty_awal, berat_awal, type,order_id, gudang_id
					from product_gudang
					where jenis_trans like 'keluar'
						and deleted_at is null
				) as A
				left join (
					select  id as id_B, no_so as no_so_B, no_do as no_do_B, 
						nama as nama_B, tanggal_kirim as tgl_kirim_B
					from orders
				) as B
				on A.order_id=B.id_B
				left join (
					select id as id_C, code as code_C from gudang
					
				) as C
				on A.gudang_id=C.id_C
				left join (
					select
						distinct(id) as id_D,production_date as production_date_D, 
						sub_item as sub_item_D, plastik_group as plastik_group_D, 
						if(parting is null, 0, parting) as parting_D
					from product_gudang
					where jenis_trans='masuk'
				) as D
				on A.gudang_id_keluar=D.id_D
				where type like '%thawing%'
			) as B
			union all
			select * from ( # adjustment
				select gudang_id_keluar,  production_date ,nama,qty as qty_awal, 
					berat as berat_awal, sub_item,plastik_group, parting,  
					nama_B, type, '' as id_so ,no_so_B, no_do_B, production_date_D,code_C
				from (
					select 
						gudang_id_keluar,production_date,sub_item,parting, nama, 
						plastik_group, qty, berat, type,order_id, gudang_id
					from product_gudang
					where deleted_at is null
				) as A
				left join (
					select  id as id_B, no_so as no_so_B, no_do as no_do_B, 
						nama as nama_B, tanggal_kirim as tgl_kirim_B
					from orders
				) as B
				on A.order_id=B.id_B
				left join (
					select id as id_C, code as code_C from gudang
				) as C
				on A.gudang_id=C.id_C
				left join (
					select distinct(id) as id_D,production_date as production_date_D
					from product_gudang
				) as D
				on A.gudang_id_keluar=D.id_D
				where type like '%inventory_adjustment%'
			) as B
			union all
			select * from ( #hasil abf #open_balance
				select id,  production_date ,nama,qty_awal, 
					berat_awal, sub_item,plastik_group, if(parting is null, 0, parting) as parting ,  
					'' as customer, if(table_name_E is null,table_name,table_name_E) as table_name_E, 
					'' as id_so ,'' as so, '' as do, 
					if(table_name_E='openbalance','',tanggal_masuk_B) as tgl_prod,code_C
				from (
					select * from (
						select 
							id,production_date,sub_item,parting, nama, table_id, table_name,
							plastik_group, qty_awal, berat_awal, type,order_id, gudang_id
						from product_gudang
						where jenis_trans like 'masuk'
							and deleted_at is null
					) as A
					left join (
						select id as table_id_B, tanggal_masuk as tanggal_masuk_B
						from abf
					) as B
					on A.table_id=B.table_id_B
				) as A
				left join (
					select id as id_C, code as code_C from gudang
				) as C
				on A.gudang_id=C.id_C
				left join (
					select id as id_E, table_name as table_name_E
					from abf
				) as E
				on A.table_id=E.id_E
			) as C
			union all
			select * from ( # pindah_gudang
				select gudang_id_keluar,  production_date ,nama,qty_awal*-1, 
					berat_awal*-1, sub_item_D,plastik_group_D, parting_D,  
					'' as nama_B, type, '' as id_so ,'' as no_so_B, '' as no_do_B, production_date_D,code_C
				from (
					select 
						gudang_id_keluar,production_date,sub_item,parting, nama, 
						plastik_group, qty_awal, berat_awal, type,order_id, gudang_id
					from product_gudang
					where jenis_trans like 'keluar'
						and deleted_at is null
				) as A
				left join (
					select id as id_C, code as code_C from gudang
				) as C
				on A.gudang_id=C.id_C
				left join (
					select
						distinct(id) as id_D,production_date as production_date_D, 
						sub_item as sub_item_D, plastik_group as plastik_group_D, 
						if(parting is null, 0, parting) as parting_D
					from product_gudang
					where jenis_trans='masuk'
				) as D
				on A.gudang_id_keluar=D.id_D
				where type like 'pindah_gudang'
			) as D
		) as A
		where nama like '%FROZEN%'
		";

		// Menambahkan kondisi WHERE jika $start_date tidak kosong
		
		if (!empty($start_date)) {
			$query .= " AND tgl_kirim_B >= '$start_date' ";
		}
		if (!empty($end_date)) {
			$query .= " AND tgl_kirim_B <= '$end_date' ";
		}
		if (!empty($nama)) {
			$query .= " AND (sub_item like '%$nama%' 
				or nama_B like '%$nama%' or type like '%$nama%' 
				or no_so_B like '%$nama%' or no_do_B like '%$nama%'
				or plastik_group like '%$nama%' or gudang_id_keluar like '%$nama%')";
		}
		if (!empty($id_item)) {
			$query .= " AND nama like '$id_item' ";
		}
		if (!empty($id_subitem)) {
			$query .= " AND sub_item like '$id_subitem' ";
		}
		if (!empty($gudang)) {
			$query .= " AND code_C like '$gudang' ";
		}
		if (!empty($inbound)) {
			$query .= " AND berat_awal>0 ";
		}
		if (!empty($outbound)) {
			$query .= " AND berat_awal<0 ";
		}
		if (!empty($plastik)) {
			$query .= " AND plastik_group like '$plastik' ";
		}
		if (!empty($part)) {
			$query .= " AND parting like '$part' ";
		}
		
		if (!empty($tanggal_sebelum_so)) {
			$query .= " AND production_date_D<='$tanggal_sebelum_so' ";
		}

		$query .= " order by tgl_kirim_B desc ) as B ";
		
		$query_total = " 
			select 
				'' as gudang_id_keluar, '' as tgl_kirim, '' as nama, sum(qty_awal) as qty_awal, 
				sum(berat_awal) as berat_awal, '' as sub_item, '' as plastik_group, '' as parting, 
				'' as nama_B, '' as type, '' as id_so, '' as no_so_B, '' as no_do_B, 
				'' as production_date_D, '' as code_C
			from ($query) as A
			union all
			select * from (
				select * from (
					select * from ($query) as A 
				) as B
				order by tgl_kirim_B desc
				limit 2000
			) as A
			
		";
		// Menjalankan query
		$result = $koneksi->query($query_total);
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
						<th class='header'>Berat (kg)</th>
						<th class='header'>SubItem</th>
						<th class='header'>Part</th>
						<th class='header'>Plastik</th>
						<th class='header'>Customer</th>
						<th class='header'>Type</th>
						<th class='header'>SO</th>
						<th class='header'>DO</th>
						<th class='header'>Tgl Prod</th>
						<th class='header'>Gudang</th>
					</tr>
					";
				// Menampilkan data
				$counter = "";
				while ($row = $result->fetch_assoc()) {
					$qty_awal = $row["qty_awal"];
					$berat_awal = $row["berat_awal"];
					$qty_class = ($qty_awal < -0.0001) ? 'warna-merah' : 'warna-biru';
					$berat_class = ($berat_awal < -0.0001) ? 'warna-merah' : 'warna-biru';

					echo "
						<tr>
							<td>" . $counter++ . "</td>
							<td><a href='$gudang_url" . $row["gudang_id_keluar"] . "'>" . $row["gudang_id_keluar"] . "</a></td>
							<td>" . $row["tgl_kirim"] . "</td>
							<td>" . $row["nama"] . "</td>
							<td class='rata-kanan $qty_class'>" . number_format($qty_awal, 0,'.',',') . "</td>
							<td class='rata-kanan $berat_class'>" . number_format($berat_awal, 2,'.',',') . "</td>
							<td>" . $row["sub_item"] . "</td>
							<td>" . $row["parting"] . "</td>
							<td>" . $row["plastik_group"] . "</td>
							<td>" . $row["nama_B"] . "</td>
							<td>" . $row["type"] . "</td>
							<td><a href='$siapkirim_url" . $row["id_so"] . "'>" . $row["no_so_B"] . "</a></td>
							<td>" . $row["no_do_B"] . "</td>
							<td>" . $row["production_date_D"] . "</td>
							<td>" . $row["code_C"] . "</td>
						  </tr>";
				}
				echo "</table>";
			} else {
				echo "Tidak ada hasil yang ditemukan.";
			}
		} else {
			echo "Error: " . $koneksi->error;
		}

		// Menutup koneksi
		$koneksi->close();
	}
	?>
</body>
</html>