<?php
session_start();
if (isset($_SESSION['id_user'])) {
    header("Location: pages/dashboard_admin.php");
} else {
    header("Location: pages/login.php");
}
exit;
