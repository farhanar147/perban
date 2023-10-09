<?php
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
}

include '../../config/config.php';
include 'template_relawan/header_home.php';
$email = $_SESSION['email'];
$query = "SELECT tb_relawan.nama, tb_posko.*, tb_bencana.* FROM `tb_relawan` 
INNER JOIN tb_posko ON tb_relawan.id_posko = tb_posko.id_posko 
INNER JOIN tb_bencana ON tb_posko.id_bencana = tb_bencana.id_bencana
WHERE email = '$email' ";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<div class="container mt-2">
        
        <!--data relawan-->
        <div class="card mb-3" style="border-color: #5AD0F5;">
            <div class="card-body">
                
                <p style="font-weight: bold;">Hi, Relawan <?=$data['nama'];?></p>
                <p>Anda sedang bertugas di <?=$data['kode_posko'];?> - Bencana <?=$data['bencana'];?></p>
            </div>
        </div>
        <!--data relawan-->

        <!--link posko-->
        <div class="container mb-3">
            <a class="navbar-brand" href="terima.php">
                <img src="../logo/bantuan.png" height="90" alt="MDB Logo" loading="lazy" />
            </a>
            <a class="justify-content-end" href="posko.php">
                <img src="../logo/posko.png" height="90" alt="MDB Logo" loading="lazy" />
            </a>
        </div>
        <!--link posko-->

        <div class="justify-content-center">
                <!--Pengungsi-->
                <div class="card p-3 mb-3" style="border-color: #82C6EC;">
                    <div>
                    <label style="font-weight: bolder;">Pengungsi</label>
                        <table>
                            <tr>
                                <td>Perempuan</td>
                                <td>:</td>
                                <td><?=$data['perempuan'];?> Orang</td>
                            </tr>
                            <tr>
                                <td>Laki-laki</td>
                                <td>:</td>
                                <td><?=$data['laki_laki'];?> Orang</td>
                            </tr>
                            <tr>
                                <td>Balita</td>
                                <td>:</td>
                                <td><?=$data['balita'];?> Orang</td>
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
                                <td><?=($data['perempuan']+$data['laki_laki']) * 0.4;?> Kg</td>
                            </tr>
                            <tr>
                                <td>Sembako</td>
                                <td>:</td>
                                <td><?=$data['perempuan']+$data['laki_laki'];?> Pck</td>
                            </tr>
                            <tr>
                                <td>Pakaian Laki-laki</td>
                                <td>:</td>
                                <td><?=$data['laki_laki'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Pakaian Wanita</td>
                                <td>:</td>
                                <td><?=$data['perempuan'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Popok Bayi</td>
                                <td>:</td>
                                <td><?=$data['balita'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Makanan Bayi</td>
                                <td>:</td>
                                <td><?=$data['balita'];?> Pcs</td>
                            </tr>
                            <tr>
                                <td>Susu Bayi</td>
                                <td>:</td>
                                <td><?=$data['balita'] * 4;?> Pck</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!--Kebutuhan Pengungsi-->

              
            </div>
    </div>

<?php
include 'template_relawan/footer.php'
?>   