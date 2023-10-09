<?php
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
}
include '../../config/config.php';
if(isset($_POST['submit'])){
$kode = $_POST['kode'];
$sql = "SELECT * FROM `tb_tdonasi` WHERE tb_tdonasi.kode = '$kode' ";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);
if( mysqli_num_rows($query) < 1 ){
    $message = 'Bantuan gagal diterima';
}else{
 $result = mysqli_query($conn, "UPDATE `tb_tdonasi` SET `status` = '2' 
 WHERE `tb_tdonasi`.`kode` = '$kode' ");
 if($result){
    $message = 'Bantuan berhasil diterima';
 }
}
}



include 'template_relawan/header.php';
?>

        <!--input kode bantuan-->
        <div class="container mt-4">
                <form method = "POST" action ="">
                    <div class="input-group mb-3">
                        <input type="text" name = "kode" class="form-control" placeholder="Masukan kode donasi" required>
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary" name="submit">Submit</button>
                        </div>
                    </div>
                </form>
        <!--input kode bantuan-->
        </div>
        <div class="container">
        <?php
           if(isset($_POST['submit'])){
            $kode = $_POST['kode'];
            $sql = "SELECT * FROM `tb_tdonasi` WHERE tb_tdonasi.kode = '$kode' ";
            $query = mysqli_query($conn, $sql);
            $data = mysqli_fetch_assoc($query);
        ?>

         <?php if(isset($message)){ ?>
            <div class="alert warning-alert">
                <h4><?=$message?></h4>
                <a class="close">&times;</a>
            </div>
        <?php } ?>
             <!--donasi-->
             <div class="card p-3 mb-3" style="border-color: #82C6EC;">
                    <div>
                    <label style="font-weight: bolder;">Donasi masuk</label>
                        <table>
                            <tr>
                                <td>Beras</td>
                                <td>:</td>
                                <td><?=$data['beras'];?> Kg</td>
                            </tr>
                            <tr>
                                <td>Sembako</td>
                                <td>:</td>
                                <td><?=$data['sembako'];?> Pck</td>
                            </tr>
                            <tr>
                                <td>Pakaian Pria</td>
                                <td>:</td>
                                <td><?=$data['pakaianl'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Pakaian Wanita</td>
                                <td>:</td>
                                <td><?=$data['pakaianp'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Popok Bayi</td>
                                <td>:</td>
                                <td><?=$data['popokb'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Makanan Bayi</td>
                                <td>:</td>
                                <td><?=$data['makananb'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Susu Bayi</td>
                                <td>:</td>
                                <td><?=$data['susub'];?> Pck</td>
                            </tr>
                            <tr>
                                <td>Lain</td>
                                <td>:</td>
                                <td><?=$data['lain'];?> Pck</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--donasi-->
        <?php
            }
        ?>
        </div>

<?php
include 'template_relawan/footer.php'
?>   