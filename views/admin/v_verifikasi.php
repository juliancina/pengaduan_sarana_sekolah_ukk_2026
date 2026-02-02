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
                            <input type="text" name="nama" class="form-control form-control-sm" placeholder="Cari nama..." 
                                   value="<?= isset($_GET['nama']) ? $_GET['nama'] : '' ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select form-select-sm">
                                <option value="">-- Semua Kategori --</option>
                                <?php 
                                // Reset pointer data kategori karena mungkin sudah dipakai
                                if(isset($data_kategori)) { mysqli_data_seek($data_kategori, 0); }
                                
                                if(isset($data_kategori) && mysqli_num_rows($data_kategori) > 0): 
                                    while($k = mysqli_fetch_assoc($data_kategori)): 
                                        $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $k['id_kategori']; ?>" <?= $selected; ?>>
                                        <?= $k['ket_kategori']; ?>
                                    </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">-- Semua --</option>
                                <option value="0" <?= (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : '' ?>>Belum Ditanggapi</option>
                                <option value="Menunggu" <?= (isset($_GET['status']) && $_GET['status'] == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                <option value="Proses" <?= (isset($_GET['status']) && $_GET['status'] == 'Proses') ? 'selected' : '' ?>>Proses</option>
                                <option value="Ditolak" <?= (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <a href="index.php?page=verifikasi" class="btn btn-sm btn-secondary me-1"><i class="ti ti-refresh"></i> Reset</a>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"></i> Terapkan Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="ti ti-gavel me-2"></i>Daftar Laporan Aktif</h5>
                <span class="badge bg-primary">
                    <?= (isset($data_laporan)) ? mysqli_num_rows($data_laporan) : 0; ?> Data
                </span>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Pelapor</th>
                            <th>Masalah & Kategori</th>
                            <th>Bukti</th> 
                            <th>Status Saat Ini</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($data_laporan) && mysqli_num_rows($data_laporan) > 0): 
                            while($r = mysqli_fetch_assoc($data_laporan)): 
                                // Logic Warna Badge Status
                                $status = $r['status'];
                                if($status == 'Proses') $cls = 'bg-info text-white';
                                elseif($status == 'Ditolak') $cls = 'bg-danger text-white';
                                elseif($status == 'Menunggu') $cls = 'bg-warning text-dark';
                                else $cls = 'bg-secondary text-white'; // Untuk status 0
                                
                                // Text Status
                                $txt_status = ($status == '0') ? 'Belum Ditanggapi' : $status;
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-light-primary text-primary rounded-circle me-3">
                                            <i class="ti ti-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark"><?= $r['nama']; ?></h6>
                                            <small class="text-muted">Kelas: <?= $r['kelas']; ?></small><br>
                                            <small class="text-muted" style="font-size:11px">
                                                <i class="ti ti-calendar me-1"></i><?= $r['tgl_laporan']; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                
                                <td style="max-width: 250px;">
                                    <span class="badge bg-light text-dark border mb-1"><?= $r['ket_kategori']; ?></span>
                                    <p class="text-muted small mb-0 text-truncate">
                                        <?= substr($r['ket'], 0, 80) . '...'; ?>
                                    </p>
                                    <small class="text-primary"><i class="ti ti-map-pin"></i> <?= $r['lokasi']; ?></small>
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalFoto"
                                            data-foto="assets/img_laporan/<?= $r['foto']; ?>"
                                            data-judul="Bukti Laporan - <?= $r['nama']; ?>">
                                        <i class="ti ti-photo"></i> Lihat
                                    </button>
                                </td>

                                <td>
                                    <span class="badge <?= $cls; ?> rounded-pill px-3">
                                        <?= $txt_status; ?>
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalAct"
                                            data-id="<?= $r['id_pelaporan']; ?>"
                                            data-nama="<?= $r['nama']; ?>"
                                            data-ket="<?= htmlspecialchars($r['ket']); ?>"
                                            data-status="<?= $r['status']; ?>"
                                            data-lokasi="<?= $r['lokasi']; ?>">
                                        <i class="ti ti-edit"></i> Tanggapi
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="ti ti-filter-off fs-1 mb-3 d-block opacity-25"></i>
                                    <span class="fw-bold">Tidak ada laporan yang sesuai filter.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modalAct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tanggapi Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="index.php?page=proses_tanggapan" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pelaporan" id="id_pelaporan">
                    
                    <div class="alert alert-light border mb-3">
                        <small class="fw-bold d-block text-muted">Pelapor:</small>
                        <span id="label_nama" class="text-dark fw-bold">-</span>
                        <hr class="my-1">
                        <small class="fw-bold d-block text-muted">Masalah:</small>
                        <span id="label_ket" class="text-dark fst-italic">-</span>
                        <br>
                        <small class="text-primary"><i class="ti ti-map-pin"></i> <span id="label_lokasi"></span></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Tindakan</label>
                        <select name="status" id="select_status" class="form-select" required>
                            <option value="Menunggu">Menunggu (Pending)</option>
                            <option value="Proses">Sedang Diproses (On Progress)</option>
                            <option value="Selesai">Selesai (Done)</option>
                            <option value="Ditolak">Tolak Laporan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Feedback / Tanggapan</label>
                        <textarea name="feedback" class="form-control" rows="3" placeholder="Tulis tanggapan untuk siswa..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Tanggapan</button>
                </div>
            </form>
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
                <img src="" id="tampilFoto" class="img-fluid rounded shadow-sm" alt="Bukti Laporan">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Script Modal Tanggapan
    var modalAct = document.getElementById('modalAct');
    modalAct.addEventListener('show.bs.modal', function (event) {
        var btn = event.relatedTarget;
        document.getElementById('id_pelaporan').value = btn.getAttribute('data-id');
        document.getElementById('label_nama').innerText = btn.getAttribute('data-nama');
        document.getElementById('label_ket').innerText = btn.getAttribute('data-ket');
        document.getElementById('label_lokasi').innerText = btn.getAttribute('data-lokasi');

        var currentStatus = btn.getAttribute('data-status');
        var select = document.getElementById('select_status');
        if(currentStatus != '0') {
            select.value = currentStatus;
        } else {
            select.value = 'Menunggu'; 
        }
    });

    // 2. Script Modal Foto
    var modalFoto = document.getElementById('modalFoto');
    modalFoto.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var fotoFile = button.getAttribute('data-foto');
        var judul = button.getAttribute('data-judul');
        
        modalFoto.querySelector('#judulFoto').textContent = judul;
        modalFoto.querySelector('#tampilFoto').src = fotoFile;
    });
});
</script>