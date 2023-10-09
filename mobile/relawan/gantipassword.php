<?php 

include '../../config/config.php';

 
session_start();
 
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}

if(isset($_POST['submit'])){
    $email = $_SESSION["email"];
    $result = mysqli_query($conn,"SELECT * FROM `tb_relawan` WHERE email ='$email' ");
    $row=mysqli_fetch_assoc($result);
    $password = $_POST['password'];
    if($_POST['passwordl'] == $row['password'] && $_POST['password'] == $_POST['cpassword'] ) {
    mysqli_query($conn,"UPDATE `tb_relawan` SET `password` = '$password' WHERE `tb_relawan`.`email` = '$email'");
    $message ="Password Berhasil diubah";
    } else{
    $message ="Password gagal diubah";
    }
    
}
    


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/alert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <title>Document</title>
</head>

<body>
    <div class="d-flex justify-content-start">
        <a class="navbar-brand" href="home.php">
            <img src="../logo/kembali.png" height="50" alt="MDB Logo" loading="lazy" />
        </a>
    </div>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
                    <?php 
                    if(isset($message)){ ?>
                    <div class="alert warning-alert" >
                        <h4><?=$message?></h4>
                        <a class="close">&times;</a>
                    </div>
                    <?php }?>
                        <form action="gantipassword.php" method="POST" class="login-form">
                            <div class="form-group d-flex">
                                <input type="password" name="passwordl" class="form-control rounded-left" placeholder="Password lama" required>
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
                            </div>
                            <div class="form-group d-flex">
                                <input type="password" name="cpassword" class="form-control rounded-left" placeholder="Konfirmasi Password" required>
                            </div>
                            <div class="form-group d-md-flex">
                            </div>
                            <div class="form-group">
                                <button name="submit"  class="btn btn-primary rounded submit p-3 px-5">Ganti Password</button>
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