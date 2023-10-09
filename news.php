<?php
include 'config/config.php'; 
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}
include 'template/header.php';

if(isset($_GET['id']) && isset($_GET['aksi'])){
    $id = $_GET['id'];
    $hapus = mysqli_query($conn, "DELETE FROM `tb_news` WHERE `tb_news`.`id_news` = $id");
    if($hapus){
        $message = "Berhasilkan dihapus";
    }else{
        $message = "Gagal dihapus";
    }
}

if(isset($_POST['tambah'])){
    $namafile = $_FILES['gambar']['name'];  
    $ukuran = $_FILES['gambar']['size'];  
    $move = move_uploaded_file($_FILES['gambar']['tmp_name'], 'news/'.$namafile);
    $judul         = $_POST['judul'];
    $news          = $_POST['news'];
    $date          = $_POST['date'];
    $penulis       = $_POST['penulis'];
    $referensi     = $_POST['referensi'];
    $qry = mysqli_query($conn,"INSERT INTO `tb_news` (`judul`, `gambar`, `news`, `date`, `penulis`,`referensi`) 
    VALUES ('$judul', '$namafile', '$news', '$date', '$penulis', '$referensi')" );

    if($qry){
        $message = "Berhasilkan ditambahkan";
    }else{
        $message = "Gagal ditambalkan";
    }
}

if(isset($_POST['edit'])){
    $namafile = $_FILES['gambar']['name'];  
    $ukuran = $_FILES['gambar']['size'];  
    $move = move_uploaded_file($_FILES['gambar']['tmp_name'], 'news/'.$namafile);
    $id            = $_POST['id'];
    $judul         = $_POST['judul'];
    $news          = $_POST['news'];
    $date          = $_POST['date'];
    $penulis       = $_POST['penulis'];
    $referensi     = $_POST['referensi'];
    $upd = mysqli_query($conn, "UPDATE `tb_news` SET 
    `gambar` = '$namafile', `judul` = '$judul', `news` = '$news', 
    `date` = '$date', `penulis` = '$penulis', 
    `referensi` = '$referensi' WHERE `tb_news`.`id_news` = $id");

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
                    <h4 class="text-center">News</h4>
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
                            <th scope="col">Judul</th>
                            <th scope="col">Foto</th>
                            <th scope="col">News</th>
                            <th scope="col">Date</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Referensi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        if(isset($_POST['cari'])){
                            $cari = $_POST['cari'];
                            $query = "SELECT * FROM `tb_news` 
                            WHERE news LIKE '%".$cari."%'";
                        }else{
                            $query = "SELECT * FROM `tb_news` ";
                        }
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)){
                            $kalimat = $row['news'];
                            $news = substr($kalimat,0,100);
                        ?>
                        <tr>
                            <td><?=$row['judul'];?></td>
                            <td> <img src="news/<?=$row['gambar'];?>" style="height:50px;" alt="news" loading="lazy" /></td>
                            <td><?=$news;?></td>
                            <td><?=$row['date'];?></td>
                            <td><?=$row['penulis'];?></td>
                            <td><?=$row['referensi'];?></td>
                            <td><a href="news.php?aksi=delete&id=<?=$row['id_news'];?>" class="mr-3" onclick="return confirm('Yakin Hapus?')"><i class="fa fa-trash"></i></a>
                                <a href="#"  data-toggle="modal" data-target="#edit<?=$row['id_news'];?>"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        <!--edit-->
                        <div class="modal fade" id="edit<?=$row['id_news'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">
                                        <h4 class="text-center mb-4">News</h4>
                                            <form method="POST" action="" enctype="multipart/form-data">
                                                <?php
                                                $id = $row['id_news'];
                                                $ambil = mysqli_query($conn,"SELECT * FROM `tb_news` WHERE id_news = $id");
                                                while($aksi= mysqli_fetch_array($ambil)){
                                                ?>
                                                <input type="hidden" name="id" value="<?=$aksi['id_news'];?>">
                                                <div class="form-group">
                                                    <label for="exampleFormControlFile1">Foto</label>
                                                    <input type="file" name="gambar" value="<?=$aksi['gambar'];?>"  class="form-control-file" id="exampleFormControlFile1" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Judul</label>
                                                    <input type="text" name="judul" value="<?=$aksi['judul'];?>"  class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">News</label>
                                                    <textarea class="form-control" name="news"  id="exampleFormControlTextarea1" rows="3"><?=$aksi['news'];?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Date</label>
                                                    <input type="" name="date" value="<?=$aksi['date'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Penulis</label>
                                                    <input type="text" name="penulis" value="<?=$aksi['penulis'];?>" class="form-control"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Referensi</label>
                                                    <input type="text" name="referensi" value="<?=$aksi['referensi'];?>" class="form-control"  required>
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
                        <h4 class="text-center mb-4">News</h4>
                        <form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Foto</label>
                            <input type="file" name="gambar" class="form-control-file" id="exampleFormControlFile1" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">judul</label>
                            <input type="text" name="judul"  class="form-control"  required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">News</label>
                            <textarea class="form-control" name="news"  id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="date" name="date"  class="form-control"  required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Penulis</label>
                            <input type="text" name="penulis"  class="form-control"  required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Referensi</label>
                            <input type="text" name="referensi" class="form-control"  required>
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
