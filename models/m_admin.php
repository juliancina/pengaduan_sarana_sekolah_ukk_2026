<?php
require_once 'config/cn_database.php';

class m_admin extends Database {

    public function get_stats() {
        $q1 = mysqli_num_rows(mysqli_query($this->koneksi, "SELECT * FROM tb_aspirasi WHERE status='' OR status='0' OR status IS NULL"));
        $q2 = mysqli_num_rows(mysqli_query($this->koneksi, "SELECT * FROM tb_aspirasi WHERE status='Menunggu'"));
        $q3 = mysqli_num_rows(mysqli_query($this->koneksi, "SELECT * FROM tb_aspirasi WHERE status='Proses'"));
        $q4 = mysqli_num_rows(mysqli_query($this->koneksi, "SELECT * FROM tb_riwayat"));
        $q5 = mysqli_num_rows(mysqli_query($this->koneksi, "SELECT * FROM tb_siswa"));
        return ['laporan_masuk' => $q1, 'menunggu' => $q2, 'proses' => $q3, 'selesai' => $q4, 'total_siswa' => $q5];
    }

    public function get_kategori() {
        return mysqli_query($this->koneksi, "SELECT * FROM tb_kategori");
    }

    public function get_laporan_aktif($filter = []) {
        $query = "SELECT 
                    t1.id_pelaporan, t1.tgl_laporan, t1.foto, t1.ket, t1.lokasi,
                    t3.nama, t3.nis, t3.kelas,
                    t4.ket_kategori,
                    COALESCE(t2.status, '0') as status,
                    COALESCE(t2.feedback, '-') as feedback
                  FROM tb_input_aspirasi t1
                  LEFT JOIN tb_aspirasi t2 ON t1.id_pelaporan = t2.id_pelaporan
                  LEFT JOIN tb_siswa t3 ON t1.nis = t3.nis
                  LEFT JOIN tb_kategori t4 ON t1.id_kategori = t4.id_kategori
                  WHERE 1=1"; 

        if (!empty($filter['tgl_awal'])) { 
            $tgl_awal = mysqli_real_escape_string($this->koneksi, $filter['tgl_awal']);
            $query .= " AND t1.tgl_laporan >= '$tgl_awal'"; 
        }
        if (!empty($filter['tgl_akhir'])) { 
            $tgl_akhir = mysqli_real_escape_string($this->koneksi, $filter['tgl_akhir']);
            $query .= " AND t1.tgl_laporan <= '$tgl_akhir'"; 
        }
        if (!empty($filter['nama'])) { 
            $nama = mysqli_real_escape_string($this->koneksi, $filter['nama']);
            $query .= " AND t3.nama LIKE '%$nama%'"; 
        }
        
        // Logika Status
        if (isset($filter['status']) && $filter['status'] !== '') {
            $st = mysqli_real_escape_string($this->koneksi, $filter['status']);
            if ($st == '0') { 
                $query .= " AND (t2.status = '0' OR t2.status IS NULL OR t2.status = '')"; 
            } else { 
                $query .= " AND t2.status = '$st'"; 
            }
        } else {
            // Tampilkan semua KECUALI yang Selesai
            $query .= " AND (t2.status != 'Selesai' OR t2.status IS NULL OR t2.status = '')";
        }

        $query .= " ORDER BY t1.tgl_laporan DESC, t1.id_pelaporan DESC";
        return mysqli_query($this->koneksi, $query);
    }

    public function get_riwayat_filter($filter = []) {
        $query = "SELECT 
                    r.id_riwayat, r.tgl_selesai, r.feedback,
                    i.tgl_laporan, i.foto, i.ket, i.lokasi,
                    s.nama, s.kelas, s.nis,
                    k.ket_kategori
                  FROM tb_riwayat r
                  JOIN tb_input_aspirasi i ON r.id_pelaporan = i.id_pelaporan
                  JOIN tb_siswa s ON i.nis = s.nis
                  JOIN tb_kategori k ON r.id_kategori = k.id_kategori
                  WHERE 1=1";

        if (!empty($filter['tgl_awal'])) { $query .= " AND r.tgl_selesai >= '{$filter['tgl_awal']}'"; }
        if (!empty($filter['tgl_akhir'])) { $query .= " AND r.tgl_selesai <= '{$filter['tgl_akhir']}'"; }
        if (!empty($filter['nama'])) { $query .= " AND s.nama LIKE '%{$filter['nama']}%'"; }
        
        $query .= " ORDER BY r.tgl_selesai DESC";
        return mysqli_query($this->koneksi, $query);
    }

    public function delete_laporan($id_pelaporan) {
        //$id_pelaporan = mysqli_real_escape_string($this->koneksi, $id_pelaporan);
        
        $q_foto = mysqli_query($this->koneksi, "SELECT foto FROM tb_input_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        $data = mysqli_fetch_assoc($q_foto);
        
        if ($data && $data['foto'] != 'default.png' && file_exists('assets/img_laporan/' . $data['foto'])) {
            unlink('assets/img_laporan/' . $data['foto']);
        }

        mysqli_query($this->koneksi, "DELETE FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        mysqli_query($this->koneksi, "DELETE FROM tb_riwayat WHERE id_pelaporan='$id_pelaporan'");
        return mysqli_query($this->koneksi, "DELETE FROM tb_input_aspirasi WHERE id_pelaporan='$id_pelaporan'");
    }

    // FUNGSI UPDATE YANG SUDAH DIPERBAIKI LOGIKANYA
    public function update_tanggapan($id_pelaporan, $status_baru, $feedback, $id_admin) {
        $tgl = date('Y-m-d H:i:s');
        $id_pelaporan = mysqli_real_escape_string($this->koneksi, $id_pelaporan);
        $status_baru  = mysqli_real_escape_string($this->koneksi, $status_baru);
        $feedback     = mysqli_real_escape_string($this->koneksi, $feedback);
        $id_admin     = mysqli_real_escape_string($this->koneksi, $id_admin);

        // Ambil ID Kategori dulu (wajib untuk insert)
        $cek_kat = mysqli_query($this->koneksi, "SELECT id_kategori FROM tb_input_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        $dat_kat = mysqli_fetch_assoc($cek_kat);
        $id_kat = $dat_kat['id_kategori'];

        // Jika Status SELESAI -> Pindah ke tb_riwayat
        if ($status_baru == 'Selesai') {
            $q_insert = "INSERT INTO tb_riwayat (id_pelaporan, id_kategori, id_admin, tgl_selesai, feedback) 
                         VALUES ('$id_pelaporan', '$id_kat', '$id_admin', '$tgl', '$feedback')";
            
            if (mysqli_query($this->koneksi, $q_insert)) {
                mysqli_query($this->koneksi, "DELETE FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
                return true;
            }
            return false;
        } 
        // Jika Status LAINNYA (Proses/Ditolak/Menunggu) -> Update/Insert tb_aspirasi
        else {
            $cek_exist = mysqli_query($this->koneksi, "SELECT * FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
            
            if(mysqli_num_rows($cek_exist) > 0){
                // Data sudah ada, lakukan UPDATE
                $q = "UPDATE tb_aspirasi SET status='$status_baru', feedback='$feedback', id_admin='$id_admin', tgl_feedback='$tgl' WHERE id_pelaporan='$id_pelaporan'";
            } else {
                // Data baru (sebelumnya belum direspon), lakukan INSERT
                $q = "INSERT INTO tb_aspirasi (id_pelaporan, id_kategori, status, feedback, id_admin, tgl_feedback) 
                      VALUES ('$id_pelaporan', '$id_kat', '$status_baru', '$feedback', '$id_admin', '$tgl')";
            }
            return mysqli_query($this->koneksi, $q);
        }
    }
}
?>