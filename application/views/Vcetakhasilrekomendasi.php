<!DOCTYPE html>
<html>
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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/ekko-lightbox/ekko-lightbox.css">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/logfull.png">
</head>
<body onLoad="window.print()">
  <table class="p-0">
    <thead>
      <tr>
        <td>
            <img src="<?=base_url('assets/img/kop_poltek.PNG')?>"><hr>
        </td>
      </tr>
      <tr>
      	<td>
            <h3 class="text-center">HASIL REKOMENDASI JABATAN</h3>
            <h4 class="text-center"><b><?=$jbt->jabatan?></b></h4><hr>
      	</td>
      </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="row">
                    <div class="col-6">
                        <dl class="row">
                            <?php $nop=1; foreach ($kriteria_jab as $kj) {?>
                                    <dt class="col-sm-8"><?=$nop."."?> <?=$kj->kriteria?></dt>
                                    <dd class="col-sm-4">: <?=$kj->nilai_kriteriaJab." ".$kj->satuan?></dd>
                            <?php
                            $nop++;    }
                            ?>
                        </dl>
                    </div>
                    <div class="col-6">
                        <h3><i class="fas fa-user-check"></i> Hasil Rekomendasi : </h3>
                        <h4 class="text-center text-green"><i class="far fa-star text-green"></i> <?=$log->nama_lengkap?></h4>
                        <p class="text-center">Similarity Tertinggi  : <b> <?=$log->nilai_max_sim?> </b></p>
                    </div>
                </div>

            </td>
        </tr>
      <tr>
        <td>
            <h4>Perhitungan Rekomendasi</h4>
            
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>\</td>
                        <?php foreach ($kriteria as $k) {
                            echo "<th>".$k->kriteria." (".$k->pembobotan.")</th>";
                        } ?>
                    </tr>
                    <tr>
                        <th>Kriteria</th>
                        <?php foreach ($kriteria_kry as $kk) {
                            if ($kk->id_kry == $log->id_kry) {
                                echo "<td>".$kk->nilai_kriteriaKry."</td>";
                            }
                        } ?>
                    </tr>
                </table>
            <h4>Kandidat</h4>
            <table class="table text-nowrap table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Nilai Similarity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nop = 1; 
                        foreach ($kandidat as $p) { 
                    ?>
                        <tr>
                            <td><?= $nop++ ?></td>
                            <td>
                                <p class="text-success text-center"><b><?= $p->nik ?></b></p>
                            </td>
                            <td><?= $p->nama_lengkap ?></td>
                            <td>
                                <span class="text-center text-blue"><?=$p->sim?></span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </td>  
      </tr>
      <tr>
      	<td>
      		<table align="right">
		        <tr><td>Surakarta, <?= date("d M Y", strtotime($p->tgl_log)) ?></td></tr>
		        <tr><td>Koordinator</td></tr>
		        <tr><td><br><br><br><br></td></tr>
		        <tr><td>_______________________________</td></tr>
		      </table>
      	</td>
      </tr>
    </tbody>
  </table>

<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url() ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= base_url() ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.js"></script>
<!-- bs-custom-file-input -->
<script src="<?= base_url() ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- BS-Stepper -->
<script src="<?= base_url() ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
</body>
</html>