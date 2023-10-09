<?php
include 'config/config.php';

 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}

include 'template/header.php';

if(isset($_POST['submit'])){
$kode = $_POST['kode'];
$sql = "SELECT * FROM `tb_donasi` WHERE tb_donasi.kode_donasi = '$kode' ";
$query = mysqli_query($conn, $sql);

if( mysqli_num_rows($query) < 1 ){
    $message = 'Bantuan gagal diterima';
}else{
 $result = mysqli_query($conn, "UPDATE `tb_donasi` SET `status` = '2' 
 WHERE `tb_donasi`.`kode_donasi` = '$kode' ");
 if($result){
    $message = 'Bantuan berhasil diterima';
 }
}
}

?>

         
         <div class="container mt-4">
              <div class="col-5">
              <label>Terima Donasi :</label>
                <form method = "POST" action ="">
                    <div class="input-group mb-3">
                        <input type="text" name = "kode" class="form-control" placeholder="Masukan kode donasi" required>
                        <div class="input-group-append">
                        <button class="btn btn-outline-secondary" name="submit">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
        <!--input kode bantuan-->
        <!--tabel-->
         <div class="table-responsive">
                <div class="table-wrapper">
                    <h4 class="text-center">Donasi</h4>
                    <?php
                        if(isset($message)){
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><?=$message?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php } ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Kode Donasi</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Bencana</th>
                            <th scope="col">Beras</th>
                            <th scope="col">Sembako</th>
                            <th scope="col">Pakaian Perempuan</th>
                            <th scope="col">Pakaian Laki-laki</th>
                            <th scope="col">Popok Bayi</th>
                            <th scope="col">Makanan Bayi</th>
                            <th scope="col">Susu Bayi</th>
                            <th scope="col">Lainnya</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $query = "SELECT tb_donasi.*, tb_bencana.bencana FROM `tb_donasi`
                        INNER JOIN tb_bencana ON tb_donasi.id_bencana = tb_bencana.id_bencana
                        WHERE tb_donasi.status = '2'
                        ORDER BY `tb_donasi`.`id_bencana` ASC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$row['kode_donasi'];?></td>
                            <td> <img src="mobile/donasi/<?=$row['gambar_donasi'];?>" style="height:50px;" alt="MDB Logo" loading="lazy" /></td>
                            <td><?=$row['bencana'];?></td>
                            <td><?=$row['beras'];?></td>
                            <td><?=$row['sembako'];?></td>
                            <td><?=$row['pakaian_perempuan'];?></td>
                            <td><?=$row['pakaian_laki_laki'];?></td>
                            <td><?=$row['popok_bayi'];?></td>
                            <td><?=$row['makanan_bayi'];?></td>
                            <td><?=$row['susu_bayi'];?></td>
                            <td><?=$row['lainnya'];?></td>
                            <td><?php 
                            $status =  $row['status'];
                            if($status == 1){
                                echo "Diproses";
                            }elseif($status == 2){
                                echo "Diterima dicenter";
                            }else{
                                echo "Diterima diposko bencana";
                            }
                            ?>
                            </td>

                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <!--tabel-->



<?php
include 'template/footer.php';

?>