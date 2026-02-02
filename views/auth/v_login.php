<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Aplikasi Pengaduan</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/phosphor/regular/style.css" />
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="position-relative my-5">
                    <div class="auth-bg">
                        <span class="r"></span>
                        <span class="r s"></span>
                        <span class="r s"></span>
                        <span class="r"></span>
                    </div>
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <a href="#" class="d-flex align-items-center justify-content-center text-decoration-none">
                                    <i class="ti ti-clipboard-text text-primary" style="font-size: 32px;"></i>

                                    <span class="fw-bold text-dark ms-2" style="font-size: 24px;">E-Lapor</span>
                                </a>
                            </div>
                            <h4 class="text-center f-w-500 mt-4 mb-3">Login</h4>

                            <form action="index.php?page=auth_proccess" method="post">

                                <div class="form-group mb-3">
                                    <input type="text" name="username" class="form-control" placeholder="Username / Nama Siswa" required />
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password / NIS" required />
                                </div>

                                <div class="d-flex mt-1 justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="" />
                                        <label class="form-check-label text-muted" for="customCheckc1">Ingat Saya?</label>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary shadow px-sm-4">Masuk</button>
                                </div>

                            </form>
                            <div class="d-flex justify-content-between align-items-end mt-4">
                                <h6 class="f-w-500 mb-0">Belum punya akun?</h6>
                                <a href="index.php?page=register" class="link-primary">Daftar Disini</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/plugins/popper.min.js"></script>
    <script src="assets/js/plugins/simplebar.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/theme.js"></script>


    
</body>

</html>