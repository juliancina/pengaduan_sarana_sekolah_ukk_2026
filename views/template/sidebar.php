<?php
$p = isset($_GET['page']) ? $_GET['page'] : 'home';
// Cek level user dari Session \\
$level = isset($_SESSION['level']) ? $_SESSION['level'] : 'siswa'; 
?>

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand text-primary">
                <i class="ti ti-school text-white" style="font-size: 26px;"></i>
                <span class="fw-bold fs-4 ms-2 text-white">E-Lapor</span>
            </a>
        </div>
        
        <div class="navbar-content">
            <ul class="pc-navbar">
                
                <?php if($level == 'admin'): ?>
                <li class="pc-item pc-caption"><label>ADMINISTRATOR</label></li>
                
                <li class="pc-item <?= ($p=='admin_dashboard') ? 'active' : ''; ?>">
                    <a href="index.php?page=admin_dashboard" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item <?= ($p=='verifikasi') ? 'active' : ''; ?>">
                    <a href="index.php?page=verifikasi" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-gavel"></i></span>
                        <span class="pc-mtext">Verifikasi & Validasi</span>
                    </a>
                </li>

                <li class="pc-item <?= ($p=='admin_riwayat') ? 'active' : ''; ?>">
                    <a href="index.php?page=admin_riwayat" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-history"></i></span>
                        <span class="pc-mtext">Riwayat Selesai</span>
                    </a>
                </li>
                
                <li class="pc-item pc-caption"><label>PENGATURAN</label></li>
                
                <li class="pc-item <?= ($p=='admin_akun') ? 'active' : ''; ?>">
                    <a href="index.php?page=admin_akun" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-cog"></i></span>
                        <span class="pc-mtext">Profil Admin</span>
                    </a>
                </li>

                <?php else: ?>
                <li class="pc-item pc-caption"><label>UTAMA</label></li>
                
                <li class="pc-item <?= ($p=='home' || $p=='siswa_dashboard') ? 'active' : ''; ?>">
                    <a href="index.php?page=home" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-home"></i></span>
                        <span class="pc-mtext">Home</span>
                    </a>
                </li>

                <li class="pc-item <?= $p=='akun' ? 'active' : ''; ?>">
                    <a href="index.php?page=akun" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-circle"></i></span>
                        <span class="pc-mtext">Akun Saya</span>
                    </a>
                </li>

                <li class="pc-item pc-caption"><label>PELAPORAN</label></li>

                <li class="pc-item <?= ($p=='form' || $p=='simpan') ? 'active' : ''; ?>">
                    <a href="index.php?page=form" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-edit"></i></span>
                        <span class="pc-mtext">Form Pengaduan</span>
                    </a>
                </li>

                <li class="pc-item <?= $p=='riwayat' ? 'active' : ''; ?>">
                    <a href="index.php?page=riwayat" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-file-check"></i></span>
                        <span class="pc-mtext">Riwayat Selesai</span>
                    </a>
                </li>
                <?php endif; ?>

                <li class="pc-item pc-caption"><label>KELUAR</label></li>
                <li class="pc-item">
                    <a href="index.php?page=logout" class="pc-link text-danger">
                        <span class="pc-micon"><i class="ti ti-power"></i></span>
                        <span class="pc-mtext">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>