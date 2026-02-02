<?php
require_once 'config/cn_database.php';

class m_pengaduan extends Database {

    // 1. AMBIL DATA SISWA
    public function get_siswa($nis) {
        $nis = mysqli_real_escape_string($this->koneksi, $nis);
        return mysqli_query($this->koneksi, "SELECT * FROM tb_siswa WHERE nis = '$nis'");
    }

    // 2. AMBIL DATA KATEGORI
    public function get_kategori() {
        return mysqli_query($this->koneksi, "SELECT * FROM tb_kategori");
    }

    // 3. SIMPAN LAPORAN
    public function simpan_aspirasi($nis, $id_kategori, $lokasi, $ket, $foto) {
        $tgl = date('Y-m-d');
        
        // Sanitasi Data
        $nis         = mysqli_real_escape_string($this->koneksi, $nis);
        $id_kategori = (int) $id_kategori; 
        $lokasi      = mysqli_real_escape_string($this->koneksi, $lokasi);
        $ket         = mysqli_real_escape_string($this->koneksi, $ket);
        $foto        = mysqli_real_escape_string($this->koneksi, $foto);

        // --- QUERY 1: Simpan Data Utama ---
        $q1 = "INSERT INTO tb_input_aspirasi (nis, id_kategori, lokasi, ket, foto, tgl_laporan) 
               VALUES ('$nis', '$id_kategori', '$lokasi', '$ket', '$foto', '$tgl')";

        if (mysqli_query($this->koneksi, $q1)) {
            // Ambil ID Pelaporan yang baru saja dibuat
            $id_pelaporan = mysqli_insert_id($this->koneksi);
            
            // --- QUERY 2: Buat Status Awal di tb_aspirasi ---
            // Status '0' artinya belum diverifikasi
            $q2 = "INSERT INTO tb_aspirasi (id_pelaporan, id_kategori, status, feedback, id_admin, tgl_feedback) 
                   VALUES ('$id_pelaporan', '$id_kategori', '0', '', NULL, NULL)";
            
            $hasil_q2 = mysqli_query($this->koneksi, $q2);
            return $hasil_q2;
        } else {
            return false;
        }
    }

    // 4. AMBIL RIWAYAT LAPORAN
    public function get_laporan($nis, $jenis_status) {
        $nis = mysqli_real_escape_string($this->koneksi, $nis);
        
        $query = "SELECT 
                    t1.id_pelaporan,
                    t1.lokasi, 
                    t1.ket, 
                    t1.foto,
                    t1.tgl_laporan, 
                    COALESCE(t2.status, '0') as status, 
                    COALESCE(t2.feedback, 'Belum ada tanggapan') as feedback,
                    t3.ket_kategori
                  FROM tb_input_aspirasi t1
                  LEFT JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan
                  LEFT JOIN tb_kategori t3 ON t1.id_kategori = t3.id_kategori
                  WHERE t1.nis = '$nis'";

        if ($jenis_status == "SELESAI") {
            // Cek status Selesai ATAU data sudah masuk tabel riwayat (opsional, tergantung struktur DB Anda)
            // Di sini kita asumsikan yang sudah selesai statusnya 'Selesai' di tb_aspirasi
            // atau jika sistem Anda memindahkan ke tb_riwayat, query ini perlu disesuaikan.
            // Untuk amannya kita cek status 'Selesai'
            $query .= " AND t2.status = 'Selesai'";
        } else {
            // Menampilkan yang BELUM selesai (0, Menunggu, Proses, Ditolak)
            $query .= " AND (t2.status = '0' OR t2.status = 'Menunggu' OR t2.status = 'Proses' OR t2.status = 'Ditolak' OR t2.status IS NULL)";
        }
        
        $query .= " ORDER BY t1.tgl_laporan DESC";

        return mysqli_query($this->koneksi, $query);
    }

    // =========================================================================
    // 5. AMBIL STATISTIK DASHBOARD SISWA (FUNGSI BARU)
    // =========================================================================
    public function get_stats_siswa($nis) {
        $nis = mysqli_real_escape_string($this->koneksi, $nis);

        // 1. Total Laporan Diajukan (Semua data di tb_input_aspirasi milik siswa)
        $q1 = mysqli_num_rows(mysqli_query($this->koneksi, "SELECT * FROM tb_input_aspirasi WHERE nis='$nis'"));

        // 2. Menunggu (Belum ada status / status 0 / status Menunggu)
        $q2 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             LEFT JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND (t2.status IS NULL OR t2.status = '0' OR t2.status = 'Menunggu')"));

        // 3. Proses (Status 'Proses')
        $q3 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND t2.status = 'Proses'"));

        // 4. Selesai (Cek di tb_aspirasi status 'Selesai' DAN cek tb_riwayat)
        $cek_asp = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND t2.status = 'Selesai'"));
        
        $cek_riw = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_riwayat t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis'"));

        $total_selesai = $cek_asp + $cek_riw;

        return [
            'total' => $q1,
            'menunggu' => $q2,
            'proses' => $q3,
            'selesai' => $total_selesai
        ];
    }

} 
?>