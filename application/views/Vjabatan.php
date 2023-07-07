<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Jabatan</h1>
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
                            <h3 class="card-title">Data Jabatan</h3>
                            <?php if($this->session->userdata('role')=='direksi') { ?>
                                <div class="box-tools"> 
                                    <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#addjab">
                                        <i class="fa fa-plus"></i> Jabatan
                                    </button>
                                </div>
                                <div class="modal fade" id="addjab">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h4 class="modal-title"><i class="fa fa-plus"></i> Jabatan</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form class="form-horizontal" action="<?=base_url('Rekomendasi/TambahJabatan')?>" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <label for="nama_jabatan" class="col-sm-2 control-label text-black">Nama Jabatan</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" placeholder="Nama Jabatan">
                                                        </div>
                                                    </div>
                                                    <hr><p class="lead">Kriteria Jabatan</p>
                                                    <?php foreach ($kriteria as $k) { ?>
                                                        <div class="form-group row">
                                                            <label for="kj<?=$k->id_kriteria?>" class="col-sm-2 control-label text-black"><?=$k->kriteria?></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="<?=$k->id_kriteria?>" id="kj<?=$k->id_kriteria?>" placeholder="<?=$k->satuan?>">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            <?php } ?>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive" >   
                                <table class="table table-hover text-nowrap table-head-fixed table-bordered table-sm" id="tbl_kry">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nop = 1;
                                        foreach ($jabatan as $p) { 
                                            $nkj = 1;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $nop ?></td>
                                                <td class="text-center text-lead"><?= $p->jabatan ?></td>
                                                <td>
                                                    <a href="<?=base_url('Rekomendasi/DetailJab/'.encrypt_url($p->id_jabatan))?>" class="btn btn-sm btn-primary">
                                                        <i class="far fa-folder-open"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php $nop++; } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    