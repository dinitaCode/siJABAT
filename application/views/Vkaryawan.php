<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Karyawan</h1>
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
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Karyawan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive" >   
                                <table class="table table-hover text-nowrap table-head-fixed table-bordered table-sm" id="tbl_kry">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIK</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nop = 1;
                                        foreach ($karyawan as $p) { ?>
                                            <tr>
                                                <td><?= $nop++ ?></td>
                                                <td>
                                                    <p class="text-success text-center"><b><?= $p->nik ?></b></p>
                                                </td>
                                                <td><?= $p->nama_lengkap ?></td>
                                                <td>
                                                    <?php $jk = ($p->jk=='L') ? '<i class="fas fa-male"></i> Laki-laki' : '<i class="fas fa-female"></i> Perempuan' ; echo $jk;?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-block btn-primary" href="<?=base_url('Rekomendasi/DetailKry/'. encrypt_url($p->id_kry))?>">
                                                        <i class="far fa-folder-open"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>