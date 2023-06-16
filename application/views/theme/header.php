<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>siJABAT - Rekomendasi Jabatan</title>
  <meta name="author" content="DinitaCP">
  <meta name="description" content="Sistem Rekomendasi Jabatan">
  <meta name="keywords" content="Sistem, Rekomendasi, Pengambilan Keputusan, Keputusan, Karyawan, Kandidat, Sistem informasi, Web">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/summernote/summernote-bs4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ekko-lightbox/ekko-lightbox.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/logfull.png">
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed text-sm layout-fixed">
    <div class="wrapper">
        <?php date_default_timezone_set("Asia/Jakarta"); ?>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <span class="nav-link">
                        <?= date('d/m/Y'); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Logout') ?>" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-purple elevation-1">
            <!-- Brand Logo -->
            <a href="<?= base_url('Rekomendasi') ?>" class="brand-link">
                  <b>KB</b>RS
                <span class="brand-text font-weight-light text-success">  
                  <img src="<?= base_url() ?>assets/img/logo.png" alt="Logo"  class="brand-image elevation-3">
                </span>
            </a>

            <!-- Sidebar style="display: block;"-->
            <div class="sidebar">
                <div class="mt-3 d-flex">
                  <img class="profile-user-img img-fluid mx-auto" style="border-radius: 0.7rem;" src="<?= base_url('assets/img/logfull.png') ?>" alt="User Logo siJABAT" class="brand-image elevation-3">
                </div>
                <div class="user-panel d-flex">
                    <div class="info mx-auto text-center">
                        <span class="username text-success"><a href="<?= base_url('Profil_pasien') ?>"><i class="fas fa-user mr-1"></i> <?= $user->nama_lengkap ?></a></span>
                        <p>
                            <small><?= $user->role ?></small>
                        </p>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= base_url('Rekomendasi') ?>" class="nav-link 
                                <?php if ($menu == 'Home') {
                                    echo 'active';
                                } ?>">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Karyawan') ?>" class="nav-link 
                                <?php if ($menu == 'Karyawan') {
                                    echo 'active';
                                } ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Karyawan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Jabatan') ?>" class="nav-link 
                                <?php if ($menu == 'Jabatan') {
                                    echo 'active';
                                } ?>">
                                <i class="nav-icon fas fa-id-card-alt"></i>
                                <p>
                                    Jabatan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Kriteria') ?>" class="nav-link 
                                <?php if ($menu == 'Kriteria') {
                                    echo 'active';
                                } ?>">
                                <i class="nav-icon fas fa-universal-access"></i>
                                <p>
                                    Kriteria
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">REKOMENDASI</li>
                        <?php if ($user->role == 'direksi') { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('Pencarian') ?>" class="nav-link 
                                    <?php if ($menu == 'Pencarian') {
                                        echo 'active';
                                    } ?>">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        Pencarian
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="<?= base_url('History') ?>" class="nav-link 
                                <?php if ($menu == 'History') {
                                    echo 'active';
                                } ?>">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    History
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>