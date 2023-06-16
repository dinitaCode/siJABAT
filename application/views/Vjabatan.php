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
                            <div class="box-tools"> 
                                <button type="button" class="btn btn-outline-primary btn-sm float-right" data-toggle="modal" data-target="#addjab">
                                    <i class="fa fa-plus"></i> Jabatan
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive" >   
                                <table class="table table-hover text-nowrap table-head-fixed table-bordered table-sm" id="tbl_kry">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Jabatan</th>
                                            <th>Kriteria</th>
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
                                                    <table class="table table-hover text-nowrap table-sm">
                                                        <tbody>
                                                            <?php foreach ($kriteria_jab as $kj) {
                                                                if ($kj->id_jabatan == $p->id_jabatan) {
                                                            ?>
                                                                <tr>
                                                                    <td><?=$nop.".".$nkj?> <b><?=$kj->kriteria?></b></td>
                                                                    <td>
                                                                        <?=$kj->nilai_kriteriaJab." ".$kj->satuan?>
                                                                        <?php if($this->session->userdata('role')=='direksi') { ?>
                                                                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#ed<?=$kj->id_kriteria?>">
                                                                                <i class="fas fa-pencil-alt"></i> 
                                                                            </button>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php if($this->session->userdata('role')=='direksi') { ?>
                                                                    <div class="modal fade" id="ed<?=$nop."_".$nkj++?>"">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title"><i class="fas fa-pencil-alt"></i> Kriteria <?= $p->jabatan ?></h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form class="form-horizontal" action="<?=base_url('Rekomendasi/Proses_kriteriaJB')?>" method="post">
                                                                                        <input type="hidden" name="id_kriteriaJab" value="<?=$kj->id_kriteria?>">
                                                                                        <div class="form-group row">
                                                                                            <label for="kj<?=$kj->id_kriteria?>" class="col-sm-4 control-label text-black"><?=$kj->kriteria?></label>
                                                                                            <div class="col-sm-8">
                                                                                                <input type="text" class="form-control" value="<?=$kj->nilai_kriteriaJab?>" id="kj<?=$kj->id_kriteria?>" placeholder="<?=$kj->satuan?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <button type="submit" class="btn btn-primary btn-sm float-right">SIMPAN</button>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                    </div>
                                                                    <!-- /.modal -->
                                                                <?php } ?>
                                                            <?php
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
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