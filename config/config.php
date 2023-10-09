<?php

 
$server = "localhost";
$user = "farhanp1_perban";
$pass = "(~X!u{#BLA($";
$database = "farhanp1_perban";
 
$conn = mysqli_connect($server, $user, $pass, $database);
 
if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
 
?>