<?php
include 'config/config.php';

 
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
}


if(isset($_POST['submit'])){
    $email = $_SESSION["email"];
    $result = mysqli_query($conn,"SELECT * FROM `tb_admin` WHERE email ='$email' ");
    $row=mysqli_fetch_assoc($result);
    $password = $_POST['password'];
    if($_POST['passwordl'] == $row['password'] && $_POST['password'] == $_POST['cpassword'] ) {
    mysqli_query($conn,"UPDATE `tb_admin` SET `password` = '$password' WHERE `tb_admin`.`email` = '$email'");
    $message ="Password Berhasil diubah";
    } else{
    $message ="Password gagal diubah";
    }
    
}

include 'template/header.php';

?>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
                    <?php 
                    if(isset($message)){ ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?=$message;?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <?php }?>
                        <form action="" method="POST" enctype="multipart/form-data" class="login-form">
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


<?php
include 'template/footer.php';

?>