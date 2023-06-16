</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="row">
    <div class="col-sm-12 col-md-4">
      <p class="text-center mt-3">Copyright &copy; <?= date('Y')?> DCP.</p>
    </div>
    <div class="col-md-3 col-sm-12 text-center">
      <center><img class="img-fluid pad" src="<?= site_url('assets/img/logo.png') ?>" alt="siJABAT"></center>
    </div>
    <div class="col-4 d-none d-sm-block">
      <p class="text-center mt-3">All Rights Reserved.</p>
    </div>
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Datatables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
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
<!-- InputMask -->
<script src="<?= base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Ekko Lightbox -->
<script src="<?= base_url() ?>assets/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script>
  $(function() {
    $("#tbl_kry").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#tbl_kry_wrapper .col-md-6:eq(0)');

    $('#tbl_kandidatGroup').DataTable({
      'paging'      : false,
      'lengthChange': false
    })

    bsCustomFileInput.init();

    $('#rekapperiode').daterangepicker()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    $('.select2').select2()
    $('[data-mask]').inputmask()
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
<script>
  <?php if (@$_SESSION['notification']) { ?>
    var isi = <?php echo json_encode($this->session->flashdata('notification')) ?>;
    Swal.fire({
      icon: 'success',
      title: 'Hei...',
      text: isi,
      showConfirmButton: false,
      timer: 2500
    });
  <?php unset($_SESSION['notification']);
  } else  if (@$_SESSION['tetot']) { ?>
    var isi = <?php echo json_encode($this->session->flashdata('tetot')) ?>;
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: isi,
      showConfirmButton: false,
      timer: 2500
    });
  <?php unset($_SESSION['tetot']);
  } else ?>
</script>

</body>

</html>