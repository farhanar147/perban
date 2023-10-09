<?php

include 'config/config.php';

function randomString($length)
{
    $str        = "";
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
$huruf = randomString(5);
$kode = $huruf;
$id_bencana = $_POST['id_bencana'];
$id_posko = $_POST['id_posko'];
$waktu = $_POST['waktu'];
$beras = $_POST['beras'];
$sembako = $_POST['sembako'];
$pakaianp = $_POST['pakaianp'];
$pakaianl = $_POST['pakaianl'];
$popok = $_POST['popok'];
$makanan = $_POST['makanan'];
$susu = $_POST['susu'];
$lain = $_POST['lain'];

$sql = "INSERT INTO `tb_tdonasi` (`id_bencana`, `id_posko`, `waktu`, `kode`, `beras`, `sembako`, 
`pakaianp`, `pakaianl`, `popokb`, `makananb`, `susub`, `lain`, `status`) 
VALUES ('$id_bencana', '$id_posko', '$waktu', '$kode', '$beras', '$sembako', '$pakaianp', '$pakaianl', 
'$popok', '$makanan', '$susu', '$lain', '1')";

if (mysqli_query($conn, $sql)) {
    session_start();
    $_SESSION['aksi'] = 1;
    header("Location: kirim.php");
} else{
    session_start();
    $_SESSION['aksi'] = 2;
    header("Location: kirim.php");
}
 