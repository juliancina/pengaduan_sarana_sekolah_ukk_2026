<?php
include_once 'models/m_siswa.php';

class C_Siswa
{
    public $model;

    public function __construct()
    {
        $this->model = new m_siswa();
    }

    public function index()
    {
        // 1. Cek Login
        if (!isset($_SESSION['nis'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $nis = $_SESSION['nis'];
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        // 2. LOGIC PER HALAMAN (Persiapan Data)
        switch ($page) {
            case 'form':
            case 'simpan':
                // Logic Kirim Laporan
                if (isset($_POST['kirim'])) {
                    $nama_foto = 'default.png';
                    if (!empty($_FILES['foto']['name'])) {
                        $nama_foto = date('YmdHis') . '_' . rand(100, 999) . '.jpg';
                        move_uploaded_file($_FILES['foto']['tmp_name'], "assets/img_laporan/" . $nama_foto);
                    }
                    $kirim = $this->model->kirim_laporan($nis, $_POST['id_kategori'], $_POST['lokasi'], $_POST['ket'], $nama_foto);
                    
                    if ($kirim) {
                        echo "<script>alert('Laporan Terkirim!'); window.location='index.php?page=form';</script>";
                    } else {
                        echo "<script>alert('Gagal!'); window.location='index.php?page=form';</script>";
                    }
                    exit;
                }
                // Data untuk Form
                $kategori = $this->model->get_kategori();
                $riwayat  = $this->model->get_riwayat_siswa($nis); 
                break;

            case 'riwayat':
                $riwayat = $this->model->get_riwayat_selesai_final($nis);
                break;
                
            case 'akun':
                $q_profil = $this->model->get_profil_siswa($nis); 
                if ($q_profil && mysqli_num_rows($q_profil) > 0) {
                    $data = mysqli_fetch_assoc($q_profil);
                } else {
                    $data = [];
                }
                break;

            default: 
                // === PERBAIKAN DI SINI ===
                // Kita ambil data profil JUGA di halaman Home (default)
                // Agar variabel $data['nama'] tersedia di v_home.php
                $q_profil = $this->model->get_profil_siswa($nis);
                if ($q_profil && mysqli_num_rows($q_profil) > 0) {
                    $data = mysqli_fetch_assoc($q_profil);
                } else {
                    $data = [];
                }
                break;
        }

        // 3. LOAD TEMPLATE (Header & Sidebar)
        require_once 'views/template/header.php';
        require_once 'views/template/sidebar.php';

        // 4. LOAD VIEW (Isi Halaman)
        switch ($page) {
            case 'form':
            case 'simpan':
                require_once 'views/siswa/v_form.php';
                break;
            case 'riwayat':
                require_once 'views/siswa/v_riwayat.php';
                break;
            case 'akun':
                require_once 'views/siswa/v_akun.php';
                break;
            default:
                require_once 'views/siswa/v_home.php';
                break;
        }

        require_once 'views/template/footer.php';
    }

    // === EDIT ===
    public function edit()
    {
        if (!isset($_SESSION['nis'])) { header("Location: index.php?page=login"); exit; }
        $nis = $_SESSION['nis'];

        if (isset($_POST['update_laporan'])) {
            $foto_baru = null;
            if (!empty($_FILES['foto']['name'])) {
                $foto_baru = date('YmdHis').rand(100,999).'.jpg';
                move_uploaded_file($_FILES['foto']['tmp_name'], "assets/img_laporan/".$foto_baru);
            }
            if($this->model->update_laporan($_POST['id_pelaporan'], $nis, $_POST['lokasi'], $_POST['ket'], $foto_baru)){
                echo "<script>alert('Laporan Berhasil Diedit!'); window.location='index.php?page=form';</script>";
            } else {
                echo "<script>alert('Gagal! Laporan terkunci.'); window.location='index.php?page=form';</script>";
            }
        } else {
            $id = $_GET['id'];
            $data = $this->model->get_detail_laporan($id, $nis);
            
            if($data && mysqli_num_rows($data) > 0){
                $edit = mysqli_fetch_object($data);
                
                require_once 'views/template/header.php';
                require_once 'views/template/sidebar.php';
                require_once 'views/siswa/v_edit_aspirasi.php';
                require_once 'views/template/footer.php';
            } else {
                echo "<script>alert('Data tidak ditemukan'); window.location='index.php?page=form';</script>";
            }
        }
    }

    // === HAPUS ===
    public function hapus()
    {
        if (!isset($_SESSION['nis'])) { header("Location: index.php?page=login"); exit; }
        $nis = $_SESSION['nis'];
        
        if($this->model->hapus_laporan_siswa($_GET['id'], $nis)){
            echo "<script>alert('Laporan Dihapus!'); window.location='index.php?page=form';</script>";
        } else {
            echo "<script>alert('Gagal! Laporan terkunci.'); window.location='index.php?page=form';</script>";
        }
    }
}
?>