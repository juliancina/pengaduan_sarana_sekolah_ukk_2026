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
        
        $nis         = mysqli_real_escape_string($this->koneksi, $nis);
        $id_kategori = (int) $id_kategori; 
        $lokasi      = mysqli_real_escape_string($this->koneksi, $lokasi);
        $ket         = mysqli_real_escape_string($this->koneksi, $ket);
        $foto        = mysqli_real_escape_string($this->koneksi, $foto);

        // Query 1: Simpan data fisik laporan
        $q1 = "INSERT INTO tb_input_aspirasi (nis, id_kategori, lokasi, ket, foto, tgl_laporan) 
               VALUES ('$nis', '$id_kategori', '$lokasi', '$ket', '$foto', '$tgl')";

        if (mysqli_query($this->koneksi, $q1)) {
            $id_pelaporan = mysqli_insert_id($this->koneksi);

            // Query 2: Simpan status awal (0)
            $q2 = "INSERT INTO tb_aspirasi (id_pelaporan, status, id_kategori, feedback) 
                   VALUES ('$id_pelaporan', '0', '$id_kategori', 'Belum ada tanggapan')";
            
            if (!mysqli_query($this->koneksi, $q2)) {
                // Rollback jika gagal
                mysqli_query($this->koneksi, "DELETE FROM tb_input_aspirasi WHERE id_pelaporan = '$id_pelaporan'");
                return false;
            }
            return true;
        }
        return false;
    }

    // 4. AMBIL DATA LAPORAN (FUNGSI UTAMA YANG DIPERBAIKI)
    public function get_laporan($nis, $jenis_status) {
        $nis = mysqli_real_escape_string($this->koneksi, $nis);
        
        if ($jenis_status == "SELESAI") {
            // --- LOGIKA PERBAIKAN: AMBIL DARI TB_RIWAYAT ---
            // Kita ambil data penyelesaian dari tb_riwayat (r)
            // Kita ambil data foto/lokasi dari tb_input_aspirasi (i)
            // Kita ambil nama kategori dari tb_kategori (k)
            
            $query = "SELECT 
                        r.id_riwayat,
                        r.tgl_selesai, 
                        r.feedback,
                        i.id_pelaporan,
                        i.tgl_laporan, 
                        i.lokasi, 
                        i.ket, 
                        i.foto,
                        k.ket_kategori
                      FROM tb_riwayat r
                      JOIN tb_input_aspirasi i ON r.id_pelaporan = i.id_pelaporan
                      JOIN tb_kategori k ON r.id_kategori = k.id_kategori
                      WHERE i.nis = '$nis'
                      ORDER BY r.tgl_selesai DESC, r.id_riwayat DESC";

        } else {
            // --- LOGIKA LAMA: AMBIL DARI TB_ASPIRASI (Untuk Dashboard Samping) ---
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
                      WHERE t1.nis = '$nis'
                      AND (t2.status != 'Selesai' OR t2.status IS NULL)
                      ORDER BY t1.tgl_laporan DESC, t1.id_pelaporan DESC";
        }

        return mysqli_query($this->koneksi, $query);
    }

    // 5. STATISTIK DASHBOARD SISWA
    public function get_stats_siswa($nis) {
        $nis = mysqli_real_escape_string($this->koneksi, $nis);

        // Total Laporan Masuk
        $q1 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT id_pelaporan FROM tb_input_aspirasi WHERE nis='$nis'"));

        // Menunggu
        $q2 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             LEFT JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND (t2.status IS NULL OR t2.status = '0' OR t2.status = 'Menunggu')"));

        // Proses
        $q3 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis' AND t2.status = 'Proses'"));

        // Selesai (Hitung dari TB_RIWAYAT agar akurat)
        $q4 = mysqli_num_rows(mysqli_query($this->koneksi, 
            "SELECT t1.id_pelaporan FROM tb_input_aspirasi t1 
             JOIN tb_riwayat t2 ON t1.id_pelaporan = t2.id_pelaporan 
             WHERE t1.nis='$nis'"));
        
        return [
            'total'    => $q1,
            'menunggu' => $q2,
            'proses'   => $q3,
            'selesai'  => $q4
        ];
    }
}
?>