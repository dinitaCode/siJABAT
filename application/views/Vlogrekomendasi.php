<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Rekomendasi</h1>
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
                            <h3 class="card-title">Data History Rekomendasi</h3>
                            <div class="card-tools">
                                <a href="<?=base_url('Pencarian')?>" class="btn btn-primary"><i class="fas fa-search"></i> Rekomendasi Jabatan</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive" >   
                                <table class="table table-hover text-nowrap table-head-fixed table-bordered table-sm" id="tbl_kry">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Jabatan</th>
                                            <th>Nilai Similarity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nop = 1;
                                        foreach ($logrekom as $p) { ?>
                                            <tr>
                                                <td><?= $nop++ ?></td>
                                                <td>
                                                    <p class="text-success text-center"><b><?= date("d M Y H:i", strtotime($p->tgl_log)) ?></b></p>
                                                </td>
                                                <td><?= $p->jabatan ?></td>
                                                <td>
                                                    <span class="lead text-purple"><b><?=$p->nilai_max_sim?></b></span>
                                                    <?php if ($user->role == 'direksi') { ?>
                                                        <a href="<?=base_url('Rekomendasi/Hasil_rekomendasi/'.$p->id_log.'/'.$p->id_jabatan)?>" class="btn btn-outline-primary btn-sm float-right">
                                                            <i class="far fa-folder-open"></i> DETAIL
                                                        </a>
                                                    <?php } ?>
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