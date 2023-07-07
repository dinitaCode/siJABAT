<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Rekomendasi Jabatan</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cari Rekomendasi</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="<?=base_url('Cari_rekomendasi')?>" method="post">
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <div class="select2-purple">
                                        <select class="select2" id="pilih_jabatan" name="id_jabatan" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                        <option value="">- Pilih Jabatan -</option>
                                        <?php foreach ($jabatan as $j) { ?>
                                            <option value="<?=$j->id_jabatan?>"> <?=$j->jabatan?> </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Karyawan</label>  
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="tbl_kandidatGroup">
                                            <thead>
                                            <tr>
                                                <th>Pilih Nama Kandidat</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                        <td>
                                                            <div class="form-group" id="show_kandidat">
                                                                <!-- <div class="custom-control custom-checkbox">
                                                                    <input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="cek<?=$k->id_kry?>" name="karyawan[]" value="<?=$k->id_kry?>">
                                                                    <label for="cek<?=$k->id_kry?>" class="custom-control-label"><?=$k->nama_lengkap?></label>
                                                                </div> -->
                                                            </div>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        </table>
                                        <!-- /.table -->
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Apakah anda yakin ingin melakukan pencarian ini?')"><i class="far fa-hand-point-up"></i> GENERATE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type='text/javascript'>
      $(document).ready(function() {
        $('#pilih_jabatan').change(function() {
          var id_jabatan = $(this).val();
          $.ajax({
            url: '<?= base_url("Rekomendasi/GetKandidat") ?>',
            method: 'post',
            data: {
              id_jabatan: id_jabatan
            },
            dataType: 'json',
            success: function(response) {
              var html = '';
              var i;
              for (i = 0; i < response.length; i++) {
                html += '<div class="custom-control custom-checkbox">'+
                        '<input class="custom-control-input custom-control-input-success custom-control-input-outline" id="cek' + response[i].id_kry +'" type="checkbox" name="karyawan[]" value="' + response[i].id_kry +'">' +
                        '<label for="cek' + response[i].id_kry +'" class="custom-control-label">' + response[i].nama_lengkap + '</label></div>';
              }
              $('#show_kandidat').html(html);
            }
          });
        });
      });
    </script>