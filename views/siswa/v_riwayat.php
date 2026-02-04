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

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase">Info Laporan</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase">Lokasi & Kategori</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase">Penyelesaian</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-center">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($laporan_selesai) && mysqli_num_rows($laporan_selesai) > 0): ?>
                                <?php while($r = mysqli_fetch_assoc($laporan_selesai)): ?>
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark mb-1"><?= htmlspecialchars($r['ket']); ?></span>
                                            <span class="small text-muted">
                                                <i class="ti ti-calendar me-1"></i>Dibuat: <?= date('d M Y', strtotime($r['tgl_laporan'])); ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark border mb-1">
                                            <?= htmlspecialchars($r['ket_kategori']); ?>
                                        </span>
                                        <div class="small text-muted mt-1">
                                            <i class="ti ti-map-pin me-1"></i><?= htmlspecialchars($r['lokasi']); ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3" style="min-width: 250px;">
                                        <div class="alert alert-success border-0 py-2 px-3 mb-0 shadow-sm">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="ti ti-circle-check me-2 fs-5"></i>
                                                <span class="fw-bold small">Selesai: <?= date('d M Y', strtotime($r['tgl_selesai'])); ?></span>
                                            </div>
                                            <hr class="my-1 border-success opacity-25">
                                            <p class="mb-0 small fst-italic text-success-emphasis">
                                                "<?= htmlspecialchars($r['feedback']); ?>"
                                            </p>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" 
                                                data-bs-toggle="modal" data-bs-target="#modalFoto<?= $r['id_pelaporan']; ?>">
                                            <i class="ti ti-photo me-1"></i> Lihat
                                        </button>

                                        <div class="modal fade" id="modalFoto<?= $r['id_pelaporan']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h6 class="modal-title fw-bold">Bukti Laporan</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-3 text-center">
                                                        <img src="assets/img_laporan/<?= htmlspecialchars($r['foto']); ?>" 
                                                             class="img-fluid rounded shadow-sm" 
                                                             style="max-height: 400px; object-fit: contain;" 
                                                             alt="Bukti Laporan">
                                                        <div class="mt-2 text-muted small"><?= htmlspecialchars($r['ket']); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>

                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-50">
                                            <i class="ti ti-clipboard-x fs-1 mb-3 d-block text-muted"></i>
                                            <p class="text-muted mb-0">Belum ada riwayat laporan yang selesai.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>