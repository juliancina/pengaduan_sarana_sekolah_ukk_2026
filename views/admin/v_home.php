<div class="pc-container">
    <div class="pc-content">

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg position-relative overflow-hidden" 
                     style="background: linear-gradient(120deg, #1565C0 0%, #00C6FF 100%); border-radius: 15px;">
                    <i class="ti ti-chart-bar position-absolute opacity-10 text-white" style="right: -20px; bottom: -20px; font-size: 10rem;"></i>
                    <div class="card-body p-4 position-relative z-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-white">
                                <span class="badge bg-white text-primary mb-2 px-3 py-1 fw-bold rounded-pill">
                                    <i class="ti ti-school me-1"></i> Admin Panel
                                </span>
                                <h2 class="fw-bold text-white mb-0">Dashboard</h2>
                                <p class="mb-0 opacity-75 mt-1">Selamat Datang, Admin! Mari kelola laporan hari ini.</p>
                            </div>
                            <div class="text-white text-end opacity-75 border-start ps-3 border-white d-none d-md-block">
                                <h5 class="mb-0 fw-bold"><?= date('l'); ?></h5>
                                <small class="text-uppercase ls-1"><?= date('d F Y'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($stats['laporan_masuk'] > 0): ?>
        <div class="alert alert-danger shadow-sm border-0 d-flex align-items-center mb-4 pulse-animation" role="alert" style="border-left: 5px solid #dc3545 !important;">
            <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                <i class="ti ti-bell-ringing fs-4"></i>
            </div>
            <div>
                <h6 class="alert-heading fw-bold mb-1">Perhatian!</h6>
                <p class="mb-0">
                    Ada <strong><?= $stats['laporan_masuk']; ?> laporan baru masuk</strong>. Segera lakukan verifikasi.
                </p>
            </div>
        </div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <a href="index.php?page=verifikasi" class="text-decoration-none">
                    <div class="card border-0 shadow-sm hover-up bg-primary text-white h-100 overflow-hidden position-relative">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between position-relative z-1">
                            <div>
                                <h5 class="fw-bold text-white mb-1"><i class="ti ti-list-check me-2"></i>Verifikasi Laporan</h5>
                                <span class="opacity-75 small">Cek laporan masuk & update status</span>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2">
                                <i class="ti ti-chevron-right fs-4 text-white"></i>
                            </div>
                        </div>
                        <div class="position-absolute bg-white opacity-10 rounded-circle" style="width: 120px; height: 120px; top: -30px; right: -30px;"></div>
                    </div>
                </a>
            </div>

            <div class="col-md-6">
                <a href="index.php?page=cetak_laporan" target="_blank" class="text-decoration-none">
                    <div class="card border-0 shadow-sm hover-up bg-dark text-white h-100 overflow-hidden position-relative">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between position-relative z-1">
                            <div>
                                <h5 class="fw-bold text-white mb-1"><i class="ti ti-printer me-2"></i>Cetak Laporan</h5>
                                <span class="opacity-75 small">Rekapitulasi data laporan selesai</span>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-2">
                                <i class="ti ti-chevron-right fs-4 text-white"></i>
                            </div>
                        </div>
                        <div class="position-absolute bg-white opacity-10 rounded-circle" style="width: 120px; height: 120px; top: -30px; right: -30px;"></div>
                    </div>
                </a>
            </div>
        </div>

        <h6 class="fw-bold text-muted text-uppercase small mb-3 ls-1">Statistik Status</h6>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-scale">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="flex-shrink-0 bg-light-warning text-warning rounded-3 p-3 me-3">
                            <i class="ti ti-clock fs-2"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Menunggu</h6>
                            <h2 class="mb-0 fw-bold text-dark"><?= $stats['menunggu']; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-scale">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="flex-shrink-0 bg-light-info text-info rounded-3 p-3 me-3">
                            <i class="ti ti-settings fs-2"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Sedang Proses</h6>
                            <h2 class="mb-0 fw-bold text-dark"><?= $stats['proses']; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-scale">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="flex-shrink-0 bg-light-success text-success rounded-3 p-3 me-3">
                            <i class="ti ti-circle-check fs-2"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase fw-bold mb-1 small">Selesai</h6>
                            <h2 class="mb-0 fw-bold text-dark"><?= $stats['selesai']; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php if($stats['laporan_masuk'] > 0): ?>
<div class="custom-toast" id="notifToast">
    <div class="toast-content">
        <div class="toast-icon">
            <i class="ti ti-bell-ringing"></i>
        </div>
        <div class="toast-text">
            <span class="toast-title">Notifikasi Baru</span>
            <span class="toast-desc">Hai Admin, ada <b><?= $stats['laporan_masuk']; ?> laporan baru</b> yang belum dicek!</span>
        </div>
        <div class="toast-close" onclick="closeToast()">
            <i class="ti ti-x"></i>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Beri jeda 1 detik setelah halaman load, lalu munculkan toast
        setTimeout(function() {
            var toast = document.getElementById("notifToast");
            if(toast) {
                toast.classList.add("show");
            }
        }, 1000);
    });

    function closeToast() {
        var toast = document.getElementById("notifToast");
        toast.classList.remove("show");
    }
</script>
<?php endif; ?>

<style>
    .ls-1 { letter-spacing: 1px; }
    .hover-up { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-up:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.02); }
    
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    .pulse-animation { animation: pulse-red 2s infinite; }

    /* --- STYLE NOTIFIKASI TOAST --- */
    .custom-toast {
        position: fixed;
        bottom: 30px;
        right: -450px; /* Posisi awal bersembunyi di kanan */
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        border-left: 6px solid #dc3545; /* Garis merah kiri */
        z-index: 9999;
        transition: right 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55); /* Efek memantul */
        min-width: 350px;
        display: flex;
        align-items: center;
    }

    /* Class untuk memunculkan (digeser ke kiri) */
    .custom-toast.show {
        right: 30px; 
    }

    .toast-content {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .toast-icon {
        background: #fde8e8;
        color: #dc3545;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-right: 15px;
        font-size: 1.2rem;
    }

    .toast-text {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .toast-title {
        font-weight: bold;
        color: #333;
        font-size: 1rem;
        margin-bottom: 2px;
    }

    .toast-desc {
        font-size: 0.85rem;
        color: #666;
    }

    .toast-close {
        cursor: pointer;
        opacity: 0.5;
        padding: 5px;
        transition: 0.3s;
    }
    .toast-close:hover { opacity: 1; color: #dc3545; }
</style>