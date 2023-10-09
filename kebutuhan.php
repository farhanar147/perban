<?php
include 'config/config.php'; 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}
include 'template/header.php';
?>

     <!--tabel-->
     <div class="table-responsive">
                <div class="table-wrapper">
                    <h4 class="text-center">Kebutuhan POSKO</h4>
                    <form  action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                        <div class="col-5">
                            <div class="input-group mb-3">
                            <?php
                            $cari="";
                            if (isset($_POST['cari'])) {
                                $kata_kunci=$_POST['cari'];
                            }
                            ?>
                                <input name="cari" value="<?php echo $cari;?>" type="text" class="form-control" placeholder="Search" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                  <button class="btn btn-outline-secondary" type="submit" value="Cari">Cari</button>
                                </div>
                                <button class="btn btn-primary ml-2">Refresh</button>
                            </div>
                        </div>
                    </form>
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
                            <th scope="col">Posko</th>
                            <th scope="col">Bencana</th>
                            <th scope="col">Beras</th>
                            <th scope="col">Sembako</th>
                            <th scope="col">Pakaian Perempuan</th>
                            <th scope="col">Pakaian Laki-laki</th>
                            <th scope="col">Popok Bayi</th>
                            <th scope="col">Makanan Bayi</th>
                            <th scope="col">Susu Bayi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $query = "SELECT 
                                  tb_posko.*,
                                  tb_bencana.bencana
                                  from tb_bencana INNER JOIN 
                                  tb_posko ON tb_posko.id_bencana = tb_bencana.id_bencana";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        $sembako = $row['perempuan']+$row['laki_laki'];
                        $rice = $sembako * 0.4;
                        $susu = $row['balita'] * 4;
                        $bayi = $row['balita'];
                        ?>
                        <tr>
                            <td><?=$row['kode_posko'];?></td>
                            <td><?=$row['bencana'];?></td>
                            <td><?=$rice;?></td>
                            <td><?=$sembako;?></td>
                            <td><?=$row['perempuan'];?></td>
                            <td><?=$row['laki_laki'];?></td>
                            <td><?=$bayi;?></td>
                            <td><?=$bayi;?></td>
                            <td><?=$bayi;?></td>
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
