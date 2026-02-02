<div class="pc-container">
    <div class="pc-content">
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        
                        <div class="mb-4">
                            <div class="d-inline-block p-3 rounded-circle bg-light-primary text-primary">
                                <i class="ti ti-user fs-1"></i>
                            </div>
                        </div>

                        <h3 class="fw-bold mb-1"><?= $data['nama']; ?></h3>
                        <p class="text-muted mb-4">Siswa Aktif</p>

                        <div class="list-group list-group-flush text-start rounded-3">
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <span><i class="ti ti-id text-muted me-2"></i>Nomor Induk Siswa (NIS)</span>
                                <span class="fw-bold text-dark"><?= $data['nis']; ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <span><i class="ti ti-building text-muted me-2"></i>Kelas</span>
                                <span class="fw-bold text-dark badge bg-primary rounded-pill"><?= $data['kelas']; ?></span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <span><i class="ti ti-shield-check text-muted me-2"></i>Status Akun</span>
                                <span class="text-success fw-bold"><i class="ti ti-check me-1"></i>Terverifikasi</span>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer bg-light text-center py-3">
                        <small class="text-muted">Jika ada kesalahan data, hubungi Tata Usaha.</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>