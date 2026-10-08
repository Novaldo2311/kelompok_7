<?php
session_start();
require_once __DIR__ . "/koneksi.php";

// Cek apakah user sudah login, jika belum redirect ke login
function cekLogin()
{
    if (!isset($_SESSION['id_user'])) {
        $base_url = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
        if (in_array(basename($base_url), ['modules', 'pages'], true)) {
            $base_url = dirname($base_url);
        }
        header("Location: " . $base_url . "/pages/login.php");
        exit;
    }
}

// Cek hak akses berdasarkan role, contoh: cekAkses(['admin'])
function cekAkses($role_diizinkan = [])
{
    cekLogin();
    if (!in_array($_SESSION['role'], $role_diizinkan)) {
        $base_url = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
        if (in_array(basename($base_url), ['modules', 'pages'], true)) {
            $base_url = dirname($base_url);
        }
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location='" . $base_url . "/pages/dashboard_admin.php';</script>";
        exit;
    }
}

// Mencatat aktivitas user ke tb_log_aktivitas
function catatLog($koneksi, $id_user, $aktivitas)
{
    $aktivitas = mysqli_real_escape_string($koneksi, $aktivitas);
    mysqli_query($koneksi, "INSERT INTO tb_log_aktivitas (id_user, aktivitas, waktu_aktivitas)
                             VALUES ($id_user, '$aktivitas', NOW())");
}

// Simpan data user ke session setelah login berhasil
function loginUser($koneksi, $userData)
{
    if (!is_array($userData) || empty($userData['id_user'])) {
        return false;
    }

    $_SESSION['id_user']      = (int) $userData['id_user'];
    $_SESSION['nama_lengkap'] = $userData['nama_lengkap'];
    $_SESSION['username']     = $userData['username'];
    $_SESSION['role']         = $userData['role'];

    catatLog($koneksi, (int) $userData['id_user'], "Login ke sistem");
    return true;
}

// Logout user dan catat aktivitas
function logoutUser($koneksi)
{
    if (isset($_SESSION['id_user'])) {
        catatLog($koneksi, (int) $_SESSION['id_user'], "Logout dari sistem");
    }

    session_unset();
    session_destroy();
    return true;
}

// Bersihkan input dari karakter berbahaya
function clean($koneksi, $data)
{
    return mysqli_real_escape_string($koneksi, htmlspecialchars(trim($data)));
}

// Format Rupiah
function rupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}

function durasiParkir($detik)
{
    $detik = max(0, (int) $detik);
    $jam = floor($detik / 3600);
    $menit = floor(($detik % 3600) / 60);

    if ($jam > 0 && $menit > 0) {
        return $jam . ' jam ' . $menit . ' menit';
    }

    if ($jam > 0) {
        return $jam . ' jam';
    }

    if ($menit > 0) {
        return $menit . ' menit';
    }

    return '0 menit';
}
