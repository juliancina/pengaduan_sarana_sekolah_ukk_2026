<?php
class c_auth
{
    public function login_view()
    {
        // Jika sudah punya sesi, langsung arahkan sesuai level (Fitur dasar)
        if (isset($_SESSION['level'])) {
            if ($_SESSION['level'] == 'admin') {
                echo "<script>window.location='index.php?page=admin_dashboard';</script>";
            } else {
                echo "<script>window.location='index.php?page=home';</script>";
            }
            exit;
        }
        include 'views/auth/v_login.php';
    }

    public function register_view()
    {
        include 'views/auth/v_register.php';
    }

    public function login_action()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        require_once 'config/cn_database.php';
        $db = new Database();

        $input_nama = $_POST['username']; 
        $input_nis  = $_POST['password']; 
        
        // Enkripsi password inputan menjadi MD5 untuk dicocokkan
        $password_cek = md5($input_nis);

        // -----------------------------------------------------------
        // 1. CEK LOGIN SISWA
        // -----------------------------------------------------------
        $q_siswa = "SELECT * FROM tb_siswa WHERE nama='$input_nama' AND password='$password_cek'";
        $exec_siswa = mysqli_query($db->koneksi, $q_siswa);
        
        if (mysqli_num_rows($exec_siswa) > 0) {
            $d = mysqli_fetch_assoc($exec_siswa);
            
            // SECURITY: Ganti ID sesi & Bersihkan variabel Admin (Anti-Tabrakan)
            session_regenerate_id(true);
            unset($_SESSION['id_admin']); 
            unset($_SESSION['username']); 

            // Set Session Siswa
            $_SESSION['nis'] = $d['nis'];
            $_SESSION['nama'] = $d['nama'];
            $_SESSION['level'] = 'siswa';
            
            echo "<script>alert('Login Berhasil! Selamat Datang Siswa.'); window.location='index.php?page=home';</script>";
            return;
        }

        // -----------------------------------------------------------
        // 2. CEK LOGIN ADMIN
        // -----------------------------------------------------------
        // Perbaikan: Menggunakan $password_cek (MD5) bukan $input_nis (mentah)
        $q_admin = "SELECT * FROM tb_admin WHERE username='$input_nama' AND password='$password_cek'"; 
        $exec_admin = mysqli_query($db->koneksi, $q_admin);

        if (mysqli_num_rows($exec_admin) > 0) {
            $d = mysqli_fetch_assoc($exec_admin);

            // SECURITY: Ganti ID sesi & Bersihkan variabel Siswa (Anti-Tabrakan)
            session_regenerate_id(true);
            unset($_SESSION['nis']);
            unset($_SESSION['nama']);

            // Set Session Admin
            $_SESSION['id_admin'] = $d['id_admin'];
            $_SESSION['username'] = $d['username'];
            $_SESSION['level'] = 'admin';

            echo "<script>alert('Login Berhasil! Selamat Datang Admin.'); window.location='index.php?page=admin_dashboard';</script>";
        } else {
            echo "<script>alert('Login Gagal! Username atau Password salah.'); window.location='index.php?page=login';</script>";
        }
    }

    public function logout()
    {
        // Hapus total semua variabel sesi
        $_SESSION = [];

        // Hapus cookie sesi browser
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        echo "<script>alert('Anda telah logout!'); window.location = 'index.php?page=login';</script>";
    }

    public function register_action()
    {
        require_once 'config/cn_database.php';
        $db = new Database();

        $nis   = $_POST['nis'];
        $nama  = $_POST['nama'];
        $kelas = $_POST['kelas'];
        
        $password_otomatis = md5($nis); 

        $cek = mysqli_query($db->koneksi, "SELECT * FROM tb_siswa WHERE nis='$nis'");
        if (mysqli_num_rows($cek) > 0) {
            echo "<script>alert('NIS $nis sudah terdaftar!'); window.location='index.php?page=register';</script>";
            return;
        }

        $query = "INSERT INTO tb_siswa (nis, nama, kelas, password) VALUES ('$nis', '$nama', '$kelas', '$password_otomatis')";
        
        if (mysqli_query($db->koneksi, $query)) {
            echo "<script>
                alert('Pendaftaran Sukses! Silakan Login.\\nUsername: $nama\\nPassword: $nis'); 
                window.location='index.php?page=login';
            </script>";
        } else {
            echo "<script>alert('Gagal Daftar!'); window.location='index.php?page=register';</script>";
        }
    }
}
?>