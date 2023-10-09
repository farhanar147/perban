<?php
include 'config/config.php'; 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}
include 'template/header.php';

if(isset($_GET['id']) && isset($_GET['aksi'])){
    $id = $_GET['id'];
    $hapus = mysqli_query($conn, "DELETE FROM `tb_regional` WHERE `tb_regional`.`id_regional` = $id");
    if($hapus){
        $message = "Berhasilkan dihapus";
    }else{
        $message = "Gagal dihapus";
    }
}

if(isset($_POST['tambah'])){

    $kelurahan     = $_POST['kelurahan'];
    $kecamatan     = $_POST['kecamatan'];
    $kota          = $_POST['kota'];
    $provinsi      = $_POST['provinsi'];
    $qry = mysqli_query($conn,"INSERT INTO `tb_regional` (`provinsi`, `kota`, `kecamatan`, `kelurahan`) 
    VALUES ('$provinsi', '$kota', '$kecamatan', '$kelurahan')" );

    if($qry){
        $message = "Berhasilkan ditambahkan";
    }else{
        $message = "Gagal ditambalkan";
    }
}

if(isset($_POST['edit'])){
    $id             = $_POST['id'];
    $kelurahan     = $_POST['kelurahan'];
    $kecamatan     = $_POST['kecamatan'];
    $kota          = $_POST['kota'];
    $provinsi      = $_POST['provinsi'];
    $upd = mysqli_query($conn, "UPDATE `tb_regional` SET 
    `provinsi` = '$provinsi', `kota` = '$kota', 
    `kecamatan` = '$kecamatan', 
    `kelurahan` = '$kelurahan' WHERE `tb_regional`.`id_regional` = $id");

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
                    <h4 class="text-center">Regional</h4>
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
                            <th scope="col">Kelurahan</th>
                            <th scope="col">kecamatan</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Provinsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_POST['cari'])){
                            $cari = $_POST['cari'];
                            $query = "SELECT * FROM `tb_regional` 
                            WHERE kelurahan LIKE '%".$cari."%'";
                        }else{
                            $query = "SELECT * FROM `tb_regional` ";
                        }
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$row['kelurahan'];?></td>
                            <td><?=$row['kecamatan'];?></td>
                            <td><?=$row['kota'];?></td>
                            <td><?=$row['provinsi'];?></td>
                            <td><a href="regional.php?aksi=delete&id=<?=$row['id_regional'];?>" class="mr-3" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash"></i></a>
                                <a href="#"  data-toggle="modal" data-target="#edit<?=$row['id_regional'];?>"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <!--edit-->
                        <div class="modal fade" id="edit<?=$row['id_regional'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                        <h4 class="text-center mb-4">Regional</h4>
                                            <form method="POST" action="">
                                                <?php
                                                $id = $row['id_regional'];
                                                $ambil = mysqli_query($conn,"SELECT * FROM `tb_regional` WHERE id_regional = $id");
                                                while($aksi= mysqli_fetch_array($ambil)){
                                                ?>
                                                <input type="hidden" name="id" value="<?=$aksi['id_regional'];?>">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Kelurahan</label>
                                                    <input type="text" name="kelurahan" value="<?=$aksi['kelurahan'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Kecamatan</label>
                                                    <input type="text" name="kecamatan" value="<?=$aksi['kecamatan'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Kota</label>
                                                    <input type="text" name="kota" value="<?=$aksi['kota'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Provinsi</label>
                                                    <input type="text" name="provinsi" value="<?=$aksi['provinsi'];?>" class="form-control"  required>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body">
                        <h4 class="text-center mb-4">Regional</h4>
                        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kelurahan</label>
                                <input type="text" name="kelurahan"  class="form-control"  required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control"  required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Kota</label>
                                <input type="text" name="kota"  class="form-control"  required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Provinsi</label>
                                <input type="text" name="provinsi"  class="form-control"  required>
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
