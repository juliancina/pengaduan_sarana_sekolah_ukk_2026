<div class="pc-container">
    <div class="pc-content">

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
                                    <i class="ti ti-user-circle me-1"></i> Dashboard Siswa
                                </span>
                                <h1 class="fw-bold mb-2 display-6" style="color: #fef3c7;">Halo, <?= isset($data['nama']) ? htmlspecialchars($data['nama']) : 'Siswa'; ?>! 👋</h1>
                                <p class="lead opacity-90 mb-4 fw-light">
                                    Selamat datang kembali. Mari jaga fasilitas sekolah kita bersama-sama. <br>
                                    <span class="fs-6 opacity-75">Laporkan kerusakan sekarang juga.</span>
                                </p>
                                <a href="index.php?page=form" class="btn btn-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm hover-up">
                                    <i class="ti ti-plus me-2"></i>Buat Laporan Baru
                                </a>
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


        <h5 class="fw-bold text-dark mb-3 ps-2 border-start border-4 border-dark"><i class="ti ti-info-circle me-2"></i>Alur Pengaduan</h5>
        <div class="row g-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center hover-up position-relative overflow-hidden rounded-4">
                    <div class="card-body p-4">
                        <div class="step-number">1</div>
                        <div class="step-icon bg-light-primary text-primary mb-3 mx-auto">
                            <i class="ti ti-pencil fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Isi Laporan</h6>
                        <p class="text-muted small mb-0">Klik tombol buat laporan, isi detail kerusakan dan lokasi.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center hover-up position-relative overflow-hidden rounded-4">
                    <div class="card-body p-4">
                        <div class="step-number">2</div>
                        <div class="step-icon bg-light-warning text-warning mb-3 mx-auto">
                            <i class="ti ti-camera fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Upload Foto</h6>
                        <p class="text-muted small mb-0">Wajib sertakan foto bukti kerusakan agar valid.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center hover-up position-relative overflow-hidden rounded-4">
                    <div class="card-body p-4">
                        <div class="step-number">3</div>
                        <div class="step-icon bg-light-info text-info mb-3 mx-auto">
                            <i class="ti ti-settings fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Verifikasi</h6>
                        <p class="text-muted small mb-0">Admin akan mengecek dan memproses laporanmu.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center hover-up position-relative overflow-hidden rounded-4">
                    <div class="card-body p-4">
                        <div class="step-number">4</div>
                        <div class="step-icon bg-light-success text-success mb-3 mx-auto">
                            <i class="ti ti-check fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Selesai</h6>
                        <p class="text-muted small mb-0">Sarana diperbaiki & laporan dinyatakan selesai.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
    /* Custom Colors */
    .text-teal {
        color: #0d9488;
    }

    .border-teal {
        border-color: #0d9488 !important;
    }

    /* Hover Effects */
    .hover-up {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-up:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .hover-scale {
        transition: transform 0.2s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    /* Icons Background */
    .step-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        position: relative;
    }

    .bg-light-primary {
        background-color: #e0e7ff;
    }

    .bg-light-warning {
        background-color: #fef3c7;
    }

    .bg-light-info {
        background-color: #cffafe;
    }

    .bg-light-success {
        background-color: #dcfce7;
    }

    /* Step Number Decoration */
    .step-number {
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 4rem;
        font-weight: 900;
        color: rgba(0, 0, 0, 0.03);
        font-family: sans-serif;
        z-index: 1;
    }

    .ls-1 {
        letter-spacing: 1px;
    }

    .rounded-5 {
        border-radius: 1.5rem !important;
    }

    .rounded-4 {
        border-radius: 1rem !important;
    }
</style>