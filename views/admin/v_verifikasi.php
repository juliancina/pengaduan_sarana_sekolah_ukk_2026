<div class="pc-container">
    <div class="pc-content">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-bold text-dark"><i class="ti ti-filter me-2"></i>Filter Laporan Masuk</h6>
            </div>
            <div class="card-body">
                <form action="index.php" method="GET">
                    <input type="hidden" name="page" value="verifikasi">

                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Dari Tanggal</label>
                            <input type="date" name="tgl_awal" class="form-control form-control-sm"
                                value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '' ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="tgl_akhir" class="form-control form-control-sm"
                                value="<?= isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control form-control-sm"
                                placeholder="Cari nama siswa..."
                                value="<?= isset($_GET['nama']) ? $_GET['nama'] : '' ?>">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="0" <?= (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : '' ?>>Baru</option>
                                <option value="Menunggu" <?= (isset($_GET['status']) && $_GET['status'] == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Proses" <?= (isset($_GET['status']) && $_GET['status'] == 'Proses') ? 'selected' : '' ?>>Sedang Proses</option>
                                <option value="Ditolak" <?= (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100"><i class="ti ti-search me-1"></i> Filter</button>
                            <a href="index.php?page=verifikasi" class="btn btn-light btn-sm w-50"><i class="ti ti-refresh"></i> Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary"><i class="ti ti-list-details me-2"></i>Daftar Laporan Masuk</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 small text-uppercase text-secondary fw-bold">Info Laporan</th>
                                <th class="px-4 py-3 small text-uppercase text-secondary fw-bold">Pelapor</th>
                                <th class="px-4 py-3 small text-uppercase text-secondary fw-bold">Bukti & Status</th>
                                <th class="px-4 py-3 small text-uppercase text-secondary fw-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data_laporan) && mysqli_num_rows($data_laporan) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($data_laporan)): ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark mb-1 text-break" style="max-width: 300px;">
                                                <?= htmlspecialchars($row['ket']); ?>
                                            </div>
                                            <div class="small text-muted mb-1">
                                                <i class="ti ti-map-pin me-1"></i><?= htmlspecialchars($row['lokasi']); ?>
                                            </div>
                                            <span class="badge bg-light text-dark border">
                                                <?= htmlspecialchars($row['ket_kategori']); ?>
                                            </span>
                                            <div class="mt-2 small text-muted">
                                                <i class="ti ti-calendar me-1"></i><?= date('d M Y H:i', strtotime($row['tgl_laporan'])); ?>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3">
                                            <div class="fw-bold"><?= htmlspecialchars($row['nama']); ?></div>
                                            <div class="small text-muted">NIS: <?= htmlspecialchars($row['nis']); ?></div>
                                            <div class="badge bg-light-primary text-primary rounded-pill mt-1">
                                                <?= htmlspecialchars($row['kelas']); ?>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3">
                                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill mb-2 w-100"
                                                data-bs-toggle="modal" data-bs-target="#modalFoto"
                                                data-foto="assets/img_laporan/<?= $row['foto']; ?>"
                                                data-judul="<?= htmlspecialchars($row['ket']); ?>">
                                                <i class="ti ti-photo me-1"></i> Lihat Foto
                                            </button>

                                            <?php
                                            $st = $row['status'];
                                            if ($st == '0' || $st == '' || $st == NULL) {
                                                echo '<span class="badge bg-danger w-100 py-2"><i class="ti ti-bell-ringing me-1"></i>Baru</span>';
                                            } elseif ($st == 'Menunggu') {
                                                echo '<span class="badge bg-warning w-100 py-2"><i class="ti ti-clock me-1"></i>Menunggu</span>';
                                            } elseif ($st == 'Proses') {
                                                echo '<span class="badge bg-info w-100 py-2"><i class="ti ti-loader me-1"></i>Di Proses</span>';
                                            } elseif ($st == 'Ditolak') {
                                                echo '<span class="badge bg-secondary w-100 py-2"><i class="ti ti-x me-1"></i>Ditolak</span>';
                                            } else {
                                                echo '<span class="badge bg-light text-dark border w-100 py-2">' . $st . '</span>';
                                            }
                                            ?>
                                            
                                            <?php if($row['feedback'] != '-' && $row['feedback'] != 'Belum ada tanggapan'): ?>
                                                <div class="mt-2 p-2 bg-light rounded border border-warning small fst-italic text-muted">
                                                    "<?= htmlspecialchars($row['feedback']); ?>"
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                
                                                <button type="button" class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm"
                                                    data-bs-toggle="modal" data-bs-target="#modalAct"
                                                    data-id="<?= $row['id_pelaporan']; ?>"
                                                    data-nama="<?= $row['nama']; ?>"
                                                    data-ket="<?= $row['ket']; ?>"
                                                    data-lokasi="<?= $row['lokasi']; ?>"
                                                    data-status="<?= $row['status']; ?>">
                                                    <i class="ti ti-edit me-1"></i> Verifikasi
                                                </button>

                                                <a href="index.php?page=delete_laporan&id=<?= $row['id_pelaporan']; ?>" 
                                                   class="btn btn-danger btn-sm rounded-circle shadow-sm"
                                                   onclick="return confirm('PERINGATAN!\n\nApakah Anda yakin ingin MENGHAPUS PERMANEN laporan ini?\nData yang dihapus tidak bisa dikembalikan.\n\n(Jika hanya ingin menolak, gunakan tombol Verifikasi > Pilih Status Ditolak)');"
                                                   title="Hapus Laporan Permanen">
                                                   <i class="ti ti-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-50">
                                            <i class="ti ti-folder-off fs-1 d-block mb-3 text-muted"></i>
                                            <p class="text-muted mb-0">Belum ada laporan masuk yang sesuai filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light py-3">
                <small class="text-muted">Total Laporan: <b><?= isset($data_laporan) ? mysqli_num_rows($data_laporan) : 0; ?></b></small>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalAct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Verifikasi & Tanggapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?page=proses_tanggapan" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pelaporan" id="id_pelaporan">
                    
                    <div class="alert alert-light border mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted fw-bold">Pelapor:</small>
                            <small class="text-dark fw-bold" id="label_nama">-</small>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted fw-bold">Lokasi:</small>
                            <small class="text-dark fw-bold" id="label_lokasi">-</small>
                        </div>
                        <hr class="my-1">
                        <small class="d-block text-muted fst-italic" id="label_ket">-</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Update Status</label>
                        <select name="status" id="select_status" class="form-select" required>
                            <option value="Menunggu">Menunggu (Terima Laporan)</option>
                            <option value="Proses">Proses (Sedang Dikerjakan)</option>
                            <option value="Selesai">Selesai (Masalah Teratasi)</option>
                            <option value="Ditolak" class="fw-bold text-danger">Tolak Laporan (Tidak Valid/Spam)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Isi Tanggapan / Alasan</label>
                        <textarea name="feedback" class="form-control" rows="3" placeholder="Tulis tanggapan atau alasan penolakan di sini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-send me-1"></i> Simpan & Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="judulFoto">Bukti Laporan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <img src="" id="tampilFoto" class="img-fluid rounded shadow-sm" style="max-height: 500px;" alt="Bukti">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // A. Script Modal Tanggapan
        var modalAct = document.getElementById('modalAct');
        modalAct.addEventListener('show.bs.modal', function(event) {
            var btn = event.relatedTarget;
            
            // Isi data ke dalam modal dari tombol
            document.getElementById('id_pelaporan').value = btn.getAttribute('data-id');
            document.getElementById('label_nama').innerText = btn.getAttribute('data-nama');
            document.getElementById('label_ket').innerText = btn.getAttribute('data-ket');
            document.getElementById('label_lokasi').innerText = btn.getAttribute('data-lokasi');

            // Logika Status: Jika 0 atau kosong, set default 'Menunggu'
            var currentStatus = btn.getAttribute('data-status');
            var select = document.getElementById('select_status');
            
            if (currentStatus && currentStatus != '0' && currentStatus != '') {
                select.value = currentStatus;
            } else {
                select.value = 'Menunggu';
            }
        });

        // B. Script Modal Foto
        var modalFoto = document.getElementById('modalFoto');
        modalFoto.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fotoFile = button.getAttribute('data-foto');
            var judul = button.getAttribute('data-judul');

            modalFoto.querySelector('#judulFoto').textContent = judul;
            modalFoto.querySelector('#tampilFoto').src = fotoFile;
        });
    });
</script>