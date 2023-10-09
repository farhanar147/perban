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

        <!--tabel-->
         <div class="table-responsive">
                <div class="table-wrapper">
                    <h4 class="text-center">Donasi Tersalurkan</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Bencana</th>
                            <th scope="col">Posko</th>
                            <th scope="col">Waktu</th>
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
                        $query = "SELECT tb_tdonasi.*, tb_bencana.bencana, tb_posko.kode_posko FROM `tb_tdonasi`
                        INNER JOIN tb_bencana ON tb_tdonasi.id_bencana = tb_bencana.id_bencana
                        INNER JOIN tb_posko ON tb_tdonasi.id_posko = tb_posko.id_posko
                        ORDER BY `tb_tdonasi`.`id_bencana` ASC";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$row['kode'];?></td>
                            <td><?=$row['bencana'];?></td>
                            <td><?=$row['kode_posko'];?></td>
                            <td><?=$row['waktu'];?></td>
                            <td><?=$row['beras'];?></td>
                            <td><?=$row['sembako'];?></td>
                            <td><?=$row['pakaianp'];?></td>
                            <td><?=$row['pakaianl'];?></td>
                            <td><?=$row['popokb'];?></td>
                            <td><?=$row['makananb'];?></td>
                            <td><?=$row['susub'];?></td>
                            <td><?=$row['lain'];?></td>
                            <td><?php 
                            $status =  $row['status'];
                            if($status == 1){
                                echo "Dikirim";
                            }elseif($status == 2){
                                echo "Diterima diposko";
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