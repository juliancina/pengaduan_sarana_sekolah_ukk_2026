<?php

class c_auth
{

    public function login_view()
    {
        include 'views/v_login.php';
    }

    public function login_action()
    {
        $db = new database();

        // Ambil data dari form \\
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // 1. CEK DATA ADMIN \\
        $query_admin = mysqli_query($db->koneksi, "SELECT * FROM tb_admin WHERE username='$username' AND password='$password'");
        $cek_admin = mysqli_num_rows($query_admin);

        if ($cek_admin > 0) {
            $data = mysqli_fetch_assoc($query_admin);
            $_SESSION['user_id'] = $data['id_admin'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = 'admin';

            // Redirect ke Dashboard Admin \\
            header("Location: index.php?page=admin_dashboard");
            exit;
        }


        $query_siswa = mysqli_query($db->koneksi, "SELECT * FROM tb_siswa WHERE nis='$username'");
        $cek_siswa = mysqli_num_rows($query_siswa);

        if ($cek_siswa > 0) {
            $data = mysqli_fetch_assoc($query_siswa);
            $_SESSION['user_id'] = $data['nis'];
            $_SESSION['kelas'] = $data['kelas'];
            $_SESSION['role'] = 'siswa';

            // Redirect ke Dashboard Siswa \\
            echo "<script>alert('Login Siswa Berhasil!'); window.location='index.php';</script>";
            exit;
        }

        // JIKA GAGAL SEMUANYA \\
        echo "<script>alert('Username atau Password Salah!'); window.location='index.php?page=login';</script>";
    }

    public function logout()
    {
        session_destroy();
        header("Location: index.php?page=login");
    }
}
