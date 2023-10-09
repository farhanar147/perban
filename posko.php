<?php
include 'config/config.php'; 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}
include 'template/header.php';

if(isset($_GET['id']) && isset($_GET['aksi'])){
    $id = $_GET['id'];
    $hapus = mysqli_query($conn, "DELETE FROM `tb_posko` WHERE `tb_posko`.`id_posko` = $id");
    if($hapus){
        $message = "Berhasilkan dihapus";
    }else{
        $message = "Gagal dihapus";
    }
}

if(isset($_POST['tambah'])){

    $kode        = $_POST['kode'];
    $id          = $_POST['bencana'];
    $qry = mysqli_query($conn,"INSERT INTO `tb_posko` (`kode_posko`, `perempuan`, `laki_laki`, `balita`, `total`, `id_bencana`) 
    VALUES ('$kode', '0', '0', '0', '0', '$id');" );

    if($qry){
        $message = "Berhasilkan ditambahkan";
    }else{
        $message = "Gagal ditambalkan";
    }
}

if(isset($_POST['edit'])){
    $id          = $_POST['id'];
    $kode        = $_POST['kode'];
    $bencana     = $_POST['bencana'];

    $upd = mysqli_query($conn, "UPDATE `tb_posko` 
    SET `kode_posko` = '$kode', `id_bencana` = '$bencana' 
    WHERE `tb_posko`.`id_posko` = $id");

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
                    <h4 class="text-center">POSKO</h4>
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
                            <th scope="col">Perempuan</th>
                            <th scope="col">Laki-laki</th>
                            <th scope="col">Balita</th>
                            <th scope="col">Total</th>
                            <th scope="col">Bencana</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_POST['cari'])){
                            $cari = $_POST['cari'];
                            $query = "SELECT tb_posko.*, tb_bencana.* FROM `tb_posko` INNER JOIN
                            tb_bencana ON tb_posko.id_bencana = tb_bencana.id_bencana
                            WHERE kode_posko LIKE '%".$cari."%'";
                        }else{
                            $query = "SELECT tb_posko.*, tb_bencana.* FROM `tb_posko` INNER JOIN
                            tb_bencana ON tb_posko.id_bencana = tb_bencana.id_bencana ";
                        }
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$row['kode_posko'];?></td>
                            <td><?=$row['perempuan'];?></td>
                            <td><?=$row['laki_laki'];?></td>
                            <td><?=$row['balita'];?></td>
                            <td><?=$row['total'];?></td>
                            <td><?=$row['bencana'];?></td>
                            <td><a href="posko.php?aksi=delete&id=<?=$row['id_posko'];?>" class="mr-3" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash"></i></a>
                                <a href="#"  data-toggle="modal" data-target="#edit<?=$row['id_posko'];?>"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <!--edit-->
                        <div class="modal fade" id="edit<?=$row['id_posko'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                        <h4 class="text-center mb-4">Posko</h4>
                                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                                <?php
                                                $id = $row['id_posko'];
                                                $ambil = mysqli_query($conn,"SELECT * FROM `tb_posko` WHERE id_posko = $id");
                                                while($aksi= mysqli_fetch_array($ambil)){
                                                ?>
                                                <input type="hidden" name="id" value="<?=$aksi['id_posko'];?>">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Posko</label>
                                                    <input type="text" name="kode" value="<?=$aksi['kode_posko'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Bencana</label>
                                                    <select class="form-control" name="bencana">
                                                    <?php
                                                        $s="SELECT * FROM `tb_bencana`";
                                                        $r = mysqli_query($conn, $s);
                                                        while ($opt = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <option value="<?=$opt['id_bencana'];?>">
                                                        <?=$opt['bencana'];?>
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
                        <h4 class="text-center mb-4">POSKO</h4>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Posko</label>
                                    <input type="text" name="kode" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Bencana</label>
                                    <select class="form-control" name="bencana">
                                    <?php
                                        $sql="SELECT * FROM `tb_bencana`";
                                        $result = mysqli_query($conn, $sql);
                                        while ($how = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?=$how['id_bencana'];?>">
                                        <?=$how['bencana'];?>
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
