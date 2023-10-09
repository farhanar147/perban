<?php
error_reporting(0);
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
   
}

include '../config/config.php';
include 'template/header.php';

?>

    <!--input kode-->
    <div class="container">
        <div class="col-md-12 mt-4">
            <form method ="POST" action="track.php">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"  name="kode" placeholder="Masukan kode bantuan"  aria-describedby="basic-addon2" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="submit">Tracking</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--input kode-->

    <?php
        if(isset($_POST['kode'])){
            $kode = $_POST['kode'];
            $query = "SELECT * FROM `tb_donasi` WHERE kode_donasi LIKE '$kode' " ;
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            $status = $row['status'];
        }else{
            $status = 0;
        } ?>

            <div class="container">
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">Kode Donasi</th>
                        <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($status == 1){
                        ?>
                        <tr>
                        <td><?=$kode;?></td>
                        <td><span class="badge badge-warning">Diproses</span></td>
                        </tr>
                        <?php
                        }elseif($status == 2){
                        ?>
                        <tr>
                        <td><?=$kode;?></td>
                        <td><span class="badge badge-success">Diterima</span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
            </div>

    <!--Bantuan-->
    <div class="container">
        <div class="col-md-12 mt-4">
            <label style="font-weight: bold;">Kode Bantuan</label>
        <?php
        $sik =   $_SESSION['email'] ;
        $sql="SELECT tb_donasi.kode_donasi, tb_bencana.bencana, tb_donasi.id_donatur, tb_donatur.email 
        FROM tb_donasi 
        INNER JOIN tb_bencana ON  tb_bencana.id_bencana = tb_donasi.id_bencana 
        INNER JOIN tb_donatur ON tb_donatur.id_donatur = tb_donasi.id_donatur
        WHERE email = '$sik'";
        $result = mysqli_query($conn, $sql);
        
        while($data = mysqli_fetch_array($result)) {
        ?>
            <div class="card mt-2">
                <div class="card-body">
                <?=$data['kode_donasi'];?> - <?=$data['bencana'];?>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    <!--Bantuan-->
<?php
include 'template/footer.php'
?>