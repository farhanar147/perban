<?php
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
}
include '../../config/config.php';
// kalau tidak ada id di query string
if( !isset($_GET['id']) ){
    header('Location: posko.php');
}
if(isset($_POST['submit'])){
    $id         = $_POST['id'];
    $perempuan  = $_POST['perempuan'];
    $laki       = $_POST['laki'];
    $balita     = $_POST['balita'];
    $total      = $perempuan+$laki+$balita;

    $sql="UPDATE `tb_posko` SET `perempuan` = '$perempuan', `laki_laki` = '$laki', `balita` = '$balita', `total` = '$total' 
          WHERE `tb_posko`.`id_posko` = '$id'";
    $query = mysqli_query($conn, $sql);
    if($query){
        $message = "Berhasil Diupdate";
    }else{
        $message = "Gagal Diupdate";
    }

}
$id = $_GET['id'];
$query = "SELECT * FROM `tb_posko` WHERE id_posko = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

include 'template_relawan/header.php';
?>

    <!--Data Korban-->
    <div class="container">
    <?php if(isset($message)){ ?>
        <div class="alert warning-alert">
            <h4><?=$message?></h4>
            <a class="close">&times;</a>
        </div>
    <?php } ?>
        <div class="col-md-12">
            <h5 class="text-center mb-4">Update Pengungsi di<?=$data['kode_posko']; ?> </h5>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?=$data['id_posko'];?>" >
                <div class="form-group"> 
                    <label for="exampleInputEmail1">Korban Perempuan</label>
                    <input type="number" name="perempuan" value="<?=$data['perempuan'];?>" class="form-control" id="exampleInputEmail1"  placeholder="100" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Korban Laki-laki</label>
                    <input type="number" name="laki" value="<?=$data['laki_laki'];?>" class="form-control" id="exampleInputEmail1"  placeholder="100" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Korban Balita</label>
                    <input type="number" name="balita" value="<?=$data['balita'];?>" class="form-control" id="exampleFormControlInput1" placeholder="10" required>
                </div>
                <div class="mt-3 mb-4">
                    <button name="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!--Data korban-->   



<?php
include 'template_relawan/footer.php'
?>