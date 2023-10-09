<?php
include '../config/config.php';

//gambar upload
$namafile = $_FILES['gambar']['name'];  
$ukuran = $_FILES['gambar']['size'];  
$move = move_uploaded_file($_FILES['gambar']['tmp_name'], 'donasi/'.$namafile); 

$id = $_POST['id_bencana'];
$kode = $_POST['kode_bencana'];
$id_donatur = $_POST['id_donatur'];
$beras = $_POST['beras'];
$sembako = $_POST['sembako'];
$pakaianp = $_POST['pakaianp'];
$pakaianl = $_POST['pakaianl'];
$popok = $_POST['popok'];
$makanan = $_POST['makanan'];
$susu = $_POST['susu'];
$lain = $_POST['lain'];
$status = 1;
$ket = $_POST['ket'];
$wdonasi = $_POST['wdonasi'];

$sql = "INSERT INTO `tb_donasi` (`id_donatur`, 
`id_bencana`, `kode_donasi`, `waktu_donasi`, `beras`, `sembako`, `pakaian_perempuan`, 
`pakaian_laki_laki`, `popok_bayi`, `makanan_bayi`, `susu_bayi`,
 `lainnya`, `gambar_donasi`, `keterangan`, `status`) 
VALUES ($id_donatur , $id, '$kode', '$wdonasi', $beras, $sembako , $pakaianp , $pakaianl, 
$popok, $makanan, $susu, $lain, '$namafile', $ket, $status)";


if (mysqli_query($conn, $sql)) {
    session_start();
    $_SESSION['kode'] = "$kode";
    header("Location: kode.php");
} else {
        $message = "Gagal Silakan Coba lagi";
        session_start();
        $_SESSION['massage'] = $message;
        header("Location: donasi.php");
}


?>