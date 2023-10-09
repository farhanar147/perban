<?php ob_start(); ?>
<html>
<head>
  <title>Cetak PDF</title>
  <style>
    h3,h1,h5,h6{
    text-align:center;
    padding-right:200px;
    }
    .row{
    margin-top: 20px;
    }
    .keclogo{
    font-size:24px;
    font-size:3vw;
    }
    .kablogo{
    font-size:2vw;
    }
    .alamatlogo{
    font-size:1.5vw;
    }
    .kodeposlogo{
    font-size:1.7vw;
    }
    #tls{
    text-align:right; 
    }
    .alamat-tujuan{
    margin-left:50%;
    }
    .garis1{
    border-top:3px solid black;
    height: 2px;
    border-bottom:1px solid black;
    }
    #logo{
    margin: auto;
    margin-left: 50%;
    margin-right: auto;
    }
    #tempat-tgl{
    margin-left:120px;
    }
    #camat{
    text-align:center;
    }
    #nama-camat{
    margin-top:100px;
    text-align:center;
    }
    .table {
      border-collapse:collapse;
      table-layout:fixed;width: 630px;
    }
    .table th {
      padding: 5px;
    }
    .table td {
      word-wrap:break-word;
      width: 10%;
      padding: 5px;
    }
  </style>
</head>
<body class="body">
  <?php
  // Load file koneksi.php
  include "config/config.php";
    $id = @$_GET['id']; // Ambil data id
    $query = "SELECT tb_tdonasi.*, tb_posko.kode_posko, tb_bencana.bencana 
    FROM `tb_tdonasi` 
    INNER JOIN tb_posko ON tb_tdonasi.id_posko = tb_posko.id_posko
    INNER JOIN tb_bencana ON tb_tdonasi.id_bencana = tb_bencana.id_bencana
    WHERE tb_tdonasi.id_posko = $id; ";
    $sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
    $data = mysqli_fetch_array($sql);
    $tgl = date('d-m-Y', strtotime($data['waktu'])); // Ubah format tanggal jadi dd-mm-yyyy
  ?>
  <div>
      <div class="row">
      <div id="text-header" class="col-md-9">
        <h1 class="kablogo">PERBAN</h1>
        <h6 class="alamatlogo">Jalan Contoh N0. 56, Telepon/Faximile (0298) XXXXXX</h6>
        <h5 class="kodeposlogo"><strong>JAKARTA</strong></h5>
      </div>
      </div>


  <div class="container">
    <hr class="garis1"/>
    <div id="alamat" class="row">
      <div id="lampiran" class="col-md-6">
        Pokso	: <?=$data['kode_posko'] ?>  <br />
        Tanggal : <?=$tgl;?> <br />
        Perihal	: Pengiriman Barang
        <br />
    </div>
    <br />
      <div id="tgl-srt" class="col-md-6">
        Yth . Relawan  <?=$data['kode_posko'] ?> <br />  
        Bencana  <?=$data['bencana'] ?> 
      </div>
    </div>
    <div id="pembuka" class="row">
        Dengan hormat, <br/>
        Kami kirimkan donasi yang terkumpul ke posko sesuai kebutuhan posko berikut rician donasi : 


    </div>
    <div>
    <table class="table" border="1" width="100%" style="margin-top: 10px;">
    <tr>
        <th>Kode</th>
        <th>Beras</th>
        <th>Sembako</th>
        <th>Pakaian Wanita</th>
        <th>Pakaian Pria</th>
        <th>Popok</th>
        <th>Makanan</th>
        <th>Susu</th>
        <th>Lain</th>
    </tr>
    <?php
        echo "<tr>";
        echo "<td>".$data['kode']."</td>";
        echo "<td>".$data['beras']."</td>";
        echo "<td>".$data['sembako']."</td>";
        echo "<td>".$data['pakaianp']."</td>";
        echo "<td>".$data['pakaianl']."</td>";
        echo "<td>".$data['popokb']."</td>";
        echo "<td>".$data['makananb']."</td>";
        echo "<td>".$data['susub']."</td>";
        echo "<td>".$data['lain']."</td>";
        echo "</tr>";
    ?>
      </table>
    </div>
    <br />
    <div id="penutup">
    Demikian untuk menjadikan perhatian dan atas kehadirannya diucapkan terimakasih.Kami harap setelah barang tersebut diterima, Saudara melakukan input kode yang tesedia di Aplikasi PERBAN. 
    <br />
    <br />    
    Atas Perhatian Saudara kami ucapkan terimakasih.</div>
    <div id="ttd" class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <p id="camat"><strong>Admin PERBAN</strong></p>
        <div id="nama-camat"><strong><u>Farhan Ar Rasyid</u></strong><br />
      </div>
      </div>
      </div>
</div>
</div>
</body>
</html>
<?php
$html = ob_get_contents();
ob_end_clean();
require 'libraries/html2pdf/autoload.php';
$pdf = new Spipu\Html2Pdf\Html2Pdf('P','A4','en');
$pdf->WriteHTML($html);
$pdf->Output('Surat-Pengiriman.pdf', 'I');
?>