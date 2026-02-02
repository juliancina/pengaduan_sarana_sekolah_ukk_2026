<?php
require_once 'models/m_admin.php';

class c_admin {
    private $model;

    public function __construct() {
        $this->model = new m_admin();
    }

    public function index() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
            header("Location: index.php?page=login"); exit;
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 'admin_dashboard';

        // Load Header & Sidebar KECUALI saat cetak
        if ($page != 'cetak_laporan') {
            include 'views/template/header.php';
            include 'views/template/sidebar.php';
        }

        switch ($page) {
            case 'admin_dashboard':
                $stats = $this->model->get_stats();
                include 'views/admin/v_home.php';
                break;

            case 'verifikasi':
                $data_kategori = $this->model->get_kategori();
                $filter = [
                    'tgl_awal'  => isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '',
                    'tgl_akhir' => isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '',
                    'nama'      => isset($_GET['nama']) ? $_GET['nama'] : '',
                    'kategori'  => isset($_GET['kategori']) ? $_GET['kategori'] : '',
                    'status'    => isset($_GET['status']) ? $_GET['status'] : ''
                ];
                $data_laporan = $this->model->get_laporan_aktif($filter);
                include 'views/admin/v_verifikasi.php';
                break;

            case 'admin_riwayat':
                $data_kategori = $this->model->get_kategori();
                $filter = [
                    'tgl_awal'  => isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '',
                    'tgl_akhir' => isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '',
                    'nama'      => isset($_GET['nama']) ? $_GET['nama'] : '',
                    'kategori'  => isset($_GET['kategori']) ? $_GET['kategori'] : ''
                ];
                // Ambil data untuk tabel
                $data_riwayat = $this->model->get_riwayat_filter($filter);
                include 'views/admin/v_riwayat.php';
                break;

            case 'admin_akun':
                $data['username'] = $_SESSION['username'];
                include 'views/admin/v_akun.php';
                break;

            case 'proses_tanggapan':
                $this->proses_tanggapan();
                break;

            case 'cetak_laporan':
                // FITUR CETAK (MENGGUNAKAN FILTER YANG SAMA)
                $filter = [
                    'tgl_awal'  => isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '',
                    'tgl_akhir' => isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '',
                    'nama'      => isset($_GET['nama']) ? $_GET['nama'] : '',
                    'kategori'  => isset($_GET['kategori']) ? $_GET['kategori'] : ''
                ];
                
                // Ambil data untuk dicetak
                $data_cetak = $this->model->get_riwayat_filter($filter);
                
                // Panggil view khusus cetak
                include 'views/admin/v_cetak.php';
                break;
                
            case 'logout':
                session_destroy();
                header("Location: index.php?page=login");
                exit;

            default:
                $stats = $this->model->get_stats();
                include 'views/admin/v_home.php';
                break;
        }
        
        if ($page != 'cetak_laporan') {
            include 'views/template/footer.php';
        }
    }

    public function proses_tanggapan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_pelaporan'];
            $st = $_POST['status'];
            $fb = $_POST['feedback'];
            $adm = $_SESSION['id_admin'];

            if ($this->model->update_tanggapan($id, $st, $fb, $adm)) {
                echo "<script>alert('Berhasil menanggapi laporan!'); window.location='index.php?page=verifikasi';</script>";
            } else {
                echo "<script>alert('Gagal update data!'); window.location='index.php?page=verifikasi';</script>";
            }
        }
    }
}
?>