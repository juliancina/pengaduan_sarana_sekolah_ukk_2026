<?php
require_once 'models/m_admin.php';

class c_admin {
    private $model;

    public function __construct() {
        $this->model = new m_admin();
    }

    public function index() {
        // Cek Session
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
            header("Location: index.php?page=login"); exit;
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 'admin_dashboard';

        // 1. Load Header & Sidebar (KECUALI Cetak & Proses Logic)
        // Kita exclude 'proses_tanggapan' dan 'hapus_laporan' karena mereka hanya logic (bukan tampilan)
        if ($page != 'cetak_laporan' && $page != 'proses_tanggapan' && $page != 'hapus_laporan') {
            include 'views/template/header.php';
            include 'views/template/sidebar.php';
        }

        switch ($page) {
            // === DASHBOARD ===
            case 'admin_dashboard':
                $stats = $this->model->get_stats();
                include 'views/admin/v_home.php';
                break;

            // === HALAMAN VERIFIKASI ===
            case 'verifikasi':
                $data_kategori = $this->model->get_kategori();
                // Ambil filter dari URL
                $filter = [
                    'tgl_awal'  => isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '',
                    'tgl_akhir' => isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '',
                    'nama'      => isset($_GET['nama']) ? $_GET['nama'] : '',
                    'status'    => isset($_GET['status']) ? $_GET['status'] : '',
                    'kategori'  => isset($_GET['kategori']) ? $_GET['kategori'] : ''
                ];
                
                $data_laporan = $this->model->get_laporan_aktif($filter);
                include 'views/admin/v_verifikasi.php';
                break;

           // === LOGIC: PROSES TANGGAPAN (Perbaikan Bug Status) ===
           case 'proses_tanggapan':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id  = $_POST['id_pelaporan'];
                $st  = $_POST['status'];
                
                // PERBAIKAN BUG: Menyamakan dengan name="tanggapan" di form v_verifikasi
                $fb  = isset($_POST['tanggapan']) ? $_POST['tanggapan'] : ''; 
                
                $adm = $_SESSION['id_admin']; 

                if ($this->model->proses_tanggapan($id, $st, $fb, $adm)) {
                    echo "<script>alert('Berhasil Update Status!'); window.location='index.php?page=verifikasi';</script>";
                } else {
                    echo "<script>alert('Gagal Update Database!'); window.location='index.php?page=verifikasi';</script>";
                }
            } else {
                // Jika diakses langsung tanpa POST, kembalikan ke verifikasi
                header("Location: index.php?page=verifikasi");
            }
            break;
            
            // === LOGIC: HAPUS LAPORAN === \\
            case 'delete_laporan':
                $id = $_GET['id'];
                if($this->model->delete_laporan($id)){
                    echo "<script>alert('Laporan BERHASIL DIHAPUS Permanen!'); window.location='index.php?page=verifikasi';</script>";
                } else {
                    echo "<script>alert('Gagal menghapus laporan.'); window.location='index.php?page=verifikasi';</script>";
                }
                break;

            // === HALAMAN RIWAYAT === \\
            case 'admin_riwayat':
                $data_kategori = $this->model->get_kategori();
                $filter = [
                    'tgl_awal'  => isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '',
                    'tgl_akhir' => isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '',
                    'nama'      => isset($_GET['nama']) ? $_GET['nama'] : '',
                    'kategori'  => isset($_GET['kategori']) ? $_GET['kategori'] : ''
                ];
                // Menggunakan fungsi get_riwayat_filter di Model
                $data_riwayat = $this->model->get_riwayat_filter($filter);
                
            
                if (file_exists('views/admin/v_riwayat.php')) {
                    include 'views/admin/v_riwayat.php';
                } else {
                    echo "<div class='pc-container'><div class='pc-content'><div class='alert alert-warning'>File views/admin/v_riwayat.php belum dibuat.</div></div></div>";
                }
                break;

            // === HALAMAN AKUN ADMIN === \\
            case 'admin_akun':
                // Jika file view belum ada, tampilkan pesan agar layout tidak rusak
                if (file_exists('views/admin/v_akun.php')) {
                    include 'views/admin/v_akun.php';
                } else {
                    echo "<div class='pc-container'><div class='pc-content'><h3>Halaman Profil Admin</h3><p>File views/admin/v_akun_admin.php belum tersedia.</p></div></div>";
                }
                break;

            // === CETAK LAPORAN === \\
            case 'cetak_laporan':
                $filter = [
                    'tgl_awal'  => isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '',
                    'tgl_akhir' => isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '',
                    'nama'      => isset($_GET['nama']) ? $_GET['nama'] : '',
                    'kategori'  => isset($_GET['kategori']) ? $_GET['kategori'] : ''
                ];
                $data_cetak = $this->model->get_riwayat_filter($filter);
                include 'views/admin/v_cetak.php';
                break;
                
            // === LOGOUT === \\
            case 'logout':
                session_destroy();
                header("Location: index.php?page=login");
                exit;

            default:
                $stats = $this->model->get_stats();
                include 'views/admin/v_home.php';
                break;
        }
        
        // Load Footer (Kecuali Cetak) \\
        if ($page != 'cetak_laporan' && $page != 'proses_tanggapan' && $page != 'hapus_laporan') {
            include 'views/template/footer.php';
        }
    }
}
?>