<?php
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}

include '../config/config.php';
include 'template/header_home.php';
?>

<div class="container">
        <!-- news-->
        <div class="row mb-3">
            <div class="col-md-12">
                <div id="news-slider" class="owl-carousel">
                <?php
                    $query = "SELECT * FROM `tb_news` ";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)){
                    $kalimat = $row['news'];
                    $news = substr($kalimat,0,120);
                ?>
                    <div class="post-slide">
                        <div class="post-header">
                            <a href="<?=$row['referensi'];?>" class="subtitle"><?=$row['judul'];?></a>
                        </div>
                        <div class="pic">
                            <img src="../news/<?=$row['gambar'];?>" alt="">
                        </div>
                        <ul class="post-bar">
                            <li><i class="fa fa-users"></i> <a href="#">Admin</a></li>
                            <li><i class="fa fa-clock-o"></i> <?=$row['date'];?></li>
                        </ul>
                        <p class="post-description">
                           <?=$news;?>
                        </p>
                        <a href="<?=$row['referensi'];?>" class="read-more">read more</a>
                    </div>
                <?php } ?>

                </div>
            </div>
        </div>
        <!-- news-->

        <!--cek-->
        <div class="mb-3">
            <a href="track.php" class="btn btn-info btn-lg btn-block">Tracking Bantuan</a>
        </div>
        <!--cek-->

        <!--list logistik-->
        <?php
         $sekarang  = date("Y-m-d");
         $data = mysqli_query($conn, "SELECT * FROM `tb_bencana` WHERE waktu_akhir >= '$sekarang' ");
         while($d = mysqli_fetch_array($data)){
         $id = $d['id_bencana'];
        ?>
        <div class="card" style="width: auto; margin-bottom: 2em;">
        <?php
        $sql = "SELECT SUM(total) as pengungsi,
        SUM(perempuan) as perempuan, 
        SUM(balita) as balita, 
        SUM(laki_laki) as pria
        from tb_bencana INNER JOIN 
        tb_posko ON tb_posko.id_bencana = tb_bencana.id_bencana 
        WHERE tb_bencana.id_bencana=$id ";
        $query = mysqli_query($conn, $sql);
        $da = mysqli_fetch_assoc($query);
        $sembako = $da['pria']+$da['perempuan'];
        ?>
            <div class="card-body">
                <h5 class="card-title"><?= $d['bencana']?></h5>
                <p style="font-weight: bold;">Jumlah Pengungsi : <?= $da['pengungsi']; ?> </p>
                <p style="font-weight: bolder;">Kebutuhan Korban</p>
                <p>Sembako : <span><?= $sembako ?> </span>Pack</p>
                <p>Popok Bayi : <span> <?= $da['balita']; ?>  </span>Pack</p>
                <p>Pakaian Laki-laki : <span> <?= $da['pria']; ?>  </span>Pieces</p>
                <p>Pakaian Perempuan : <span> <?= $da['perempuan']; ?>  </span>Pieces</p>
                <a href="informasi.php?id=<?=$id?>" class="btn btn-primary">View more</a>
            </div>
       
        </div>
        <?php
         }
        ?>
        <!--list logistik-->
</div>

<?php
include 'template/footer.php'
?>