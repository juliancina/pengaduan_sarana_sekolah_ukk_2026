<div class="pc-container">
    <div class="pc-content">
        
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="index.php?page=form">Form</a></li>
                            <li class="breadcrumb-item">Edit Laporan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0 text-white"><i class="ti ti-edit me-2"></i>Edit Laporan Pengaduan</h5>
                    </div>
                    <div class="card-body">
                        
                        <form action="index.php?page=edit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_pelaporan" value="<?= $edit->id_pelaporan ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Lokasi Kejadian</label>
                                <input type="text" name="lokasi" class="form-control" value="<?= $edit->lokasi ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi Laporan</label>
                                <textarea name="ket" class="form-control" rows="5" required><?= $edit->ket ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Bukti Foto</label><br>
                                <?php if(!empty($edit->foto) && $edit->foto != 'default.png'): ?>
                                    <img src="assets/img_laporan/<?= $edit->foto ?>" width="120" class="img-thumbnail mb-2 d-block">
                                <?php endif; ?>
                                <input type="file" name="foto" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php?page=form" class="btn btn-secondary">Batal</a>
                                <button type="submit" name="update_laporan" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>