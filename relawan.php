<?php
include 'config/config.php'; 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}
include 'template/header.php';

if(isset($_GET['id']) && isset($_GET['aksi'])){
    $id = $_GET['id'];
    $hapus = mysqli_query($conn, "DELETE FROM `tb_relawan` WHERE `tb_relawan`.`id_relawan` = $id");
    if($hapus){
        $message = "Berhasilkan dihapus";
    }else{
        $message = "Gagal dihapus";
    }
}

if(isset($_POST['tambah'])){

    $nik        = $_POST['nik'];
    $nama       = $_POST['nama'];
    $no_hp      = $_POST['no_hp'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];
    $posko      = $_POST['posko'];
    $qry = mysqli_query($conn,"INSERT INTO `tb_relawan` 
    (`nik`, `nama`, `no_hp`, `id_posko`, `email`, `password`) 
    VALUES ('$nik', '$nama', '$no_hp', '$posko', '$email', '$password')" );

    if($qry){
        $message = "Berhasilkan ditambahkan";
    }else{
        $message = "Gagal ditambalkan";
    }
}

if(isset($_POST['edit'])){
    $id       = $_POST['id'];
    $nik      = $_POST['nik'];
    $nama     = $_POST['nama'];
    $no_hp    = $_POST['no_hp'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $posko    = $_POST['posko'];
    $upd = mysqli_query($conn, "UPDATE `tb_relawan` 
    SET `nik` = '$nik', `nama` = '$nama', `no_hp` = '$no_hp', `id_posko` = '$posko', `email` = '$email', `password` = '$password' 
    WHERE `tb_relawan`.`id_relawan` = $id ");

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
                    <h4 class="text-center">RELAWAN</h4>
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
                            <th scope="col">NIK</th>
                            <th scope="col">Nama</th>
                            <th scope="col">No.HP</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                            <th scope="col">Posko</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_POST['cari'])){
                            $cari = $_POST['cari'];
                            $query = "SELECT tb_posko.kode_posko, tb_relawan.* FROM `tb_relawan` INNER JOIN
                            tb_posko ON tb_relawan.id_posko = tb_posko.id_posko
                            WHERE nama LIKE '%".$cari."%'";
                        }else{
                            $query = "SELECT tb_posko.kode_posko, tb_relawan.* FROM `tb_relawan` INNER JOIN
                            tb_posko ON tb_relawan.id_posko = tb_posko.id_posko";
                        }
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$row['nik'];?></td>
                            <td><?=$row['nama'];?></td>
                            <td><?=$row['no_hp'];?></td>
                            <td><?=$row['email'];?></td>
                            <td>xxxxxxxx</td>
                            <td><?=$row['kode_posko'];?></td>
                            <td><a href="relawan.php?aksi=delete&id=<?=$row['id_relawan'];?>" class="mr-3" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash"></i></a>
                                <a href="#"  data-toggle="modal" data-target="#edit<?=$row['id_relawan'];?>"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <!--edit-->
                        <div class="modal fade" id="edit<?=$row['id_relawan'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                        <h4 class="text-center mb-4">Relawan</h4>
                                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                                <?php
                                                $id = $row['id_relawan'];
                                                $ambil = mysqli_query($conn,"SELECT * FROM `tb_relawan` WHERE id_relawan = $id");
                                                while($aksi= mysqli_fetch_array($ambil)){
                                                ?>
                                                <input type="hidden" name="id" value="<?=$aksi['id_relawan'];?>">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">NIK</label>
                                                    <input type="number" name="nik" value="<?=$aksi['nik'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nama</label>
                                                    <input type="text" name="nama" value="<?=$aksi['nama'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">No.HP</label>
                                                    <input type="text" name="no_hp" value="<?=$aksi['no_hp'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">email</label>
                                                    <input type="email" name="email" value="<?=$aksi['email'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Password</label>
                                                    <input type="text" name="password" value="<?=$aksi['password'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlInput1">Posko</label>
                                                    <select class="form-control" name="posko">
                                                    <?php
                                                        $s="SELECT * FROM `tb_posko`";
                                                        $r = mysqli_query($conn, $s);
                                                        while ($opt = mysqli_fetch_assoc($r)){
                                                    ?>
                                                    <option value="<?=$opt['id_posko'];?>">
                                                        <?=$opt['kode_posko'];?>
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
                        <h4 class="text-center mb-4">Relawan</h4>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">NIK</label>
                                    <input type="number" name="nik" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">nama</label>
                                    <input type="text" name="nama" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">No.HP</label>
                                    <input type="text" name="no_hp" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">email</label>
                                    <input type="email" name="email" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="text" name="password" class="form-control"  required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Posko</label>
                                    <select class="form-control" name="posko">
                                    <?php
                                        $sql="SELECT * FROM `tb_posko`";
                                        $result = mysqli_query($conn, $sql);
                                        while ($how = mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?=$how['id_posko'];?>">
                                        <?=$how['kode_posko'];?>
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
