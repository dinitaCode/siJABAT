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
                                        <select class="select2" name="id_jabatan" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
                                        <option value="">--Pilih Jabatan--</option>
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
                                                <?php foreach ($kriteria_kry as $k) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="cek<?=$k->id_kry?>" name="karyawan[]" value="<?=$k->id_kry?>">
                                                                    <label for="cek<?=$k->id_kry?>" class="custom-control-label"><?=$k->nama_lengkap?></label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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
