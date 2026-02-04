<div class="pc-container">
    <div class="pc-content">

        <?php if (isset($stats['laporan_masuk']) && $stats['laporan_masuk'] > 0): ?>
        <div class="notification-float">
            <div class="alert alert-warning border-0 shadow-lg d-flex align-items-center p-3 rounded-4 mb-0" role="alert">
                <div class="bg-white text-warning p-2 rounded-circle me-3 shadow-sm">
                    <i class="ti ti-bell-ringing fs-3"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Laporan Masuk!</h6>
                    <small class="text-dark opacity-75">
                        Ada <strong><?= $stats['laporan_masuk']; ?></strong> laporan baru menunggu.
                    </small>
                    <a href="index.php?page=verifikasi" class="stretched-link"></a>
                </div>
                <button type="button" class="btn-close ms-3 z-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php endif; ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg position-relative overflow-hidden rounded-5" 
                     style="background: linear-gradient(135deg, #0d9488 0%, #115e59 100%);">
                    
                    <div class="position-absolute rounded-circle" 
                         style="width: 300px; height: 300px; top: -80px; left: -50px; background: rgba(0, 0, 0, 0.15);"></div>
                    <div class="position-absolute rounded-circle" 
                         style="width: 200px; height: 200px; bottom: -50px; right: 10%; background: rgba(0, 0, 0, 0.15);"></div>

                    <div class="card-body p-4 p-md-5 position-relative z-1 text-white">
                        <div class="row align-items-center">
                            
                            <div class="col-md-8 mb-4 mb-md-0">
                                <span class="badge bg-white text-teal mb-3 px-3 py-2 fw-bold rounded-pill text-uppercase ls-1 shadow-sm">
                                    <i class="ti ti-shield-lock me-1"></i> Administrator Area
                                </span>
                                <h1 class="fw-bold mb-2 display-6" style="color: #fef3c7;">Selamat Datang, Admin! 👋</h1>
                                <p class="lead opacity-90 mb-4 fw-light">
                                    Pantau dan kelola laporan pengaduan sekolah dengan mudah dan cepat.
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="index.php?page=verifikasi" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm hover-up">
                                        <i class="ti ti-list-check me-2"></i>Cek Laporan Masuk
                                    </a>
                                    <a href="index.php?page=cetak_laporan" target="_blank" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill hover-up">
                                        <i class="ti ti-printer me-2"></i>Cetak Laporan
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end text-start border-start border-white border-opacity-25 ps-md-5">
                                <h5 class="fw-normal mb-0 opacity-75" style="color:#fef3c7;">Hari ini</h5>
                                <h2 class="fw-bold mb-0 display-4" style="color:#fef3c7;"><?= date('d'); ?></h2>
                                <h4 class="fw-normal mb-0 text-uppercase ls-1" style="color:#fef3c7;"><?= date('F Y'); ?></h4>
                                <div class="mt-3 d-inline-block bg-white bg-opacity-25 px-3 py-1 rounded-pill shadow-sm">
                                    <i class="ti ti-calendar me-1"></i> <?= date('l'); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-3 ps-2 border-start border-4 border-teal"><i class="ti ti-chart-pie me-2"></i>Statistik Pengaduan</h5>
        <div class="row g-3 mb-5">
            
            <div class="col-md-4 col-6">
                <div class="card border-0 shadow-sm h-100 hover-scale bg-warning text-dark text-center rounded-4">
                    <div class="card-body p-3">
                        <i class="ti ti-clock fs-1 mb-2 opacity-50"></i>
                        <h6 class="text-uppercase small fw-bold mb-1 opacity-75">Menunggu</h6>
                        <h2 class="fw-bold mb-0"><?= isset($stats['menunggu']) ? $stats['menunggu'] : 0; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card border-0 shadow-sm h-100 hover-scale bg-info text-white text-center rounded-4">
                    <div class="card-body p-3">
                        <i class="ti ti-settings fs-1 mb-2 opacity-50"></i>
                        <h6 class="text-uppercase small fw-bold mb-1 opacity-75">Di Proses</h6>
                        <h2 class="fw-bold mb-0"><?= isset($stats['proses']) ? $stats['proses'] : 0; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-6">
                <div class="card border-0 shadow-sm h-100 hover-scale bg-success text-white text-center rounded-4">
                    <div class="card-body p-3">
                        <i class="ti ti-circle-check fs-1 mb-2 opacity-50"></i>
                        <h6 class="text-uppercase small fw-bold mb-1 opacity-75">Selesai</h6>
                        <h2 class="fw-bold mb-0"><?= isset($stats['selesai']) ? $stats['selesai'] : 0; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold text-dark mb-3 ps-2 border-start border-4 border-dark"><i class="ti ti-server me-2"></i>Informasi Sistem</h5>
        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-up position-relative overflow-hidden rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="step-icon bg-light-primary text-primary me-4">
                            <i class="ti ti-users fs-2"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Data Siswa</h5>
                            <p class="text-muted small mb-0">Total <b><?= isset($stats['total_siswa']) ? $stats['total_siswa'] : 0; ?></b> siswa terdaftar dalam sistem.</p>
                        </div>
                        <div class="ms-auto">
                            <i class="ti ti-chevron-right text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-up position-relative overflow-hidden rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="step-icon bg-light-danger text-danger me-4">
                            <i class="ti ti-user-shield fs-2"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Profil Admin</h5>
                            <p class="text-muted small mb-0">Kelola akun dan password administrator.</p>
                        </div>
                        <a href="index.php?page=admin_akun" class="stretched-link"></a>
                        <div class="ms-auto">
                            <i class="ti ti-chevron-right text-muted opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
    /* 1. CSS ANIMASI NOTIFIKASI */
    .notification-float {
        position: fixed;
        top: 90px; /* Jarak dari atas (di bawah navbar) */
        right: 20px;
        z-index: 9999; /* Pastikan selalu di atas elemen lain */
        min-width: 320px;
        animation: slideInRight 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards;
    }

    @keyframes slideInRight {
        0% {
            transform: translateX(120%);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* 2. CUSTOM COLORS */
    .text-teal { color: #0d9488; }
    .border-teal { border-color: #0d9488 !important; }
    
    /* 3. HOVER EFFECTS */
    .hover-up { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-up:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.05); }

    /* 4. ICONS */
    .step-icon {
        width: 70px; height: 70px; min-width: 70px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        z-index: 2; position: relative;
    }
    .bg-light-primary { background-color: #e0e7ff; }
    .bg-light-danger { background-color: #fee2e2; }
    
    .ls-1 { letter-spacing: 1px; }
    .rounded-5 { border-radius: 1.5rem !important; }
    .rounded-4 { border-radius: 1rem !important; }
</style>