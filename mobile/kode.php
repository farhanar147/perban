<?php
session_start();

include '../config/config.php';
include 'template/header.php';

$kode = $_SESSION['kode'];
?>

<div class="container">
        <div class="col-md-12"> 
             <!--Donasi-->
                <div class="card mt-4" style="border-color: #82C6EC;">
                    <div class="card-body">
                    <p class="text-center" style="font-size: 13px;">Terimakasih Atas bantuan yang ada berikan</p>
                    <p class="text-center" style="font-size: 13px;">Kode Bantuan anda</p>
                    <p class="text-center" style="font-size: 30px; font-weight: bold;"><?=$kode;?></p>
                    <p class="text-center" style="font-size: 13px;">Mohon untuk menuliskan kode diatas pada paket 
                        bantuan anda</p>
                    <p style="font-size: 13px;">Alamat Center donasi : jalan coba rt 07 rw 09 jakarta</p>
                    </div>
                </div>
            <!--Donasi-->  
        </div>  
</div>  

<?php
include 'template/footer.php'
?>