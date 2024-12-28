<?php

$subsidiary = 'CGL';
//$subsidiary = 'EBA';
$posisi = 'LOCAL';
//$posisi = 'DDNS';




if($subsidiary=='CGL'){
    if($posisi=='LOCAL'){
        $hostname = '192.168.1.253:33062'; //CGL
        $url_cgl = '192.168.1.253:90'; //CGL
    }
    if($posisi=='DDNS'){
        $hostname = 'cgl2022.myddns.me:8234';
        $url_cgl = 'cgl2022.myddns.me:8889'; //CGL
    }
}
if($subsidiary=='EBA'){
    if($posisi=='LOCAL'){
        $hostname = '192.168.1.105:3306';
        $url_cgl = '192.168.1.105';
    }
    if($posisi=='DDNS'){
        $hostname = 'eba2022.myddns.me:3306'; // EBA
        $url_cgl = 'eba2022.myddns.me';
    }
}   
    $username = 'adminproduksi';
    $password = 'adminproduksi';
    $database = 'cglver2';

    //konfigurasi local
    $host = 'localhost'; 
    //$user = 'root';   
    $pass = '';      
    //$dbname = 'cgl';
    //$host = '192.168.1.51'; 
    $user = 'root';   
    //$pass = 'admin@123';      
    $dbname = 'cgl';

    // URL admin chiller
    $chiller_url = "http://$url_cgl/admin/chiller/";
    $gudang_url ="http://$url_cgl/admin/warehouse/tracing/";
    $siapkirim_url ="http://$url_cgl/admin/editso/";
    $regu_url ="http://$url_cgl/admin/produksi-regu?kategori=";



if($subsidiary == 'CGL'){
    $gudangCS = 'CGL - Cold Storage';
    $gudangCS1 = 'CGL - Cold Storage 1';
    $gudangCS2 = 'CGL - Cold Storage 2';
    $gudangCS3 = 'CGL - Cold Storage 3';
    $gudangCS4 = 'CGL - Cold Storage 4';
    $gudangCS5 = 'CGL - Cold Storage 5';
    $gudangCS6 = 'CGL - Cold Storage 6';
    $gudangMuaraBaru = 'CGL - Muara Baru';
    $gudangManis = 'CGL - Manis';
    //tanggal SO
    $SO_CS = '2024-04-27';
    $SO_CS1 = '2024-04-27';
    $SO_CS2 = '2024-07-27';
    $SO_CS3 = '2024-04-27';
    $SO_CS4 = '2024-04-27';
    $SO_CS5 = '2024-04-27';
    $SO_CS6 = '2024-04-27';
    $SO_CS_Manis = '2024-04-27';
    $SO_CS_MuaraBaru = '2024-04-27';
}
if($subsidiary == 'EBA'){
    $gudangCS = 'EBA - Cold Storage';
    $gudangCS1 = 'EBA - Cold Storage 1';
    $gudangCS2 = 'EBA - Cold Storage 2';
    $gudangCS3 = 'EBA - Cold Storage 3';
    $gudangCS4 = 'EBA - Cold Storage 4';
    $gudangCS5 = 'EBA - Cold Storage 5';
    $gudangCS6 = 'EBA - Cold Storage 6';
    //tanggal SO
    $SO_CS = '2024-04-22'; 
    $SO_CS1 = '2024-04-22';
    $SO_CS2 = '2024-04-22';
    $SO_CS3 = '2024-04-22';
    $SO_CS4 = '2024-04-22';
    $SO_CS5 = '2024-04-22';
    $SO_CS6 = '2024-04-22';
    $SO_CS_Manis = '2024-04-22';
    $SO_CS_MuaraBaru = '2024-04-22';
}
?>
