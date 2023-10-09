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
                    <h4 class="text-center">Pengiriman Donasi</h4>
                    <form class="mb-4" method="GET" action="kirim.php">
                    <div class="input-group">
                        <select name="cari" class="custom-select" id="inputGroupSelect04">
                            <?php
                            $sql = mysqli_query($conn, "SELECT tb_posko.kode_posko,tb_posko.id_posko, tb_bencana.bencana, tb_bencana.id_bencana FROM `tb_posko`
                            INNER JOIN tb_bencana ON tb_bencana.id_bencana = tb_posko.id_bencana ORDER BY id_bencana ASC"); 
                            while ($result = mysqli_fetch_assoc($sql)) { ?>
                            <option value="<?=$result['id_posko']?>"><?=$result['bencana']; ?> - <?=$result['kode_posko']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" value="Cari" type="submit">Pilih</button>
                        </div>
                    </div>
                    </form>
                    <?php
                        if(isset($_SESSION['aksi'])){
                            $massage = $_SESSION['aksi'];
                            if ($massage == 1) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>berhasil dikirim</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php }else if($massage == 2){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal dikirim</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php 
                    }
                    unset($_SESSION['aksi']); }?>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Posko</th>
                            <th scope="col">Beras</th>
                            <th scope="col">Sembako</th>
                            <th scope="col">Pakaian Wanita</th>
                            <th scope="col">Pakaian Pria</th>
                            <th scope="col">Popok</th>
                            <th scope="col">Makanan</th>
                            <th scope="col">Susu</th>
                            <th scope="col">lain</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 


                        if (isset($_GET['cari'])) {
                            $cari = $_GET['cari'];
                            $s = "SELECT * FROM `tb_posko` WHERE id_posko = $cari";
                            $e = mysqli_query($conn,$s);
                            $a = mysqli_fetch_array($e);
                            $id_posko = $a['id_posko'];
                            $id_bencana = $a['id_bencana'];

                            //donasi
                            $sql = "SELECT SUM(beras) AS beras, SUM(sembako) AS sembako, SUM(pakaian_perempuan) AS pakaianp, 
                            SUM(pakaian_laki_laki) AS pakaianl , SUM(popok_bayi) AS popok ,SUM(susu_bayi) AS susu, 
                            SUM(makanan_bayi) AS makananb , SUM(lainnya) AS lain
                            FROM `tb_donasi` WHERE id_bencana = $id_bencana AND status = 2";
                            $proses = mysqli_query($conn,$sql);
                            $donasi = mysqli_fetch_array($proses);

                            //bencana
                            $jml = "SELECT SUM(perempuan) AS perempuan, SUM(laki_laki) AS laki, SUM(balita) AS balita FROM `tb_posko` 
                            WHERE id_bencana = $id_bencana";
                            $data = mysqli_query($conn,$jml);
                            $korban = mysqli_fetch_array($data);
                            $berasb = ($korban['laki'] + $korban['perempuan']) * 0.4;
                            $all =  $korban['laki'] + $korban['perempuan'];
                            $susub = $korban['balita'] * 4;
                            $b = $korban['balita'];

                            //posko
                            $query = "SELECT  tb_posko.id_posko, tb_posko.kode_posko, tb_posko.perempuan, tb_posko.laki_laki, tb_posko.balita, 
                            tb_bencana.id_bencana,tb_bencana.bencana, tb_bencana.waktu_akhir from tb_posko 
                            INNER JOIN tb_bencana ON tb_bencana.id_bencana = tb_posko.id_bencana 
                            WHERE tb_posko.id_posko = $id_posko ";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_array($result);
                            $berasp =  ($row['perempuan'] + $row['laki_laki']) * 0.4;
                            $semua =  $row['perempuan'] + $row['laki_laki'];
                            $susup = $row['balita'] * 4;
                            $bayi = $row['balita'];

                            //waktu
                            $t_akhir = $row['waktu_akhir'];
                            $sekarang  = new DateTime(date("Y-m-d"));
                            $akhir = new DateTime($t_akhir); 
                            $diff  = $sekarang->diff($akhir)->format("%r%a");
                            $waktu = $diff;

                            //rumus
                            $beras = round( ($berasp/$berasb) * $donasi['beras'] ) ;
                            $sembako = round (($donasi['sembako']/$all) * $semua ) ;
                            $pakaianp = round (($donasi['pakaianp']/$korban['perempuan']) * $row['perempuan'] ) ;
                            $pakaianl = round (($row['laki_laki'] / $korban['laki']) * $donasi['pakaianl'] ) ;
                            $popok = round (($bayi / $b) * $donasi['popok'] ) ;
                            $makanan = round (($bayi / $b) * $donasi['makananb'] ) ;
                            $susu = round (($susup / $susub) * $donasi['susu'] ) ;
                            $lain =  round (($all/$semua) * $donasi['lain'] ) ;

                        ?>
                        <tr>
                            <td><?=$row['kode_posko'];?></td>
                            <td><?=$beras;?> Kg</td>
                            <td><?=$sembako;?> Pack</td>
                            <td><?=$pakaianp?> Pcs</td>
                            <td><?=$pakaianl?> Pcs</td>
                            <td><?=$popok;?> Pcs</td>
                            <td><?=$makanan;?> Pcs</td>
                            <td><?=$susu;?> Pack</td>
                            <td><?=$lain;?> Pack</td>
                            <td>
                               <?php
                                $posko = $row['id_posko'];
                                    if ($waktu > 0) {
                                      ?>
                                      <button type="button" class="btn btn-secondary" disabled>Kirim</button>
                                      <?php  
                                    }else{
                                        $p = "SELECT * FROM `tb_tdonasi` WHERE id_posko = $posko  ";
                                        $c = mysqli_query($conn,$p);
                                        if (mysqli_num_rows($c) < 1) {
                                            ?>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kirim">
                                            Kirim
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="kirim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Apa anda Yakin Mengirim Bantuan?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <form method="POST" action="proses_kirim.php">
                                                <input type="hidden" name="id_bencana" value="<?=$id_bencana?>">
                                                <input type="hidden" name="id_posko" value="<?=$id_posko?>">
                                                <input type="hidden" name="waktu" value="<?=date("Y-m-d"); ?>">
                                                <input type="hidden" name="beras" value="<?=$beras?>">
                                                <input type="hidden" name="sembako" value="<?=$sembako?>">
                                                <input type="hidden" name="pakaianp" value="<?=$pakaianp?>">
                                                <input type="hidden" name="pakaianl" value="<?=$pakaianl?>">
                                                <input type="hidden" name="popok" value="<?=$popok?>">
                                                <input type="hidden" name="makanan" value="<?=$makanan?>">
                                                <input type="hidden" name="susu" value="<?=$susu?>">
                                                <input type="hidden" name="lain" value="<?=$lain?>">
                                                <button type="submit" class="btn btn-success">Yakin</button>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                        </div>  
                                    <?php
                                        }else{
                                    ?>
                                        <a href="printkirim.php?id=<?=$id_posko;?>" class="btn btn-danger">Cetak PDF</a>
                                    <?php
                                        }
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

