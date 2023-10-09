<?php
include 'config/config.php';

 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}

include 'template/header.php';

?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Selamat Datang</h1>
    <p class="lead">Di dashboard admin PERBAN</p>
  </div>
</div>



<?php
include 'template/footer.php';

?>

