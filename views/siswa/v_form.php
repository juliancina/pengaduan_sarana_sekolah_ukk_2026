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
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-primary"><i class="ti ti-pencil-plus me-2"></i>Buat Laporan Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?page=form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="kirim" value="1">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori Masalah <span class="text-danger">*</span></label>
                                <select name="id_kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php 
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

                            <div class="mb-3">
                                <label class="form-label fw-bold">Lokasi Kejadian <span class="text-danger">*</span></label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Cth: Lab Komputer" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="ket" class="form-control" rows="4" placeholder="Jelaskan detail..." required></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Foto Bukti</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">Kirim Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
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
                                        while($row = mysqli_fetch_assoc($riwayat)): 
                                            
                                            // Logic Status
                                            $st = isset($row['status_terkini']) ? $row['status_terkini'] : '0';
                                            
                                            if($st == '0' || $st == 'Menunggu') {
                                                $badge = '<span class="badge bg-warning text-dark">Menunggu</span>';
                                            } elseif($st == 'Proses') {
                                                $badge = '<span class="badge bg-info text-white">Diproses</span>';
                                            } elseif($st == 'Selesai') {
                                                $badge = '<span class="badge bg-success">Selesai</span>';
                                            } else {
                                                $badge = '<span class="badge bg-danger">'.$st.'</span>';
                                            }
                                    ?>
                                    <tr>
                                        <td class="ps-4 text-nowrap">
                                            <?= date('d/m/Y', strtotime($row['tgl_laporan'])); ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $row['ket_kategori']; ?></div>
                                            <small class="text-muted"><?= $row['lokasi']; ?></small>
                                        </td>
                                        <td><?= $badge; ?></td>
                                        
                                        <td class="text-center">
                                            <?php if($st == '0' || $st == 'Menunggu'): ?>
                                                <div class="btn-group">
                                                    <a href="index.php?page=edit&id=<?= $row['id_pelaporan']; ?>" class="btn btn-sm btn-light text-warning" title="Edit">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                    <a href="index.php?page=hapus&id=<?= $row['id_pelaporan']; ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border"><i class="ti ti-lock"></i> Locked</span>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                    <?php 
                                        endwhile; 
                                    else: 
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <p class="text-muted mb-0">Belum ada riwayat laporan.</p>
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