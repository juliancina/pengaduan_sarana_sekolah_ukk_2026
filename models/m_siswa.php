<?php
require_once 'config/cn_database.php';

class m_siswa extends Database
{
    // 1. AMBIL KATEGORI
    public function get_kategori()
    {
        return mysqli_query($this->koneksi, "SELECT * FROM tb_kategori");
    }

    // 2. KIRIM LAPORAN
    public function kirim_laporan($nis, $id_kategori, $lokasi, $ket, $nama_foto)
    {
        $tgl = date('Y-m-d H:i:s');
        
        // A. Insert Data Fisik
        $q1 = "INSERT INTO tb_input_aspirasi (nis, id_kategori, lokasi, ket, foto, tgl_laporan) 
               VALUES ('$nis', '$id_kategori', '$lokasi', '$ket', '$nama_foto', '$tgl')";
        
        if (mysqli_query($this->koneksi, $q1)) {
            $id_pelaporan = mysqli_insert_id($this->koneksi);

            // B. Insert Status Awal '0'
            $q2 = "INSERT INTO tb_aspirasi (id_pelaporan, status, id_kategori, feedback) 
                   VALUES ('$id_pelaporan', '0', '$id_kategori', '-')";
            
            return mysqli_query($this->koneksi, $q2);
        }
        return false;
    }

    // 3. AMBIL DATA FORM (Untuk Halaman Form & Tabel Status)
    public function get_riwayat_siswa($nis)
    {
        $query = "SELECT 
                    i.*, 
                    k.ket_kategori,
                    COALESCE(a.status, '0') as status_terkini
                  FROM tb_input_aspirasi i
                  JOIN tb_kategori k ON i.id_kategori = k.id_kategori
                  LEFT JOIN tb_aspirasi a ON i.id_pelaporan = a.id_pelaporan
                  WHERE i.nis = '$nis'
                  AND (a.status != 'Selesai' OR a.status IS NULL)
                  ORDER BY i.tgl_laporan DESC";
                  
        return mysqli_query($this->koneksi, $query);
    }

// === 4. AMBIL RIWAYAT SELESAI (FIXED: JOIN 3 TABEL) === \\
public function get_riwayat_selesai_final($nis)
{
    // Penjelasan Query:
    // 1. Ambil tgl_selesai & feedback dari tb_riwayat (r)
    // 2. Ambil foto, lokasi, & ket dari tb_input_aspirasi (i) -> Karena di tb_riwayat kosong/null
    // 3. Filter berdasarkan i.nis (karena tb_riwayat tidak punya kolom nis)
    
    $q = "SELECT 
            r.id_riwayat,
            r.tgl_selesai,
            r.feedback,
            k.ket_kategori,
            i.foto,      
            i.lokasi,    
            i.ket        
          FROM tb_riwayat r
          JOIN tb_input_aspirasi i ON r.id_pelaporan = i.id_pelaporan
          JOIN tb_kategori k ON r.id_kategori = k.id_kategori
          WHERE i.nis = '$nis'
          ORDER BY r.tgl_selesai DESC";
          
    return mysqli_query($this->koneksi, $q);
}

    // 5. DETAIL UNTUK EDIT
    public function get_detail_laporan($id_pelaporan, $nis)
    {
        $cek = mysqli_query($this->koneksi, "SELECT status FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        $stt = mysqli_fetch_assoc($cek);

        if ($stt && $stt['status'] != '0' && $stt['status'] != 'Menunggu' && $stt['status'] != '') {
            return false;
        }

        return mysqli_query($this->koneksi, "SELECT * FROM tb_input_aspirasi WHERE id_pelaporan='$id_pelaporan' AND nis='$nis'");
    }

    // 6. UPDATE LAPORAN
    public function update_laporan($id_pelaporan, $nis, $lokasi, $ket, $nama_foto = null)
    {
        $cek = mysqli_query($this->koneksi, "SELECT status FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        $stt = mysqli_fetch_assoc($cek);
        
        if ($stt && $stt['status'] != '0' && $stt['status'] != 'Menunggu' && $stt['status'] != '') {
            return false; 
        }

        $lokasi = mysqli_real_escape_string($this->koneksi, $lokasi);
        $ket    = mysqli_real_escape_string($this->koneksi, $ket);

        if ($nama_foto != null) {
            $q = "UPDATE tb_input_aspirasi SET lokasi='$lokasi', ket='$ket', foto='$nama_foto' WHERE id_pelaporan='$id_pelaporan' AND nis='$nis'";
        } else {
            $q = "UPDATE tb_input_aspirasi SET lokasi='$lokasi', ket='$ket' WHERE id_pelaporan='$id_pelaporan' AND nis='$nis'";
        }

        return mysqli_query($this->koneksi, $q);
    }

    // 7. HAPUS LAPORAN
    public function hapus_laporan_siswa($id_pelaporan, $nis)
    {
        $cek = mysqli_query($this->koneksi, "SELECT status FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        $stt = mysqli_fetch_assoc($cek);

        if ($stt && $stt['status'] != '0' && $stt['status'] != 'Menunggu' && $stt['status'] != '') {
            return false; 
        }

        $q_foto = mysqli_query($this->koneksi, "SELECT foto FROM tb_input_aspirasi WHERE id_pelaporan='$id_pelaporan' AND nis='$nis'");
        $data = mysqli_fetch_assoc($q_foto);
        
        if ($data && $data['foto'] != 'default.png' && file_exists('assets/img_laporan/' . $data['foto'])) {
            unlink('assets/img_laporan/' . $data['foto']);
        }

        mysqli_query($this->koneksi, "DELETE FROM tb_aspirasi WHERE id_pelaporan='$id_pelaporan'");
        return mysqli_query($this->koneksi, "DELETE FROM tb_input_aspirasi WHERE id_pelaporan='$id_pelaporan'");
    }

    // 8. AMBIL PROFIL SISWA (INI YANG SEBELUMNYA KURANG/ERROR)
    public function get_profil_siswa($nis)
    {
        return mysqli_query($this->koneksi, "SELECT * FROM tb_siswa WHERE nis='$nis'");
    }

} // <--- Pastikan kurung penutup class ada di sini
?>