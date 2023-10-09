<?php
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
}
include '../../config/config.php';
include 'template_relawan/header.php';
$email = $_SESSION['email'];
$query = "SELECT tb_relawan.nama, tb_posko.*, tb_bencana.* FROM `tb_relawan` 
INNER JOIN tb_posko ON tb_relawan.id_posko = tb_posko.id_posko 
INNER JOIN tb_bencana ON tb_posko.id_bencana = tb_bencana.id_bencana
WHERE email = '$email' ";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>


 <!--input kode bantuan-->
 <div class="container mt-2">
        <div class="justify-content-center">
            <p class="text-center" style="font-weight: bold;">
                Jumlah Pengungsi di <?=$data['kode_posko'];?> - <?=$data['bencana'];?>
            </p>
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
            </div>
            <div class="mt-3">
                <a href="edit.php?id=<?=$data['id_posko'];?>" class="btn btn-primary btn-lg btn-block">Update data</a>
            </div>
    </div>

<?php
include 'template_relawan/footer.php'
?>