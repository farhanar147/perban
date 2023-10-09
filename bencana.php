<?php
include 'config/config.php'; 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}
include 'template/header.php';

if(isset($_GET['id']) && isset($_GET['aksi'])){
    $id = $_GET['id'];
    $hapus = mysqli_query($conn, "DELETE FROM `tb_bencana` WHERE `tb_bencana`.`id_bencana` = $id");
    if($hapus){
        $message = "Berhasilkan dihapus";
    }else{
        $message = "Gagal dihapus";
    }
}

if(isset($_POST['tambah'])){
  
    $bencana     = $_POST['bencana'];
    $date        = $_POST['date'];
    $waktu       = $_POST['waktu'];
    $regional    = $_POST['regional'];
    $qry = mysqli_query($conn,"INSERT INTO `tb_bencana` (`tanggal`, `waktu_akhir`, `bencana`, `id_regional`) 
    VALUES ('$date', '$waktu', '$bencana', '$regional')" );

    if($qry){
        $message = "Berhasilkan ditambahkan";
    }else{
        $message = "Gagal ditambalkan";
    }
}

if(isset($_POST['edit'])){
    $id          = $_POST['id'];
    $bencana     = $_POST['bencana'];
    $date        = $_POST['date'];
    $waktu       = $_POST['waktu'];
    $regional    = $_POST['regional'];

    $upd = mysqli_query($conn, "UPDATE `tb_bencana` 
    SET `tanggal` = '$date', `waktu_akhir`= '$waktu' , `bencana` = '$bencana', `id_regional` = '$regional' 
    WHERE `tb_bencana`.`id_bencana` = $id");

    if($upd){
        $message = "Berhasilkan diedit";
    }else{
        $message = "Gagal diedit";
    }

}


?>

     <!--tabel-->
     <div class="table-responsive">
                <div class="table-wrapper">
                    <h4 class="text-center">Bencana</h4>
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
                            <th scope="col">Bencana</th>
                            <th scope="col">Waktu bencana</th>
                            <th scope="col">Waktu terakhir donasi</th>
                            <th scope="col">Regional</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_POST['cari'])){
                            $cari = $_POST['cari'];
                            $query = "SELECT tb_regional.*, tb_bencana.* FROM `tb_bencana` INNER JOIN
                            tb_regional ON tb_bencana.id_regional = tb_regional.id_regional
                            WHERE bencana LIKE '%".$cari."%'";
                        }else{
                            $query = "SELECT tb_regional.*, tb_bencana.* FROM `tb_bencana` INNER JOIN
                            tb_regional ON tb_bencana.id_regional = tb_regional.id_regional ";
                        }
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$row['bencana'];?></td>
                            <td><?=$row['tanggal'];?></td>
                            <td><?=$row['waktu_akhir'];?></td>
                            <td>
                                <?php
                                echo $row['kelurahan'];
                                echo ', ';
                                echo $row['kecamatan'];
                                echo ', ';
                                echo $row['kota'];
                                echo ', ';
                                echo $row['provinsi'];
                                ?>
                            </td>
                            <td><a href="bencana.php?aksi=delete&id=<?=$row['id_bencana'];?>" class="mr-3" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash"></i></a>
                                <a href="#"  data-toggle="modal" data-target="#edit<?=$row['id_bencana'];?>"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <!--edit-->
                        <div class="modal fade" id="edit<?=$row['id_bencana'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                        <h4 class="text-center mb-4">Bencana</h4>
                                            <form method="POST" action="">
                                                <?php
                                                $id = $row['id_bencana'];
                                                $ambil = mysqli_query($conn,"SELECT * FROM `tb_bencana` WHERE id_bencana = $id");
                                                while($aksi= mysqli_fetch_array($ambil)){
                                                ?>
                                                <input type="hidden" name="id" value="<?=$aksi['id_bencana'];?>">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Bencana</label>
                                                    <input type="text" name="bencana" value="<?=$aksi['bencana'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Waktu</label>
                                                    <input type="date" name="date" value="<?=$aksi['tanggal'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Waktu Donasi</label>
                                                    <input type="date" name="waktu" value="<?=$aksi['waktu_akhir'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Region</label>
                                                    <select class="form-control" name="regional">
                                                    <?php
                                                        $s="SELECT * FROM `tb_regional`";
                                                        $r = mysqli_query($conn, $s);
                                                        while ($opt = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <option value="<?=$opt['id_regional'];?>">
                                                        <?php
                                                        echo $opt['kelurahan'];
                                                        echo ', ';
                                                        echo $opt['kecamatan'];
                                                        echo ', ';
                                                        echo $opt['kota'];
                                                        echo ', ';
                                                        echo $opt['provinsi'];
                                                        ?>
                                                    </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mt-3 mb-4">
                                                    <button name="edit" class="btn btn-primary btn-lg btn-block">Submit</button>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </form>
                                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>                                   
                        <!--edit-->
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                     <button class="btn btn-success" data-toggle="modal" data-target="#tambah">Tambah</button>
                </div>
        </div>
        <!--tabel-->

        <!--tambah-->
        <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                        <h4 class="text-center mb-4">Bencana</h4>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bencana</label>
                                    <input type="text" name="bencana" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tanggal</label>
                                    <input type="date" name="date" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Waktu Donasi</label>
                                    <input type="date" name="waktu" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Region</label>
                                    <select class="form-control" name="regional">
                                    <?php
                                        $sql="SELECT * FROM `tb_regional`";
                                        $result = mysqli_query($conn, $sql);
                                        while ($how = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?=$how['id_regional'];?>">
                                        <?php
                                        echo $how['kelurahan'];
                                        echo ', ';
                                        echo $how['kecamatan'];
                                        echo ', ';
                                        echo $how['kota'];
                                        echo ', ';
                                        echo $how['provinsi'];
                                        ?>
                                    </option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="mt-3 mb-4">
                                    <button name="tambah" class="btn btn-primary btn-lg btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--tambah-->

       



<?php
include 'template/footer.php';
?>
