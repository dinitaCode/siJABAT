<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Kriteria Jabatan</h1>
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
                            <h3 class="card-title">Data Kriteria Jabatan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive" >   
                                <table class="table table-hover text-nowrap table-head-fixed table-bordered table-sm" id="tbl_kry">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kriteria</th>
                                            <th>Pembobotan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nop = 1;
                                        foreach ($kriteria as $p) { ?>
                                            <tr>
                                                <td><?= $nop++ ?></td>
                                                <td><?= $p->kriteria ?></td>
                                                <td><?= $p->pembobotan?></td>
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
