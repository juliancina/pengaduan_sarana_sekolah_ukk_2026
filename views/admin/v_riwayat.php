<div class="pc-container">
    <div class="pc-content">
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold text-dark"><i class="ti ti-filter me-2"></i>Filter Arsip Riwayat</h6>
            </div>
            <div class="card-body">
                <form action="index.php" method="GET" id="formFilter">
                    <input type="hidden" name="page" value="admin_riwayat">

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tanggal Selesai (Dari)</label>
                            <input type="date" name="tgl_awal" class="form-control form-control-sm" 
                                   value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tanggal Selesai (Sampai)</label>
                            <input type="date" name="tgl_akhir" class="form-control form-control-sm" 
                                   value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control form-control-sm" placeholder="Cari nama..." 
                                   value="<?= isset($_GET['nama']) ? $_GET['nama'] : '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select form-select-sm">
                                <option value="">-- Semua Kategori --</option>
                                <?php 
                                if(isset($data_kategori) && mysqli_num_rows($data_kategori) > 0) {
                                    mysqli_data_seek($data_kategori, 0); 
                                    while($k = mysqli_fetch_assoc($data_kategori)): 
                                        $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $k['id_kategori']; ?>" <?= $selected; ?>>
                                        <?= $k['ket_kategori']; ?>
                                    </option>
                                <?php endwhile; } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <a href="index.php?page=admin_riwayat" class="btn btn-sm btn-secondary me-1"><i class="ti ti-refresh"></i> Reset</a>
                            
                            <button type="submit" class="btn btn-sm btn-primary me-1"><i class="ti ti-search"></i> Terapkan Filter</button>
                            
                            <?php
                                // Membuat URL Cetak Dinamis berdasarkan filter saat ini
                                $url_cetak = "index.php?page=cetak_laporan";
                                if(isset($_GET['tgl_awal'])) $url_cetak .= "&tgl_awal=".$_GET['tgl_awal'];
                                if(isset($_GET['tgl_akhir'])) $url_cetak .= "&tgl_akhir=".$_GET['tgl_akhir'];
                                if(isset($_GET['nama']))      $url_cetak .= "&nama=".$_GET['nama'];
                                if(isset($_GET['kategori']))  $url_cetak .= "&kategori=".$_GET['kategori'];
                            ?>
                            <a href="<?= $url_cetak; ?>" target="_blank" class="btn btn-sm btn-warning"><i class="ti ti-printer"></i> Cetak PDF</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="ti ti-archive me-2"></i>Data Laporan Selesai</h5>
                <span class="badge bg-white text-success">
                    <?= (isset($data_riwayat)) ? mysqli_num_rows($data_riwayat) : 0; ?> Data
                </span>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tgl. Selesai</th>
                            <th>Pelapor</th>
                            <th>Masalah & Feedback</th>
                            <th>Bukti</th>
                            <th class="text-end pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($data_riwayat) && mysqli_num_rows($data_riwayat) > 0): 
                            while($row = mysqli_fetch_assoc($data_riwayat)): 
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-success">
                                        <?= date('d/m/Y', strtotime($row['tgl_selesai'])); ?>
                                    </span>
                                    <br>
                                    <small class="text-muted" style="font-size: 11px;">
                                        Lapor: <?= date('d/m/Y', strtotime($row['tgl_laporan'])); ?>
                                    </small>
                                </td>
                                
                                <td>
                                    <div class="fw-bold text-dark"><?= $row['nama']; ?></div>
                                    <small class="text-muted">Kelas: <?= $row['kelas']; ?></small>
                                </td>

                                <td style="max-width: 320px;">
                                    <span class="badge bg-light text-dark border mb-1"><?= $row['ket_kategori']; ?></span>
                                    <div class="mb-2 text-truncate text-muted small">
                                        "<?= substr($row['ket'], 0, 70); ?>..."
                                    </div>
                                    <div class="alert alert-success py-1 px-2 mb-0 d-inline-block small" style="font-size: 12px;">
                                        <i class="ti ti-check-double me-1"></i> 
                                        <b>Tanggapan:</b> <?= $row['feedback']; ?>
                                    </div>
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalFoto"
                                            data-foto="assets/img_laporan/<?= $row['foto']; ?>"
                                            data-judul="Bukti - <?= $row['nama']; ?>">
                                        <i class="ti ti-photo"></i>
                                    </button>
                                </td>

                                <td class="text-end pe-4">
                                    <span class="badge bg-success rounded-pill px-3">
                                        <i class="ti ti-check-circle me-1"></i> Selesai
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="ti ti-archive-off fs-1 mb-3 d-block opacity-25"></i>
                                    <span class="fw-bold">Tidak ada riwayat laporan yang ditemukan.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulFoto">Bukti Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center bg-light p-2">
                <img src="" id="tampilFoto" class="img-fluid rounded shadow-sm">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalFoto = document.getElementById('modalFoto');
    modalFoto.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        modalFoto.querySelector('#judulFoto').textContent = btn.getAttribute('data-judul');
        modalFoto.querySelector('#tampilFoto').src = btn.getAttribute('data-foto');
    });
});
</script>