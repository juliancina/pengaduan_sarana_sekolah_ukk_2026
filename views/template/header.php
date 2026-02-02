<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard Siswa - E-Lapor</title>
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

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <header class="pc-header">
        <div class="header-wrapper">


            <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">

                <div class="dropdown-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-user-circle fs-2 text-primary me-2"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-0"><?= isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Siswa'; ?></h6>
                                <small class="text-muted">User Siswa</small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="dropdown-divider">

                <a href="index.php?page=logout" class="dropdown-item text-danger">
                    <i class="ti ti-power me-2"></i> <span>Logout</span>
                </a>
            </div>
            </li>
            </ul>
        </div>

        </div>
    </header>
    ```