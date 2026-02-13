<?php
session_start();
require_once 'config/cn_database.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    // === AUTH === \\
    case 'login':
        require_once 'controllers/c_auth.php';
        $app = new c_auth();
        $app->login_view();
        break;

    case 'auth_proccess':
        require_once 'controllers/c_auth.php';
        $app = new c_auth();
        $app->login_action();
        break;

    case 'register':
        require_once 'controllers/c_auth.php';
        $app = new c_auth();
        $app->register_view();
        break;

    case 'register_proccess':
        require_once 'controllers/c_auth.php';
        $app = new c_auth();
        $app->register_action();
        break;

    case 'logout':
        require_once 'controllers/c_auth.php';
        $app = new c_auth();
        $app->logout();
        break;

    // === SISWA === \\
    case 'siswa_dashboard':
    case 'home':
    case 'akun':
    case 'form':
    case 'simpan': 
    case 'riwayat':
        require_once 'controllers/c_siswa.php';
        $app = new c_siswa();
        $app->index(); 
        break;
       
    case 'edit':
        require_once 'controllers/c_siswa.php';
        $app = new c_siswa();
        $app->edit();
        break;

    case 'hapus':
        require_once 'controllers/c_siswa.php';
        $app = new c_siswa();
        $app->hapus();
        break;


    // === ADMIN === \\
    case 'admin_dashboard':
    case 'verifikasi':
    case 'admin_riwayat':
    case 'admin_akun':
    case 'proses_tanggapan':
    case 'cetak_laporan': 
    case 'delete_laporan':
        require_once 'controllers/c_admin.php';
        $app = new c_admin();
        $app->index();
        break;

    default:
        require_once 'controllers/c_auth.php';
        $app = new c_auth();
        $app->login_view();
        break;
}
?>