<?php
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "skkpd";
} else {
    $host = "192.168.0.249";
    $username = "root";
    $password = "";
    $database = "skkpd";
}

$koneksi = mysqli_connect($host, $username, $password, $database);
?>