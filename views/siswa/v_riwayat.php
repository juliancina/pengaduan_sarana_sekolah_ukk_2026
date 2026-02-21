<div class="pc-container">
    <div class="pc-content">

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" 
                     style="background: linear-gradient(135deg, #0d9488 0%, #115e59 100%);">
                    <div class="card-body p-4 text-white position-relative z-1">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                                <i class="ti ti-history fs-3"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">Riwayat Laporan Selesai</h4>
                                <p class="mb-0 opacity-90">Arsip laporan Anda yang telah selesai ditindaklanjuti oleh petugas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="20%">Info Waktu</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="30%">Detail Laporan</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="35%">Tanggapan Petugas</th>
                                <th class="px-4 py-3 text-center text-secondary small fw-bold text-uppercase" width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($riwayat) && mysqli_num_rows($riwayat) > 0): ?>
                                <?php while($r = mysqli_fetch_assoc($riwayat)): ?>
                                <tr>
                                    <td class="px-4 py-3 align-top">
                                        <div class="fw-bold text-success mb-1">
                                            <i class="ti ti-calendar-check me-1"></i> <?= isset($r['tgl_selesai']) ? date('d M Y', strtotime($r['tgl_selesai'])) : '-'; ?>
                                        </div>
                                        <div class="small text-muted" style="font-size: 0.8rem;">
                                            Dikirim: <?= date('d M Y', strtotime($r['tgl_laporan'])); ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 mb-2 px-2 py-1">
                                            <i class="ti ti-category me-1"></i> <?= htmlspecialchars($r['ket_kategori']); ?>
                                        </span>
                                        <div class="text-dark mb-2 text-wrap" style="font-size: 0.9rem;">
                                            <strong>Keluhan:</strong> <?= htmlspecialchars($r['ket']); ?>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="ti ti-map-pin text-danger me-1"></i><?= htmlspecialchars($r['lokasi']); ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top">
                                        <div class="bg-light p-3 rounded-3 border-start border-4 border-success">
                                            <div class="small fw-bold text-success mb-1">
                                                <i class="ti ti-messages me-1"></i> Tanggapan Petugas:
                                            </div>
                                            <div class="text-muted small" style="white-space: pre-wrap;"><?= isset($r['feedback']) && $r['feedback'] != '' ? htmlspecialchars($r['feedback']) : 'Laporan telah diselesaikan dan ditutup.'; ?></div>
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
                                            <i class="ti ti-clipboard-x text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                            <span class="fw-bold text-muted fs-5">Belum ada riwayat laporan yang selesai.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white border-top py-3 text-muted small d-flex justify-content-between align-items-center">
                <span>Menampilkan semua riwayat laporan Anda.</span>
                <span class="badge bg-dark px-2 py-1"><?= isset($riwayat) ? mysqli_num_rows($riwayat) : 0 ?> Laporan</span>
            </div>
        </div>

    </div>
</div>