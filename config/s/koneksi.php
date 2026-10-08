<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'parkir';

try {
    $conn = new mysqli($host, $username, $password, $database);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $error) {
    die('Koneksi database gagal. Periksa konfigurasi MySQL dan pastikan database parkir sudah diimpor.');
}
