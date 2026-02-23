<div class="pc-container">
    <div class="pc-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Verifikasi & Validasi Laporan</h4>
                <p class="text-muted small mb-0">Kelola laporan masuk, berikan tanggapan, dan perbarui status.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4 rounded-4">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="ti ti-filter me-2 text-primary"></i>Filter Laporan Masuk</h6>
            </div>
            <div class="card-body p-4">
                <form action="index.php" method="GET">
                    <input type="hidden" name="page" value="verifikasi">

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Dari Tanggal</label>
                            <input type="date" name="tgl_awal" class="form-control"
                                value="<?= isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '' ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
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
                        <a href="index.php?page=verifikasi" class="btn btn-light border shadow-sm px-3" title="Bersihkan Filter">
                            <i class="ti ti-refresh text-secondary me-1"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-primary shadow-sm px-4" title="Terapkan Filter">
                            <i class="ti ti-search me-1"></i> Cari Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="20%">Tgl & Pelapor</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="20%">Kategori & Status</th>
                                <th class="px-4 py-3 text-secondary small fw-bold text-uppercase" width="35%">Detail Laporan</th>
                                <th class="px-4 py-3 text-center text-secondary small fw-bold text-uppercase" width="25%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data_laporan && mysqli_num_rows($data_laporan) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($data_laporan)): ?>
                                    <tr>
                                        <td class="px-4 py-3 align-top">
                                            <div class="fw-bold text-dark mb-2">
                                                <i class="ti ti-calendar me-1 text-primary"></i> <?= date('d M Y', strtotime($row['tgl_laporan'])) ?>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2 mt-1" style="width: 32px; height: 32px; flex-shrink: 0;">
                                                    <i class="ti ti-user fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="small fw-bold text-dark"><?= htmlspecialchars($row['nama']) ?></div>
                                                    <div class="small text-muted mb-0">NIS: <?= htmlspecialchars($row['nis']) ?></div>
                                                    <div class="small text-muted">Kelas: <?= htmlspecialchars($row['kelas'] ?? '-') ?></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 align-top">
                                            <span class="badge bg-light text-dark border mb-2 px-2 py-1">
                                                <i class="ti ti-category me-1 text-primary"></i> 
                                                <?= htmlspecialchars($row['ket_kategori']) ?>
                                            </span>
                                            <br>
                                            <?php 
                                                $st_color = 'secondary';
                                                $st_text = $row['status'] ? htmlspecialchars($row['status']) : 'Menunggu';
                                                if ($st_text == 'Proses') $st_color = 'warning text-dark';
                                                if ($st_text == 'Selesai') $st_color = 'success';
                                                if ($st_text == 'Menunggu') $st_color = 'danger bg-opacity-10 text-danger border border-danger border-opacity-25';
                                            ?>
                                            <span class="badge bg-<?= $st_color ?> px-2 py-1">
                                                <i class="ti ti-loader me-1"></i> <?= $st_text ?>
                                            </span>
                                        </td>

                                        <td class="px-4 py-3 align-top">
                                            <div class="text-dark mb-2 text-wrap" style="font-size: 0.9rem;">
                                                <strong>Keluhan:</strong> <?= htmlspecialchars($row['ket']) ?>
                                            </div>
                                            <div class="small text-muted mb-2">
                                                <i class="ti ti-map-pin text-danger"></i> Lokasi: <?= htmlspecialchars($row['lokasi']) ?>
                                            </div>
                                            
                                            <?php if(isset($row['feedback']) && $row['feedback'] != '' && $row['feedback'] != '-'): ?>
                                            <div class="mt-2 p-2 bg-light border-start border-3 border-primary rounded-end small">
                                                <span class="fw-bold text-primary">Tanggapan saat ini:</span><br>
                                                <span class="text-muted"><?= htmlspecialchars($row['feedback']) ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="px-4 py-3 text-center align-top">
                                            <div class="d-flex justify-content-center gap-1">
                                                
                                                <button type="button" class="btn btn-sm btn-light border shadow-sm px-2" 
                                                        data-bs-toggle="modal" data-bs-target="#modalFoto"
                                                        data-foto="assets/img_laporan/<?= htmlspecialchars($row['foto']) ?>"
                                                        data-judul="Foto Laporan - <?= htmlspecialchars($row['nama']) ?>"
                                                        title="Lihat Bukti Foto">
                                                    <i class="ti ti-photo text-secondary fs-6"></i>
                                                </button>

                                                <button type="button" class="btn btn-sm btn-primary shadow-sm px-3" 
                                                        data-bs-toggle="modal" data-bs-target="#modalAct"
                                                        data-id="<?= $row['id_pelaporan'] ?>"
                                                        data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                                        data-ket="<?= htmlspecialchars($row['ket']) ?>"
                                                        data-lokasi="<?= htmlspecialchars($row['lokasi']) ?>"
                                                        data-status="<?= $row['status'] ?>"
                                                        data-feedback="<?= htmlspecialchars($row['feedback'] ?? '') ?>"
                                                        title="Beri Tanggapan & Ubah Status">
                                                    <i class="ti ti-edit me-1"></i> Proses
                                                </button>

                                                <a href="index.php?page=hapus_laporan&id=<?= $row['id_pelaporan'] ?>" 
                                                   class="btn btn-sm btn-danger shadow-sm px-3" 
                                                   onclick="return confirm('Yakin ingin menghapus laporan ini? Data dan foto akan terhapus permanen!');"
                                                   title="Hapus Laporan Permanen">
                                                    <i class="ti ti-trash me-1"></i> Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-4 opacity-50">
                                            <i class="ti ti-inbox text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                            <span class="fw-bold text-muted fs-5">Belum ada laporan masuk yang perlu diverifikasi.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-3 text-muted small d-flex justify-content-between align-items-center">
                <span>Menampilkan laporan berstatus Baru, Menunggu, atau Proses.</span>
                <span class="badge bg-dark px-2 py-1"><?= isset($data_laporan) ? mysqli_num_rows($data_laporan) : 0 ?> Laporan</span>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalFoto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-0">
                <h5 class="modal-title fw-bold text-dark" id="judulFoto"><i class="ti ti-photo me-2 text-primary"></i>Foto Bukti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-white">
                <img src="" id="tampilFoto" class="img-fluid rounded shadow-sm border" style="max-height: 70vh; object-fit: contain;" alt="Bukti Foto">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white border-bottom-0">
                <h5 class="modal-title fw-bold"><i class="ti ti-edit me-2"></i>Tanggapi Laporan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="index.php?page=proses_tanggapan" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="id_pelaporan" id="id_pelaporan">

                    <div class="bg-light p-3 rounded mb-4 border border-primary border-opacity-25">
                        <div class="row mb-2">
                            <div class="col-4 small text-muted">Pelapor</div>
                            <div class="col-8 fw-bold text-dark" id="label_nama">-</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4 small text-muted">Lokasi</div>
                            <div class="col-8 text-dark small" id="label_lokasi">-</div>
                        </div>
                        <div class="row">
                            <div class="col-4 small text-muted">Keluhan</div>
                            <div class="col-8 text-dark small fst-italic" id="label_ket">-</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Perbarui Status</label>
                        <select name="status" id="select_status" class="form-select shadow-sm" required>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Proses">Diproses</option>
                            <option value="Selesai">Selesai (Pindah ke Riwayat)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-end mb-2">
                            <label class="form-label fw-bold text-dark small mb-0">Tanggapan Petugas</label>
                            <div class="d-flex gap-1">
                                <span class="badge bg-warning text-dark border shadow-sm" style="cursor: pointer;" onclick="document.getElementById('textarea_tanggapan').value='Laporan sedang kami tindak lanjuti dan dalam tahap proses penyelesaian.'">Kata Proses</span>
                                <span class="badge bg-success border shadow-sm" style="cursor: pointer;" onclick="document.getElementById('textarea_tanggapan').value='Terimakasih sudah melapor. Laporan telah diselesaikan dan ditutup.'">Kata Selesai</span>
                            </div>
                        </div>
                        <textarea name="tanggapan" id="textarea_tanggapan" class="form-control shadow-sm" rows="4" placeholder="Tuliskan progres perbaikan atau keterangan untuk dibaca oleh siswa..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        var selectStatus = document.getElementById('select_status');
        var textareaTanggapan = document.getElementById('textarea_tanggapan');

        // Fungsi Auto-fill Berdasarkan Status Dropdown
        selectStatus.addEventListener('change', function() {
            var val = this.value;
            if (val === 'Proses') {
                textareaTanggapan.value = 'Laporan sedang kami tindak lanjuti dan dalam tahap proses penyelesaian.';
            } else if (val === 'Selesai') {
                textareaTanggapan.value = 'Terimakasih sudah melapor. Laporan telah diselesaikan dan ditutup.';
            } else if (val === 'Menunggu') {
                textareaTanggapan.value = 'Laporan Anda telah kami terima dan sedang menunggu antrean untuk diproses.';
            }
        });

        // Script Modal Proses/Tanggapi
        var modalAct = document.getElementById('modalAct');
        modalAct.addEventListener('show.bs.modal', function(event) {
            var btn = event.relatedTarget;
            
            // Isi data
            document.getElementById('id_pelaporan').value = btn.getAttribute('data-id');
            document.getElementById('label_nama').innerText = btn.getAttribute('data-nama');
            document.getElementById('label_ket').innerText = '"' + btn.getAttribute('data-ket') + '"';
            document.getElementById('label_lokasi').innerText = btn.getAttribute('data-lokasi');

            // Set Status
            var currentStatus = btn.getAttribute('data-status');
            if (currentStatus && currentStatus != '0' && currentStatus != '') {
                selectStatus.value = currentStatus;
            } else {
                selectStatus.value = 'Menunggu';
            }

            // Set Feedback
            var currentFeedback = btn.getAttribute('data-feedback');
            if (currentFeedback && currentFeedback !== '-' && currentFeedback !== '') {
                textareaTanggapan.value = currentFeedback;
            } else {
                // Jika belum ada tanggapan sama sekali, jalankan auto-fill sesuai status
                selectStatus.dispatchEvent(new Event('change'));
            }
        });

        // PERBAIKAN: Script Modal Foto
        var modalFoto = document.getElementById('modalFoto');
        modalFoto.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var fotoFile = button.getAttribute('data-foto');
            var judul = button.getAttribute('data-judul');

            modalFoto.querySelector('#judulFoto').innerHTML = '<i class="ti ti-photo me-2 text-primary"></i>' + judul;
            modalFoto.querySelector('#tampilFoto').src = fotoFile;
        });
    });
</script>