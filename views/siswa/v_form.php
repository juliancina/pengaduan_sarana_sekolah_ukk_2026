<div class="pc-container">
    <div class="pc-content">
        
        <div class="row">
            
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="ti ti-pencil-plus me-2"></i>Buat Laporan Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?page=simpan" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">KATEGORI MASALAH <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ti ti-category"></i></span>
                                    <select name="id_kategori" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <?php 
                                        // Loop data kategori dari database
                                        if(isset($kategori) && mysqli_num_rows($kategori) > 0) {
                                            foreach($kategori as $k): 
                                        ?>
                                            <option value="<?= $k['id_kategori']; ?>"><?= $k['ket_kategori']; ?></option>
                                        <?php 
                                            endforeach; 
                                        } 
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">LOKASI KEJADIAN <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ti ti-map-pin"></i></span>
                                    <input type="text" name="lokasi" class="form-control" placeholder="Cth: Lab Komputer 1, WC Siswa Lt.2" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">DESKRIPSI KERUSAKAN <span class="text-danger">*</span></label>
                                <textarea name="ket" class="form-control" rows="4" placeholder="Jelaskan kerusakan secara detail..." required></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">FOTO BUKTI (OPSIONAL)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-1"><i class="ti ti-info-circle me-1"></i>Format: JPG, PNG, JPEG</small>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold">
                                    <i class="ti ti-send me-2"></i> Kirim Laporan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-list-details me-2"></i>Status Laporan Saya</h5>
                        <span class="badge bg-light-warning text-warning border border-warning">Sedang Berjalan</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Tanggal</th>
                                        <th>Kategori & Lokasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Cek apakah ada data laporan aktif
                                    if (isset($laporan_aktif) && mysqli_num_rows($laporan_aktif) > 0): 
                                        while($row = mysqli_fetch_assoc($laporan_aktif)): 
                                            
                                            // Logika Warna Badge Status
                                            $st = $row['status'];
                                            if($st == '0' || $st == 'Menunggu') {
                                                $badge = '<span class="badge bg-warning text-dark px-3 py-2"><i class="ti ti-clock me-1"></i>Menunggu</span>';
                                                $bg_row = "";
                                            } elseif($st == 'Proses') {
                                                $badge = '<span class="badge bg-info text-white px-3 py-2"><i class="ti ti-settings me-1"></i>Diproses</span>';
                                                $bg_row = "table-info"; // Highlight baris yang sedang diproses
                                            } else {
                                                $badge = '<span class="badge bg-secondary">'.$st.'</span>';
                                                $bg_row = "";
                                            }
                                    ?>
                                    <tr class="<?= $bg_row; ?>">
                                        <td class="ps-4 text-nowrap">
                                            <i class="ti ti-calendar me-1 text-muted"></i>
                                            <?= date('d/m/Y', strtotime($row['tgl_laporan'])); ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $row['ket_kategori']; ?></div>
                                            <small class="text-muted"><i class="ti ti-map-pin me-1"></i><?= $row['lokasi']; ?></small>
                                        </td>
                                        <td><?= $badge; ?></td>
                                    </tr>
                                    <?php 
                                        endwhile; 
                                    else: 
                                    ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="ti ti-folder-off fs-1 d-block mb-3 opacity-50"></i>
                                                <p class="mb-0">Belum ada laporan yang sedang diproses.</p>
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