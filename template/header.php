<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Admin</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body>
<div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>PERBAN</h3>
            </div>

            <ul class="list-unstyled components">
                <p>Admin Site</p>
                <li>
                    <a href="home.php">Dashboard</a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Manajemen Kebencanaan</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="bencana.php">Bencana</a>
                        </li>
                        <li>
                            <a href="posko.php">Posko</a>
                        </li>
                        <li>
                            <a href="regional.php">Regional</a>
                        </li>
                        <li>
                            <a href="relawan.php">Relawan</a>
                        </li>
                        <li>
                            <a href="news.php">News</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Manajemen Donasi</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu2">
                        <li>
                            <a href="stok.php">Stok</a>
                        </li>
                        <li>
                            <a href="donasi.php">Terima Donasi</a>
                        </li>
                        <li>
                            <a href="kirim.php">Pengiriman Donasi</a>
                        </li>
                        <li>
                            <a href="cek.php">Donasi Tersalurkan</a>
                        </li>
                        <li>
                            <a href="laporanproses.php">Laporan Donasi sedang proses</a>
                        </li>
                        <li>
                            <a href="laporan.php">Laporan Donasi diterima center </a>
                        </li>
                        <li>
                            <a href="laporansend.php">Laporan Donasi dikirim </a>
                        </li>
                        <li>
                            <a href="laporanposko.php">Laporan Donasi disalurkan </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="akun.php">Ganti Password</a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
            <li>
                <a href="logout.php" class="download">Logout</a>
            </li>
            </ul>
        </nav>

<div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span></span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>
            </div>
        </nav>
        
        
