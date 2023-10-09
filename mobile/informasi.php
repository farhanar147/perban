<?php
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}

include '../config/config.php';
include 'template/header.php';
// kalau tidak ada id di query string
if( !isset($_GET['id']) ){
    header('Location: index.php');
}

//ambil id dari query string
$id = $_GET['id'];

$sql = "SELECT 
        SUM(total) as pengungsi,
        SUM(perempuan) as perempuan, 
        SUM(balita) as balita, 
        SUM(laki_laki) as pria,
        tb_bencana.bencana,
        tb_bencana.tanggal,
        tb_bencana.waktu_akhir
        from tb_bencana INNER JOIN 
        tb_posko ON tb_posko.id_bencana = tb_bencana.id_bencana 
        WHERE tb_bencana.id_bencana=$id";
        $query = mysqli_query($conn, $sql);
        $da = mysqli_fetch_assoc($query);
        $tpl = $da['pria']+$da['perempuan'];
        $rice = $tpl * 0.4;
        $susu = $da['balita'] * 4;
        $t_akhir = $da['waktu_akhir'];
        $sekarang  = new DateTime(date("Y-m-d"));
        $akhir = new DateTime($t_akhir); 
        $diff  = $sekarang->diff($akhir)->format("%r%a");
        $waktu = $diff;
        
        if($waktu < 1){
            $durasi = 0;
        }else{
            $durasi = $waktu;
        }

?>

    <!--Bencana-->
    <div class="container"> 
        <div class="col-md-12">
            <h3 class="text-center"><?= $da['bencana']; ?></h3>
            <div class="justify-content-center my-2">
                <!--Gambar Bencana-->
                <img src="images/banjir.jpg" width="300" alt="">
                <!--Gambar Bencana-->
            </div>
            <!--Lokasi & waktu donasi-->
            <p style="font-size: 20px; font-weight: 650;" class="text-center">Waktu Donasi: <?= $durasi; ?> hari</p>
            <!--Lokasi & waktu donasi-->
            <div class="justify-content-center">
                <!--Pengungsi-->
                <div class="card p-3 mb-3" style="border-color: #82C6EC;">
                    <div>
                    <label style="font-weight: bolder;">Pengungsi</label>
                        <table>
                            <tr>
                                <td>Perempuan</td>
                                <td>  :</td>
                                <td><?= $da['perempuan']; ?> Orang</td>
                            </tr>
                            <tr>
                                <td>Laki-laki</td>
                                <td> :</td>
                                <td><?= $da['pria']; ?> Orang</td>
                            </tr>
                            <tr>
                                <td>Balita</td>
                                <td>:</td>
                                <td><?= $da['balita']; ?> Orang</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--Pengungsi-->

                <!--Kebutuhan Pengungsi-->
                <div class="card p-3 mb-3" style="border-color: #82C6EC;">
                    <div>
                    <label style="font-weight: bolder;">Kebutuhan Pengungsi</label>
                        <table>
                            <tr>
                                <td>Beras</td>
                                <td>:</td>
                                <td><?= $rice ?> Kg</td>
                            </tr>
                            <tr>
                                <td>Sembako</td>
                                <td>:</td>
                                <td><?= $tpl ?> Paket</td>
                            </tr>
                            <tr>
                                <td>Pakaian Laki-laki</td>
                                <td>:</td>
                                <td><?= $da['pria']; ?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Pakaian Wanita</td>
                                <td>:</td>
                                <td><?= $da['perempuan']; ?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Popok Bayi</td>
                                <td>:</td>
                                <td><?= $da['balita']; ?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Makanan Bayi</td>
                                <td>:</td>
                                <td><?= $da['balita']; ?> Paket</td>
                            </tr>
                            <tr>
                                <td>Susu Bayi</td>
                                <td>:</td>
                                <td><?= $susu; ?> Kotak(150g)</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--Kebutuhan Pengungsi-->
                <?php
                $qry = "SELECT 
                SUM(sembako) AS sembako,
                SUM(beras) AS beras,
                SUM(pakaian_perempuan) AS pakaianp, 
                SUM(pakaian_laki_laki) AS pakaianl,
                SUM(popok_bayi) AS popok, 
                SUM(susu_bayi) AS susu,
                SUM(makanan_bayi) AS makanan
                FROM `tb_donasi` WHERE id_bencana = $id AND status = 2";
                $d = mysqli_query($conn, $qry);
                $t = mysqli_fetch_assoc($d);
                ?>
                <!--Donasi terkumpul-->
                <div class="card p-3 mb-3" style="border-color: #82C6EC;">
                    <div>
                    <label style="font-weight: bolder;">Donasi yang terkumpul</label>
                        <table>
                            <tr>
                                <td>Beras</td>
                                <td>:</td>
                                <td><?=$t['beras'];?> Kg</td>
                            </tr>
                            <tr>
                                <td>Sembako</td>
                                <td>:</td>
                                <td><?=$t['sembako'];?> Paket</td>
                            </tr>
                            <tr>
                                <td>Pakaian Laki-laki</td>
                                <td>:</td>
                                <td><?=$t['pakaianp'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Pakaian Wanita</td>
                                <td>:</td>
                                <td><?=$t['pakaianl'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Popok Bayi</td>
                                <td>:</td>
                                <td><?=$t['popok'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Makanan Bayi</td>
                                <td>:</td>
                                <td><?=$t['makanan'];?> Pack</td>
                            </tr>
                            <tr>
                                <td>Susu Bayi</td>
                                <td>:</td>
                                <td><?=$t['susu'];?> Kotak(150g)</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--Donasi terkumpul-->
                <?php
                if($waktu > 0){
                ?>
                <div class="mb-5">
                    <a href="donasi.php?id=<?=$id?>" class="btn btn-primary btn-lg btn-block">Donasi</a>
                </div>
                <?php
                }
                else{
                ?>
                    <div class="alert alert-secondary mb-5" role="alert">
                    Waktu Donasi Telah Berakhir
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!--Bencana-->

<?php
include 'template/footer.php'
?>