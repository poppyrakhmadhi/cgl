<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOH Gudang</title>
    <link rel="stylesheet" type="text/css" href="so.css">
</head>
<body>
    <nav>
        <a href="#home">Home</a>
		<b><a href="soh.php" style="color: red;">SOH</a></b>
        <a href="mutasi.php">MutasiCS</a>
		<a href="idstock.php">IDstock</a>
		<a href="stockchiller.php">StockChillerID</a>
		<a href="mutasichiller.php">MutasiChiller</a>
		<a href="rekaporder.php">RekapOrder</a>
    </nav>
    <form method="GET" action="">
        <div>
            <label for="end_date">Tanggal:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
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
			<label for="id_item">Item:</label>
				<select id="id_item" name="id_item">
					<?php
					// Lakukan koneksi ke database
					// Include file konfigurasi
					require_once('config.php');
					$koneksi = new mysqli($hostname, $username, $password, $database);

					// Periksa koneksi
					if ($koneksi->connect_error) {
						die("Koneksi gagal: " . $koneksi->connect_error);
					}

					// Query untuk mengambil id dan nama dari tabel items
					$sql = "select distinct(nama) as nama from cgl.product_gudang 
							where nama like '%FROZEN%'
								and production_date>='2023-05-27'
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
				</select>
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
							from cgl.product_gudang 
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
				</select><br>
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
						from cgl.product_gudang
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
            <input type="submit" name="submit" value="Tampilkan">
			<h6><?php echo "$subsidiary $posisi"; ?></h6>
		</div>
		<div>
			<label for="check_gudang">Gudang</label>
			<input type="checkbox" id="check_gudang" name="check_gudang" <?php echo isset($_GET['check_gudang']) ? 'checked' : ''; ?>>
			<label for="check_item">nama</label>
			<input type="checkbox" id="check_item" name="check_item" <?php echo isset($_GET['check_item']) ? 'checked' : ''; ?>>
			<label for="check_subitem">Subitem</label>
			<input type="checkbox" id="check_subitem" name="check_subitem" <?php echo isset($_GET['check_subitem']) ? 'checked' : ''; ?>>
			<label for="check_parting">Parting</label>
			<input type="checkbox" id="check_parting" name="check_parting" <?php echo isset($_GET['check_parting']) ? 'checked' : ''; ?>>
			<label for="check_plastik">Plastik</label>
			<input type="checkbox" id="check_plastik" name="check_plastik" <?php echo isset($_GET['check_plastik']) ? 'checked' : ''; ?>>
        </div>
    </form>
    <?php
		require_once('config.php');
		$koneksi = new mysqli($hostname, $username, $password, $database);
		if ($koneksi->connect_error) {
			die("Koneksi gagal: " . $koneksi->connect_error);
		}
		$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
		$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
		$nama = isset($_GET['nama']) ? $_GET ['nama'] : '';
		$id_item = isset($_GET['id_item']) ? $_GET ['id_item'] : '';
		$id_subitem = isset($_GET['id_subitem']) ? $_GET ['id_subitem'] : '';
		$gudang = isset($_GET['gudang']) ? $_GET ['gudang'] : '';
		$part = isset($_GET['part']) ? $_GET ['part'] : '';
		$plastik = isset($_GET['plastik']) ? $_GET ['plastik'] : '';
		$check_gudang = isset($_GET['check_gudang'])?$_GET['check_gudang']:'';
		$check_item = isset($_GET['check_item'])?$_GET['check_item']:'';
		$check_subitem = isset($_GET['check_subitem'])?$_GET['check_subitem']:'';
		$check_parting = isset($_GET['check_parting'])?$_GET['check_parting']:'';
		$check_plastik = isset($_GET['check_plastik'])?$_GET['check_plastik']:'';
	
		// Query
		$query = "
		select * 
		from (
			select  
				code_C,
				nama, 
				sum(qty_awal) as qty_awal, 
				sum(berat_awal) as berat_awal ,
				sub_item, 
				parting, 
				plastik_group
			from (
				select * from( # siap kirim
					select gudang_id_keluar,  tgl_kirim_B ,nama,qty_awal*-1 as qty_awal, berat_awal*-1 as berat_awal, 
						sub_item,plastik_group, parting,  nama_B, type, id_B as id_so, no_so_B, no_do_B, production_date_D,code_C
					from (
						select 
							gudang_id_keluar,production_date,sub_item,parting, nama, plastik_group, 
							qty_awal, berat_awal, type,order_id, gudang_id
						from cgl.product_gudang
						where jenis_trans like 'keluar'
							and deleted_at is null
					) as A
					left join (
						select  id as id_B, no_so as no_so_B, no_do as no_do_B, 
							nama as nama_B, tanggal_kirim as tgl_kirim_B
						from cgl.orders
					) as B
					on A.order_id=B.id_B
					left join (
						select id as id_C, code as code_C from cgl.gudang
					) as C
					on A.gudang_id=C.id_C
					left join (
						select distinct(id) as id_D,production_date as production_date_D
						from cgl.product_gudang
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
						from cgl.product_gudang
						where jenis_trans like 'keluar'
							and deleted_at is null
					) as A
					left join (
						select  id as id_B, no_so as no_so_B, no_do as no_do_B, 
							nama as nama_B, tanggal_kirim as tgl_kirim_B
						from cgl.orders
					) as B
					on A.order_id=B.id_B
					left join (
						select id as id_C, code as code_C from cgl.gudang
						
					) as C
					on A.gudang_id=C.id_C
					left join (
						select
							distinct(id) as id_D,production_date as production_date_D, 
							sub_item as sub_item_D, plastik_group as plastik_group_D, 
							if(parting is null, 0, parting) as parting_D
						from cgl.product_gudang
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
						from cgl.product_gudang
						where deleted_at is null
					) as A
					left join (
						select  id as id_B, no_so as no_so_B, no_do as no_do_B, 
							nama as nama_B, tanggal_kirim as tgl_kirim_B
						from cgl.orders
					) as B
					on A.order_id=B.id_B
					left join (
						select id as id_C, code as code_C from cgl.gudang
					) as C
					on A.gudang_id=C.id_C
					left join (
						select distinct(id) as id_D,production_date as production_date_D
						from cgl.product_gudang
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
							from cgl.product_gudang
							where jenis_trans like 'masuk'
								and deleted_at is null
						) as A
						left join (
							select id as table_id_B, tanggal_masuk as tanggal_masuk_B
							from cgl.abf
						) as B
						on A.table_id=B.table_id_B
					) as A
					left join (
						select id as id_C, code as code_C from cgl.gudang
					) as C
					on A.gudang_id=C.id_C
					left join (
						select id as id_E, table_name as table_name_E
						from cgl.abf
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
						from cgl.product_gudang
						where jenis_trans like 'keluar'
							and deleted_at is null
					) as A
					left join (
						select id as id_C, code as code_C from cgl.gudang
					) as C
					on A.gudang_id=C.id_C
					left join (
						select
							distinct(id) as id_D,production_date as production_date_D, 
							sub_item as sub_item_D, plastik_group as plastik_group_D, 
							if(parting is null, 0, parting) as parting_D
						from cgl.product_gudang
						where jenis_trans='masuk'
					) as D
					on A.gudang_id_keluar=D.id_D
					where type like 'pindah_gudang'
				) as D
			) as A
			where nama like '%FROZEN%' 
	";

		// Menambahkan kondisi WHERE jika $start_date tidak kosong
		if (!empty($end_date)) {
				$query .= " AND tgl_kirim_B<='$end_date' ";
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
		if (!empty($nama)) {
			$query .= " AND (sub_item like '%$nama%' or parting like '%$nama%' or 
			plastik_group like '%$nama%') ";
		}
		if (!empty($plastik)) {
				$query .= " AND plastik_group like '$plastik' ";
		}
		if (!empty($part)) {
			$query .= " AND parting like '$part' ";
		}
		
		$query .= " and code_C like "; //CGL - Cold Storage' 
		$query2 = " and tgl_kirim_B>='";
		$query3 = "'
		    group by code_C,nama, sub_item, parting, plastik_group 
			order by code_C,nama 
		) as B
		where berat_awal>0.0001 or berat_awal<-0.0001 ";
		if($subsidiary == 'CGL'){
		$query_total = "
			$query '$gudangCS'  $query2 $SO_CS $query3
			union all $query '$gudangCS1'  $query2 $SO_CS1 $query3
			union all $query '$gudangCS2'  $query2 $SO_CS2 $query3
			union all $query '$gudangCS3'  $query2 $SO_CS3 $query3
			union all $query '$gudangCS4'  $query2 $SO_CS4 $query3
			union all $query '$gudangMuaraBaru'  $query2 $SO_CS_MuaraBaru $query3
			union all $query '$gudangManis'  $query2 $SO_CS_Manis $query3
		";
		}
		if($subsidiary == 'EBA'){
		$query_total = "
			$query '$gudangCS'  $query2 $SO_CS $query3
			union all $query '$gudangCS1'  $query2 $SO_CS1 $query3
			union all $query '$gudangCS2'  $query2 $SO_CS2 $query3
			union all $query '$gudangCS3'  $query2 $SO_CS3 $query3
			union all $query '$gudangCS4'  $query2 $SO_CS4 $query3
			union all $query '$gudangCS5'  $query2 $SO_CS5 $query3
			union all $query '$gudangCS6'  $query2 $SO_CS6 $query3
		";
		}
		$status_check = '1';
		if(empty($check_gudang)&&empty($check_item)&&empty($check_subitem)&&empty($check_parting)&&empty($check_plastik)){
			$status_check = '0';
		}
		$query_group = "
			select ";
				if(!empty($check_gudang)||$status_check=='0'){
					$query_group .="code_C,";
				}
				if(!empty($check_item)||$status_check=='0'){
					$query_group .="nama,";
				}
				if(!empty($check_subitem)||$status_check=='0'){
					$query_group .="sub_item,";
				} 
				if(!empty($check_parting)||$status_check=='0'){
					$query_group .="parting,";
				} 
				if(!empty($check_plastik)||$status_check=='0'){
					$query_group .="plastik_group,";
				}
		$query_group .= "
				sum(qty_awal) as qty_awal,
				sum(berat_awal) as berat_awal
			from ( 
				$query_total
			) as A
			group by ";
				$group_by_parts = [];

				if (!empty($check_gudang)||$status_check=='0') {
					$group_by_parts[] = "code_C";
				}
				if (!empty($check_item)||$status_check=='0') {
					$group_by_parts[] = "nama";
				}
				if (!empty($check_subitem)||$status_check=='0') {
					$group_by_parts[] = "sub_item";
				}
				if (!empty($check_parting)||$status_check=='0') {
					$group_by_parts[] = "parting";
				}
				if (!empty($check_plastik)||$status_check=='0') {
					$group_by_parts[] = "plastik_group";
				}
				
				// Gabungkan bagian GROUP BY dengan koma, tanpa koma berlebih di akhir
				$query_group .= implode(", ", $group_by_parts);

	if(isset($_GET['submit'])) {
		// Menjalankan query
			$result = $koneksi->query($query_group);
		if ($result) {
			// Memeriksa apakah ada baris hasil
			$total_qty = 0;
			$total_stock = 0;
			while($row = $result->fetch_assoc()){
				$total_qty += $row["qty_awal"] ;
				$total_stock += $row["berat_awal"] ;
			}
			// reset pointer hasil query
			$result->data_seek(0);
			if ($result->num_rows > 0) {
				// Membuat tabel
				
				echo "<table border='1'>";
				echo "
					<tr>
						<th class='header'>No.</th> ";
					if(!empty($check_gudang)||$status_check=='0'){
						echo "<th class='header'>Gudang</th>";
					}
					if(!empty($check_item)||$status_check=='0'){
						echo "<th class='header'>Nama</th>";
					}
					if(!empty($check_subitem)||$status_check=='0'){
						echo "<th class='header'>SubItem</th>";
					} 
					if(!empty($check_parting)||$status_check=='0'){
						echo "<th class='header'>Part</th>";
					} 
					if(!empty($check_plastik)||$status_check=='0'){
						echo "<th class='header'>Plastik</th>";
					}
				echo "	<th class='header'>Qty</th>
						<th class='header'>Berat</th>
					</tr>
					<tr>
						<td></td> ";
					if(!empty($check_gudang)||$status_check=='0'){
						echo "<td></td>";
					}
					if(!empty($check_item)||$status_check=='0'){
						echo "<td></td>";
					}
					if(!empty($check_subitem)||$status_check=='0'){
						echo "<td></td>";
					} 
					if(!empty($check_parting)||$status_check=='0'){
						echo "<td></td>";
					} 
					if(!empty($check_plastik)||$status_check=='0'){
						echo "<td></td>";
					}
					echo "<td class='rata-kanan'>" . number_format($total_qty,0) . "</td>
						<td class='rata-kanan'>" . number_format($total_stock,2) . "</td>
					</tr>
					";
				// Menampilkan data
				$counter = "1";
				while ($row = $result->fetch_assoc()) {
					$qty = $row["qty_awal"];
					$berat = $row["berat_awal"];
					$qty = ($qty < -0.0001) ? 'warna-merah' : 'warna-biru';
					$berat = ($berat < -0.0001) ? 'warna-merah' : 'warna-biru';
					echo "<tr> ";
					echo "	<td>" . $counter++ . "</td> ";
					if(!empty($check_gudang)||$status_check=='0'){
						echo "<td>" . $row["code_C"] . "</td>";
					}
					if(!empty($check_item)||$status_check=='0'){
						echo "<td>" . $row["nama"] . "</td>";
					}
					if(!empty($check_subitem)||$status_check=='0'){
						echo "<td>" . $row["sub_item"] . "</td>";
					} 
					if(!empty($check_parting)||$status_check=='0'){
						echo "<td>" . $row["parting"] . "</td>";
					} 
					if(!empty($check_plastik)||$status_check=='0'){
						echo "<td>" . $row["plastik_group"] . "</td>";
					}
					echo "	<td class='rata-kanan $qty'>" . number_format($row["qty_awal"],0,'.',',') . "</td>
							<td class='rata-kanan $berat'>" . number_format($row["berat_awal"],2,'.',',') . "</td>
						  </tr>";
				}
				echo "</table>";
			} else {
				echo "Tidak ada hasil yang ditemukan.";
			}
		} else {
			echo "Error: " . $koneksi->error;
		}
	$koneksi->close();
	}

    // Menutup koneksi
  //  
    ?>
</body>
</html>