<div class="pc-container">
    <div class="pc-content">
        
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-bottom-4 overflow-hidden mb-0" 
                     style="height: 230px; background: linear-gradient(135deg, #0d9488 0%, #115e59 100%); border-radius: 0 0 30px 30px;">
                    <div class="card-body p-0 position-relative">
                        <div class="position-absolute bg-white opacity-10 rounded-circle" style="width: 200px; height: 200px; top: -50px; left: 10%;"></div>
                        <div class="position-absolute bg-white opacity-10 rounded-circle" style="width: 300px; height: 300px; bottom: -100px; right: -50px;"></div>
                        <i class="ti ti-school position-absolute text-white opacity-10" style="font-size: 8rem; top: 20px; right: 40px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-n5 justify-content-center" style="margin-top: -100px;">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 position-relative">
                    <div class="card-body text-center p-4">
                        
                        <div class="position-relative d-inline-block mb-3 mt-n5">
                            <div class="bg-white p-2 rounded-circle shadow-sm">
                                <img src="assets/img/user_default.png" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($data['nama']); ?>&background=0d9488&color=fff'" 
                                     class="rounded-circle" style="width: 110px; height: 110px; object-fit: cover;" alt="User">
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-white border-2 rounded-circle" title="Aktif"></span>
                        </div>

                        <h4 class="fw-bold text-dark mb-1"><?= htmlspecialchars($data['nama']); ?></h4>
                        <p class="text-muted small mb-4"><i class="ti ti-id-badge me-1"></i>Siswa Sekolah</p>

                        <div class="row g-2 text-start">
                            
                            <div class="col-6">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center hover-scale">
                                    <i class="ti ti-fingerprint fs-3 text-teal mb-2 d-block"></i>
                                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">NIS</small>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($data['nis']); ?></div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="p-3 border rounded-3 bg-light h-100 text-center hover-scale">
                                    <i class="ti ti-building-arch fs-3 text-warning mb-2 d-block"></i>
                                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Kelas</small>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($data['kelas']); ?></div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between hover-scale">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white p-2 rounded-circle text-success me-3 shadow-sm">
                                            <i class="ti ti-shield-check fs-5"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.65rem;">Status Akun</small>
                                            <span class="fw-bold text-success fs-6">Terverifikasi</span>
                                        </div>
                                    </div>
                                    <i class="ti ti-check-circle text-success fs-4"></i>
                                </div>
                            </div>

                        </div>
                        </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .text-teal { color: #0d9488; }
    .hover-scale { transition: transform 0.2s ease, background-color 0.2s; }
    .hover-scale:hover { transform: translateY(-3px); background-color: #f8fafc !important; border-color: #0d9488 !important; }
</style>