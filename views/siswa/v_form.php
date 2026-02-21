<div class="pc-container">
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Form Pengaduan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                            <li class="breadcrumb-item">Buat Laporan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="ti ti-pencil-plus me-2"></i>Buat Laporan Baru</h5>
                    </div>
                    <div class="card-body p-4">

                        <div class="alert alert-primary border-0 bg-primary bg-opacity-10 d-flex align-items-start p-3 mb-4 rounded-3">
                            <i class="ti ti-bulb fs-3 me-3 text-primary mt-1"></i>
                            <div>
                                <span class="fw-bold d-block text-primary mb-1">Panduan Pelaporan</span>
                                <small class="text-dark">Sampaikan detail kejadian dengan jelas, spesifik, dan menggunakan bahasa yang sopan. Identitas Anda aman bersama kami.</small>
                            </div>
                        </div>

                        <form action="index.php?page=form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="kirim" value="1">

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark"><i class="ti ti-category text-muted me-1"></i> Kategori Masalah <span class="text-danger">*</span></label>
                                <select name="id_kategori" class="form-select shadow-sm" required>
                                    <option value="">-- Pilih Kategori yang Sesuai --</option>
                                    <?php
                                    if (isset($kategori) && mysqli_num_rows($kategori) > 0) {
                                        foreach ($kategori as $k):
                                    ?>
                                            <option value="<?= $k['id_kategori']; ?>"><?= $k['ket_kategori']; ?></option>
                                    <?php
                                        endforeach;
                                    }
                                    ?>
                                </select>
                                <div class="form-text small mt-1">Pilih departemen/jenis masalah agar laporan tepat sasaran.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark"><i class="ti ti-map-pin text-muted me-1"></i> Lokasi Kejadian <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control shadow-sm" placeholder="Cth: Lab Komputer 2, Gedung B Lantai 3" required>
                                <div class="form-text small mt-1">Tuliskan nama ruangan atau patokan tempat dengan spesifik.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark"><i class="ti ti-file-description text-muted me-1"></i> Detail Laporan <span class="text-danger">*</span></label>
                                <textarea name="ket" class="form-control shadow-sm" rows="4" placeholder="Jelaskan secara rinci kronologi kejadian atau kondisi kerusakan yang Anda temui..." required></textarea>
                                <div class="form-text small mt-1">Ceritakan apa yang terjadi, kapan, dan kondisinya saat ini.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark"><i class="ti ti-camera text-muted me-1"></i> Foto Bukti <span class="text-muted fw-normal fst-italic">(Opsional)</span></label>
                                <input type="file" name="foto" class="form-control shadow-sm" accept="image/*">
                                <div class="form-text small mt-1 text-success"><i class="ti ti-check me-1"></i>Melampirkan foto sangat disarankan untuk mempercepat petugas memverifikasi masalah Anda.</div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary fw-bold py-2 rounded-3 shadow-sm" style="letter-spacing: 0.5px;">
                                    <i class="ti ti-send me-2"></i> Kirim Laporan Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list-details me-2"></i>Status Laporan Saya</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Tanggal</th>
                                        <th>Laporan</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($riwayat) && mysqli_num_rows($riwayat) > 0):
                                        while ($row = mysqli_fetch_assoc($riwayat)):

                                            // Logic Status
                                            $st = isset($row['status_terkini']) ? $row['status_terkini'] : '0';

                                            if ($st == '0' || $st == 'Menunggu') {
                                                $badge = '<span class="badge bg-warning text-dark px-2 py-1 rounded-pill"><i class="ti ti-clock me-1"></i>Menunggu</span>';
                                            } elseif ($st == 'Proses') {
                                                $badge = '<span class="badge bg-info text-white px-2 py-1 rounded-pill"><i class="ti ti-loader me-1"></i>Diproses</span>';
                                            } elseif ($st == 'Selesai') {
                                                $badge = '<span class="badge bg-success px-2 py-1 rounded-pill"><i class="ti ti-check me-1"></i>Selesai</span>';
                                            } else {
                                                $badge = '<span class="badge bg-danger">' . $st . '</span>';
                                            }
                                    ?>
                                            <tr>
                                                <td class="ps-4 text-nowrap align-top pt-3">
                                                    <?= date('d M Y', strtotime($row['tgl_laporan'])); ?>
                                                </td>
                                                <td class="align-top pt-3">
                                                    <div class="fw-bold text-dark mb-1"><?= $row['ket_kategori']; ?></div>
                                                    <small class="text-muted d-block mb-1"><i class="ti ti-map-pin text-danger me-1"></i><?= $row['lokasi']; ?></small>
                                                </td>
                                                <td class="align-top pt-3"><?= $badge; ?></td>

                                                <td class="text-center align-top pt-3">
                                                    <?php if ($st == '0' || $st == 'Menunggu'): ?>
                                                        <div class="btn-group shadow-sm rounded-2">
                                                            <button type="button" class="btn btn-sm btn-light text-warning border"
                                                                data-bs-toggle="modal" data-bs-target="#modalEdit"
                                                                data-id="<?= $row['id_pelaporan']; ?>"
                                                                data-lokasi="<?= htmlspecialchars($row['lokasi']); ?>"
                                                                data-ket="<?= htmlspecialchars($row['ket']); ?>"
                                                                title="Edit Laporan">
                                                                <i class="ti ti-pencil"></i>
                                                            </button>

                                                            <a href="index.php?page=hapus&id=<?= $row['id_pelaporan']; ?>" class="btn btn-sm btn-light text-danger border-start-0 border" onclick="return confirm('Yakin ingin menghapus laporan ini?')" title="Hapus">
                                                                <i class="ti ti-trash"></i>
                                                            </a>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="badge bg-light text-muted border px-2 py-1"><i class="ti ti-lock me-1"></i> Terkunci</span>
                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                        <?php
                                        endwhile;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="opacity-50 my-4">
                                                    <i class=\"ti ti-clipboard-text fs-1 mb-3 d-block text-muted\" style=\"font-size: 3rem;\"></i>
                                                    <p class=\"text-muted mb-0 fw-bold fs-6\">Belum ada laporan aktif.</p>
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
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom-0 pb-3 rounded-top-4">
                <h5 class="modal-title fw-bold text-dark"><i class="ti ti-pencil me-2 text-warning"></i>Edit Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="index.php?page=edit" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4 pt-2">
                    <input type="hidden" name="id_pelaporan" id="edit_id_pelaporan">

                    <div class="alert alert-warning border-0 py-2 px-3 small mb-4 rounded-3 d-flex align-items-center">
                        <i class="ti ti-info-circle fs-5 me-2"></i> Kategori masalah sudah ditetapkan dan tidak dapat diubah.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark"><i class="ti ti-map-pin text-muted me-1"></i> Lokasi Kejadian <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi" id="edit_lokasi" class="form-control shadow-sm" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark"><i class="ti ti-file-description text-muted me-1"></i> Detail Laporan <span class="text-danger">*</span></label>
                        <textarea name="ket" id="edit_ket" class="form-control shadow-sm" rows="4" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold text-dark"><i class="ti ti-camera text-muted me-1"></i> Perbarui Foto <span class="fw-normal fst-italic text-muted">(Opsional)</span></label>
                        <input type="file" name="foto" class="form-control shadow-sm" accept="image/*">
                        <div class="form-text small">Biarkan kosong jika Anda tidak ingin mengubah foto bukti sebelumnya.</div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_laporan" class="btn btn-warning text-dark fw-bold"><i class="ti ti-device-floppy me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEdit = document.getElementById('modalEdit');
        modalEdit.addEventListener('show.bs.modal', function(event) {
            var btn = event.relatedTarget;

            // Ambil data dari atribut tombol
            var id = btn.getAttribute('data-id');
            var lokasi = btn.getAttribute('data-lokasi');
            var ket = btn.getAttribute('data-ket');

            // Masukkan data ke dalam form modal
            modalEdit.querySelector('#edit_id_pelaporan').value = id;
            modalEdit.querySelector('#edit_lokasi').value = lokasi;
            modalEdit.querySelector('#edit_ket').value = ket;
        });
    });
</script>