<?php
$host = "localhost";
$username = "root";
$password = "";
$database   = "cibione";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
} else {
    // echo "Koneksi Berhasil";
}
?>