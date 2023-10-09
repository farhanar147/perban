<?php
include '../config/config.php';
 
error_reporting(0);
 
session_start();

if (isset($_SESSION['email'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //RELAWAN
    $query = "SELECT * FROM tb_relawan WHERE email='$email' AND password='$password'";
    $rl = mysqli_query($conn, $query);
    
    //DONATUR
    $sql = "SELECT * FROM tb_donatur WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['email'] = $row['email'];
        header("Location: index.php");
    } elseif($rl->num_rows > 0){
        $data = mysqli_fetch_assoc($rl);
        session_start();
        $_SESSION['email'] = $data['email'];
        header("Location: relawan/home.php");
    } else {
        $message = "Password atau email salah";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <title>Document</title>
</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
                        <div class="col-md-6 text-center mb-5">
                            <img src="logo/logo.png" width="200rem" alt="">
                        </div>
                        <?php if(isset($message)){ ?>
                        <div class="alert danger-alert">
                            <h4><?=$message?></h4>
                            <a class="close">&times;</a>
                        </div>
                        <?php } ?>
                        <form action="" method="POST" class="login-form" >
                            <div class="form-group">
                            <input type="email" name="email" class="form-control rounded-left" placeholder="Email" required>
                            </div>
                            <div class="form-group d-flex">
                            <input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
                            </div>
                            <div class="form-group d-md-flex">
                                            
                            <p>Belum punya akun?<a style="color: #097191c9;" href="register.php">Daftar disini</a></p>
                                            
                            </div>
                            <div class="form-group">
                                <button name="submit" class="btn btn-primary rounded submit p-3 px-5">Login</button>
                            </div>
                        </form>
	                </div>
			    </div>
			</div>
		</div>
	</section>
	</body>
<script src="../js/bootstrap.min.js"></script>
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
    $(".close").click(function() {
    $(this)
        .parent(".alert")
        .fadeOut();
    });
</script>

</html>