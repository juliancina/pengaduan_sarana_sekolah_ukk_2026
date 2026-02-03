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
        
        // Sanitasi Data untuk mencegah error database
        $nis         = mysqli_real_escape_string($this->koneksi, $nis);
        $id_kategori = (int) $id_kategori; 
        $lokasi      = mysqli_real_escape_string($this->koneksi, $lokasi);
        $ket         = mysqli_real_escape_string($this->koneksi, $ket);
        $foto        = mysqli_real_escape_string($this->koneksi, $foto);

        // --- QUERY 1: Simpan Data Utama ke tb_input_aspirasi ---
        $q1 = "INSERT INTO tb_input_aspirasi (nis, id_kategori, lokasi, ket, foto, tgl_laporan) 
               VALUES ('$nis', '$id_kategori', '$lokasi', '$ket', '$foto', '$tgl')";

        if (mysqli_query($this->koneksi, $q1)) {
            // Ambil ID yang baru saja terbentuk
            $id_pelaporan = mysqli_insert_id($this->koneksi);

            // --- QUERY 2: Buat status awal di tb_aspirasi ---
            // Status default: 0 (Belum diverifikasi)
            $q2 = "INSERT INTO tb_aspirasi (id_pelaporan, status, id_kategori, feedback) 
                   VALUES ('$id_pelaporan', '0', '$id_kategori', 'Belum ada tanggapan')";
            
            if (!mysqli_query($this->koneksi, $q2)) {
                // Jika Query 2 gagal, Hapus data Query 1 agar tidak jadi sampah data
                mysqli_query($this->koneksi, "DELETE FROM tb_input_aspirasi WHERE id_pelaporan = '$id_pelaporan'");
                return false;
            }
            return true;
        }
        return false;
    }

    // 4. AMBIL DATA LAPORAN SISWA (DIPERBAIKI: FILTER & URUTAN)
    // Fungsi ini dipakai di halaman FORM (Daftar Samping) dan RIWAYAT
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

        // LOGIKA FILTER STATUS
        if ($jenis_status == "SELESAI") {
            // Untuk Menu Riwayat: Hanya ambil yang statusnya 'Selesai'
            $query .= " AND t2.status = 'Selesai'"; 
        } else {
            // Untuk Menu Form (Samping): Ambil SEMUA yang BELUM Selesai
            // (Termasuk: 0, Menunggu, Proses)
            $query .= " AND (t2.status != 'Selesai' OR t2.status IS NULL)";
        }

        // --- BAGIAN PENTING (PERBAIKAN) ---
        // Menambahkan ORDER BY agar data TERBARU muncul DI ATAS
        $query .= " ORDER BY t1.tgl_laporan DESC, t1.id_pelaporan DESC";

        return mysqli_query($this->koneksi, $query);
    }

    // 5. STATISTIK DASHBOARD SISWA
    public function get_stats_siswa($nis) {
        $nis = mysqli_real_escape_string($this->koneksi, $nis);

        // 1. Total Semua Laporan Siswa Ini
        $q1 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT id_pelaporan FROM tb_input_aspirasi WHERE nis='$nis'"));

        // 2. Menunggu (Status 0 atau Menunggu)
        $q2 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             LEFT JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND (t2.status IS NULL OR t2.status = '0' OR t2.status = 'Menunggu')"));

        // 3. Proses (Status Proses)
        $q3 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND t2.status = 'Proses'"));

        // 4. Selesai (Status Selesai)
        $q4 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND t2.status = 'Selesai'"));
        
        return [
            'total'    => $q1,
            'menunggu' => $q2,
            'proses'   => $q3,
            'selesai'  => $q4
        ];
    }
}
?>