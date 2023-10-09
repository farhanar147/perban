<?php
include 'config/config.php';
 
error_reporting(0);
 
session_start();

if (isset($_SESSION['email'])) {
    header("Location: home.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //admin
    $sql = "SELECT * FROM tb_admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['email'] = $row['email'];
        header("Location: home.php");
    } else {
        $message = "Password atau email salah";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Perban-Admin</title>
  <!-- Bootstrap CSS CDN -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Our Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
</style>
</head>
<body>
<div class="login-form">
<?php if(isset($message)){ ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong><?=$message?></strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>
    <form action="" method="post">
        <h2 class="text-center">Login Admin</h2>       
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="email" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button name="submit" class="btn btn-primary btn-block">Login</button>
        </div>        
    </form>
    <p>Akun untuk admin dengan web email : admin@perban.com pw : admin123</p>
    <p>Relawan dengan aplikasi  email : relawan@perban.com pw : relawan123</p>
</div>
</body>
</html>