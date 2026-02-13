<div class="pc-container">
    <div class="pc-content">
        
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-bottom-4 overflow-hidden mb-0" 
                     style="height: 230px; background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 0 0 30px 30px;">
                    <div class="card-body p-0 position-relative">
                        <div class="position-absolute bg-white opacity-5 rounded-circle" style="width: 250px; height: 250px; top: -80px; left: 20%;"></div>
                        <i class="ti ti-user-shield position-absolute text-white opacity-10" style="font-size: 9rem; top: 30px; right: 40px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-n5 justify-content-center" style="margin-top: -100px;">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 position-relative">
                    <div class="card-body text-center p-4">
                        
                        <div class="position-relative d-inline-block mb-3 mt-n5">
                            <div class="avatar-xxl rounded-circle border border-4 border-white shadow-sm bg-white d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px;">
                                <i class="ti ti-user fs-1 text-primary"></i>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-1">
                            <?= isset($data['nama']) ? htmlspecialchars($data['nama']) : 'Siswa'; ?>
                        </h4>
                        
                        <p class="text-muted mb-4">
                            NIS: <?= isset($data['nis']) ? htmlspecialchars($data['nis']) : '-'; ?>
                        </p>

                        <div class="row g-3 text-start">
                            
                            <div class="col-6">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center hover-scale">
                                    <i class="ti ti-id-badge fs-3 text-primary mb-2 d-block"></i>
                                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Kelas</small>
                                    <div class="fw-bold text-dark">
                                        <?= isset($data['kelas']) ? htmlspecialchars($data['kelas']) : '-'; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center hover-scale">
                                    <i class="ti ti-shield-check fs-3 text-success mb-2 d-block"></i>
                                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Status</small>
                                    <div class="fw-bold text-success">
                                        Aktif
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="mt-4 pt-3 border-top">
                             <a href="index.php?page=logout" class="btn btn-outline-danger w-100 rounded-pill fw-bold">
                                <i class="ti ti-power me-2"></i>Keluar
                             </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: translateY(-3px); background-color: #f1f5f9 !important; }
</style>