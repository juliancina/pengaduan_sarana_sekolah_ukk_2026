<?php
require_once 'models/m_pengaduan.php';

class c_siswa {
    private $model;

    public function __construct() {
        $this->model = new m_pengaduan();
    }

    public function index() {
        if (session_status() == PHP_SESSION_NONE) { session_start(); }
        
        // Cek Login
        if (!isset($_SESSION['nis'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 'siswa_dashboard';

        // Load Header & Sidebar
        include 'views/template/header.php';
        include 'views/template/sidebar.php';

        switch ($page) {
            case 'siswa_dashboard':
            case 'home':
                $nis = $_SESSION['nis'];
                
                // 1. Ambil Data Siswa (Nama, dll)
                $data_siswa = mysqli_fetch_assoc($this->model->get_siswa($nis));
                
                // 2. Ambil Statistik Laporan (PENTING: Memanggil fungsi baru)
                $stats = $this->model->get_stats_siswa($nis);
                
                include 'views/siswa/v_home.php';
                break;

            case 'akun':
                $nis = $_SESSION['nis'];
                $data = mysqli_fetch_assoc($this->model->get_siswa($nis));
                include 'views/siswa/v_akun.php';
                break;

            case 'form':
                $kategori = $this->model->get_kategori();
                $laporan_aktif = $this->model->get_laporan($_SESSION['nis'], "NOT_SELESAI");
                include 'views/siswa/v_form.php';
                break;
            
            case 'riwayat':
                 $laporan_selesai = $this->model->get_laporan($_SESSION['nis'], "SELESAI");
                 include 'views/siswa/v_riwayat.php';
                 break;

            case 'simpan':
                $this->simpan_laporan();
                break;

            case 'logout':
                session_destroy();
                header("Location: index.php?page=login");
                exit;
                
            default:
                include 'views/siswa/v_home.php';
                break;
        }
        
        include 'views/template/footer.php';
    }

    // --- FUNGSI SIMPAN ---
    private function simpan_laporan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nis = $_SESSION['nis'];
            $id_kat = $_POST['id_kategori'];
            $lokasi = $_POST['lokasi'];
            $ket = $_POST['ket'];
            $foto = 'default.png';
            
            // Upload Foto Handler
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
                $target_dir = "assets/img_laporan/";
                if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

                $file_name = $_FILES['foto']['name'];
                $file_tmp  = $_FILES['foto']['tmp_name'];
                $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                if(in_array($ext, $allowed)){
                    $new_name = date('YmdHis') . '_' . rand(100,999) . '.' . $ext;
                    if(move_uploaded_file($file_tmp, $target_dir . $new_name)){
                        $foto = $new_name;
                    }
                }
            }

            if($this->model->simpan_aspirasi($nis, $id_kat, $lokasi, $ket, $foto)){
                echo "<script>alert('Laporan Berhasil Dikirim!'); window.location='index.php?page=form';</script>";
            } else {
                echo "<script>alert('Gagal Mengirim Laporan. Coba lagi.'); window.location='index.php?page=form';</script>";
            }
        }
    }
}
?>