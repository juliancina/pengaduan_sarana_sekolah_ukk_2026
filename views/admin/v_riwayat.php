<div class="pc-container">
    <div class="pc-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Arsip Riwayat Laporan</h4>
                <p class="text-muted small mb-0">Daftar semua laporan yang telah selesai diproses.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="ti ti-filter me-2 text-primary"></i>Filter Data Riwayat</h6>
            </div>
            <div class="card-body p-4">
                <form action="index.php" method="GET" id="formFilter">
                    <input type="hidden" name="page" value="admin_riwayat">

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Dari Tanggal (Selesai)</label>
                            <input type="date" name="tgl_awal" class="form-control"
                                value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Sampai Tanggal (Selesai)</label>
                            <input type="date" name="tgl_akhir" class="form-control"
                                value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" placeholder="Cari nama pelapor..."
                                value="<?= isset($_GET['nama']) ? $_GET['nama'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Kategori Laporan</label>
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                <?php
                                $kats = $this->model->get_kategori();
                                while ($k = mysqli_fetch_assoc($kats)) {
                                    $sel = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? 'selected' : '';
                                    echo "<option value='{$k['id_kategori']}' $sel>{$k['ket_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="index.php?page=admin_riwayat" class="btn btn-light border shadow-sm px-3" title="Bersihkan Filter">
                            <i class="ti ti-refresh text-secondary me-1"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary shadow-sm px-4" title="Terapkan Filter">
                            <i class="ti ti-search me-1"></i> Cari Data
                        </button>
                        <button type="button" class="btn btn-danger shadow-sm px-4" onclick="cetakPDF()" title="Cetak ke PDF">
                            <i class="ti ti-printer me-1"></i> Cetak PDF
                        </button>
                    </div>
                </form>

                <script>
                    function cetakPDF() {
                        var form = document.getElementById('formFilter');
                        var formData = new FormData(form);
                        formData.set('page', 'cetak_laporan'); // Mencegah tabrakan URL
                        var url = 'index.php?' + new URLSearchParams(formData).toString();
                        window.open(url, '_blank');
                    }
                </script>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="15%">Waktu</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="20%">Pelapor</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="55%">Masalah & Tanggapan</th>
                                <th class="px-4 py-3 text-center text-secondary small fw-bold text-uppercase" width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data_riwayat && mysqli_num_rows($data_riwayat) > 0): ?>
                                <?php while ($r = mysqli_fetch_assoc($data_riwayat)): ?>
                                    <tr>
                                        <td class="px-4 py-3 align-top">
                                            <div class="fw-bold text-dark mb-1">
                                                <i class="ti ti-calendar-check text-success me-1"></i> 
                                                <?= date('d M Y', strtotime($r['tgl_selesai'])) ?>
                                            </div>
                                            <div class="small text-muted" style="font-size: 0.8rem;">
                                                Dikirim: <?= date('d M Y', strtotime($r['tgl_laporan'])) ?>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 align-top">
                                            <div class="d-flex align-items-start">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2 mt-1" style="width: 32px; height: 32px; flex-shrink: 0;">
                                                    <i class="ti ti-user fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-1"><?= htmlspecialchars($r['nama']) ?></div>
                                                    <div class="small text-muted mb-0">NIS: <?= htmlspecialchars($r['nis']) ?></div>
                                                    <div class="small text-muted">Kelas: <?= htmlspecialchars($r['kelas']) ?></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 align-top">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 mb-2 px-2 py-1">
                                                <i class="ti ti-category me-1"></i> <?= htmlspecialchars($r['ket_kategori']) ?>
                                            </span>
                                            
                                            <div class="text-dark mb-3 text-wrap" style="font-size: 0.9rem;">
                                                <strong>Keluhan:</strong> <?= htmlspecialchars($r['ket']) ?>
                                            </div>
                                            
                                            <div class="bg-light p-3 rounded-3 border-start border-4 border-success">
                                                <div class="small fw-bold text-success mb-1">
                                                    <i class="ti ti-messages me-1"></i> Tanggapan Petugas:
                                                </div>
                                                <div class="text-muted small" style="white-space: pre-wrap;"><?= isset($r['feedback']) && $r['feedback'] != '' ? htmlspecialchars($r['feedback']) : 'Laporan telah diselesaikan dan ditutup.' ?></div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 text-center align-top pt-4">
                                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">
                                                <i class="ti ti-check me-1"></i> Selesai
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-4 opacity-50">
                                            <i class="ti ti-archive-off text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                            <span class="fw-bold text-muted fs-5">Tidak ada data riwayat laporan.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-3 text-muted small d-flex justify-content-between align-items-center">
                <span>Menampilkan data riwayat yang difilter.</span>
                <span class="badge bg-dark px-2 py-1"><?= isset($data_riwayat) ? mysqli_num_rows($data_riwayat) : 0 ?> Data Ditemukan</span>
            </div>
        </div>

    </div>
</div>