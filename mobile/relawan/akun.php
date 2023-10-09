<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");  
}


include '../../config/config.php';

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <title>Document</title>
</head>

<body>

    <div class="container">
      <div  class="mt-4">
        <img src="../logo/akun.png" height="150" style="display:block; margin:auto;" alt="MDB Logo" loading="lazy" />
        <h4 class="text-center mt-2"><?=$_SESSION['email'];?></h4>
            <div class="text-center mt-4">
            <a href="gantipassword.php" style="font-size:20px;text-decoration:none;">Ganti Password</a>
            </div>
            <div class="text-center mt-4">
            <a href="home.php" style="font-size:20px;text-decoration:none;">Kembali</a>
            </div>
            <div class="text-center mt-4">
            <a href="../logout.php" style="font-size:20px;text-decoration:none;">Logout</a>
            </div>
      </div>
    </div>

</body>

<script src="../../js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script>
    $(document).ready(function () {
        $("#news-slider").owlCarousel({
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [1000, 2],
            itemsMobile: [650, 1],
            navigationText: false,
            autoPlay: true
        });
    });
</script>

</html>