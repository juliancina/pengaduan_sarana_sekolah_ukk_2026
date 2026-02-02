<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Pengaduan</title>
    <link rel="stylesheet" href="assets/css/style.css"> <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 30px; text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN PENGADUAN SARANA SEKOLAH</h2>
        <p>SMK NEGERI CONTOH</p>
    </div>

    <div style="margin-bottom: 15px;">
        <strong>Periode:</strong> 
        <?= !empty($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '-'; ?> s/d 
        <?= !empty($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '-'; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Selesai</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th>Isi Laporan</th>
                <th>Tanggapan Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(isset($data_cetak) && mysqli_num_rows($data_cetak) > 0): 
                while($d = mysqli_fetch_assoc($data_cetak)): 
            ?>
            <tr>
                <td style="text-align:center;"><?= $no++; ?></td>
                <td><?= date('d/m/Y', strtotime($d['tgl_selesai'])); ?></td>
                <td><?= $d['nama']; ?></td>
                <td><?= $d['kelas']; ?></td>
                <td><?= $d['ket_kategori']; ?></td>
                <td><?= $d['ket']; ?></td>
                <td><?= $d['feedback']; ?></td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">Tidak ada data laporan pada periode ini.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: <?= date('d-m-Y H:i'); ?></p>
        <br><br><br>
        <p>( Bagian Sarana & Prasarana )</p>
    </div>

</body>
</html>