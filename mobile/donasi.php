<?php
include '../config/config.php';
error_reporting(0);
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}

include 'template/header.php';
// kalau tidak ada id di query string
if( !isset($_GET['id']) ){
    header('Location: index.php');
}

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
$kodeDonasi = $huruf;

//ambil id dari query string
$id = $_GET['id'];

//ambil judul
$sql = "SELECT * from tb_bencana  WHERE id_bencana=$id";
        $query = mysqli_query($conn, $sql);
        $da = mysqli_fetch_assoc($query);

//ambil id donatur
$email = $_SESSION['email'];
$qr = "SELECT * FROM `tb_donatur` WHERE email = '$email' ";
$qry = mysqli_query($conn, $qr);
$dt = mysqli_fetch_assoc($qry);
?>

<!--Donasi-->
<div class="container">
        <div class="col-md-12">
            <h4 class="text-center mb-4">Donasi <?=$da['bencana'];?></h4>
            <?php 
                session_start();
                if(isset($_SESSION['massage'])){ ?>
                    <div class="alert warning-alert" >
                        <h4><?=$_SESSION['massage'];?></h4>
                        <a class="close">&times;</a>
                    </div>
            <?php }?>
            <form method="POST" action="aksidonasi.php" enctype="multipart/form-data">
                <input type="hidden" name="id_bencana" value="<?=$id;?>">
                <input type="hidden" name="kode_bencana" value="<?=$kodeDonasi;?>">
                <input type="hidden" name="id_donatur" value="<?=$dt['id_donatur'];?>">
                <input type="hidden" name="wdonasi" value="<?=date("Y-m-d"); ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Beras</label>
                    <input type="number" name="beras" class="form-control" id="exampleInputEmail1"  placeholder="Dalam bentuk kg" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Paket sembako</label>
                    <input type="number" name="sembako" class="form-control" id="exampleInputEmail1"  placeholder="Dalam bentuk paket sembako" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Pakaian Perempuan</label>
                    <input type="number" name="pakaianp" class="form-control" id="exampleInputEmail1"  placeholder="dalam bentuk pcs" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Pakaian Laki-laki</label>
                    <input type="number" name="pakaianl" class="form-control" id="exampleInputEmail1"  placeholder="dalam bentuk pcs" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Popok Bayi</label>
                    <input type="number" name="popok" class="form-control" id="exampleInputEmail1"  placeholder="dalam bentuk pcs" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Makanan Bayi</label>
                    <input type="number"  name="makanan" class="form-control" id="exampleInputEmail1"  placeholder="dalam bentuk paket" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Susu Bayi</label>
                    <input type="number" name="susu" class="form-control" id="exampleInputEmail1"  placeholder="150g = 1 paket" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Lainnya</label>
                    <input type="number" name="lain" class="form-control" id="exampleInputEmail1"  placeholder="jumlah donasi" required>
                    <small id="emailHelp" class="form-text text-muted">tulis 0 saja jika anda hanya memberikan beberapa item</small>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Foto Donasi Anda</label>
                    <input type="file" name="gambar" accept="image/*" class="form-control-file" id="exampleFormControlFile1" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ket" id="exampleRadios1" value="1" checked>
                    <small class="form-check-label" for="exampleRadios1">
                        Kirim Sendiri Bantuan ke Center Donasi
                    </small>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="ket" id="exampleRadios2" value="2">
                    <small class="form-check-label" for="exampleRadios2">
                        Dikirim mengunakan kurir dan biaya pribadi
                    </small>
                </div>
                <div class="mt-3 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!--Donasi-->

<?php
include 'template/footer.php'
?>