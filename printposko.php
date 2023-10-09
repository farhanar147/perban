<?php ob_start(); ?>
<html>
<head>
  <title>Cetak PDF</title>
  <style>
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
<body>
  <?php
  // Load file koneksi.php
  include "config/config.php";
  $tgl_awal = @$_GET['tgl_awal']; // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
  $tgl_akhir = @$_GET['tgl_akhir']; // Ambil data tgl_awal sesuai input (kalau tidak ada set kosong)
  if(empty($tgl_awal) or empty($tgl_akhir)){ // Cek jika tgl_awal atau tgl_akhir kosong, maka :
    // Buat query untuk menampilkan semua data transaksi
    $query = "SELECT * FROM tb_tdonasi WHERE tb_tdonasi.status = '2' ";
    $label = "Semua Data Donasi yang telah disalurakan";
  }else{ // Jika terisi
    // Buat query untuk menampilkan data transaksi sesuai periode tanggal
    $query = "SELECT * FROM tb_tdonasi WHERE tb_tdonasi.status = '2' AND (waktu BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."')";
    $tgl_awal = date('d-m-Y', strtotime($tgl_awal)); // Ubah format tanggal jadi dd-mm-yyyy
    $tgl_akhir = date('d-m-Y', strtotime($tgl_akhir)); // Ubah format tanggal jadi dd-mm-yyyy
    $label = 'Periode Tanggal '.$tgl_awal.' s/d '.$tgl_akhir;
  }
  ?>
  <h4 style="margin-bottom: 5px;">Data Donasi yang telah disalurakan</h4>
  <?php echo $label ?>
  <table class="table" border="1" width="100%" style="margin-top: 10px;">
    <tr>
        <th>waktu</th>
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
    $sql = mysqli_query($conn, $query); // Eksekusi/Jalankan query dari variabel $query
    $row = mysqli_num_rows($sql); // Ambil jumlah data dari hasil eksekusi $sql
    if($row > 0){ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
      while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
        $tgl = date('d-m-Y', strtotime($data['waktu'])); // Ubah format tanggal jadi dd-mm-yyyy
        echo "<tr>";
        echo "<td>".$tgl."</td>";
        echo "<td>".$data['kode']."</td>";
        echo "<td>".$data['beras']."</td>";
        echo "<td>".$data['sembako']."</td>";
        echo "<td>".$data['pakaianp']."</td>";
        echo "<td>".$data['pakaianp']."</td>";
        echo "<td>".$data['popokb']."</td>";
        echo "<td>".$data['makananb']."</td>";
        echo "<td>".$data['susub']."</td>";
        echo "<td>".$data['lain']."</td>";
        echo "</tr>";
      }
    }else{ // Jika data tidak ada
      echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
    }
    ?>
  </table>
</body>
</html>
<?php
$html = ob_get_contents();
ob_end_clean();
require 'libraries/html2pdf/autoload.php';
$pdf = new Spipu\Html2Pdf\Html2Pdf('L','A4','en');
$pdf->WriteHTML($html);
$pdf->Output('Laporan-donasi-diproses.pdf', 'I');
?>