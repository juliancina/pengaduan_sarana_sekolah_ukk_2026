<?php
session_start();
require_once 'config/cn_database.php';

// Ambil parameter 'page' dari URL, default ke 'login' \\
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

// Routing \\
switch ($page) {
    case 'login':
        require_once 'controllers/c_auth.php';
        $controller = new c_auth();
        $controller->login_view();
        break;

    case 'auth_proccess':
        require_once 'controllers/c_auth.php';
        $controller = new c_auth();
        $controller->login_action();
        break;

    case 'logout':
        require_once 'controllers/c_auth.php';
        $controller = new c_auth();
        $controller->logout();
        break;

    case 'admin_dashboard':
        // Cek sesi admin (keamanan) \\
        if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: index.php?page=login");
            exit;
        }
        echo "<h1>Selamat Datang Admin!</h1> (Dashboard Admin akan kita buat nanti)";
        break;

    default:
        echo "404 - Halaman tidak ditemukan";
        break;
}
?>