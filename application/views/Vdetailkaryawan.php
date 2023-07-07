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
                <div class="col-md-6">
                    <div class="card card-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header text-white"
                            style="background: url('../../assets/img/podium.jpg') center center;">
                            <h3 class="widget-user-username text-right"><b><?=$det->nama_lengkap?></b></h3>
                            <h5 class="widget-user-desc text-right"><?=$det->nik?></h5>
                        </div>
                    </div>
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Kriteria Karyawan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php 
                                if ($kriteria_kry) {
                            ?>

                            <table class="table table-hover text-nowrap table-sm">
                                <tbody>
                                    <?php
                                        foreach ($kriteria_kry as $kk) {
                                    ?>
                                        <tr>
                                            <th><?=$kk->kriteria?></th>
                                            <th>:</th>
                                            <td><?=$kk->nilai_kriteriaKry." ".$kk->satuan?></td>
                                            <td>
                                                <button type="button" class="btn bg-gradient-default btn-xs" data-toggle="modal" data-target="#edKK<?=$kk->id_kriteriaKry?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                            <div class="modal fade" id="edKK<?=$kk->id_kriteriaKry?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> Ubah Data Kriteria</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Nama : <b><?= $det->nama_lengkap ?></b><hr>
                                                            <form class="form-horizontal" action="<?=base_url('KriteriaKry')?>" method="post">
                                                                <input type="hidden" name="process" value="edit">
                                                                <input type="hidden" name="idkry" value="<?=encrypt_url($det->id_kry)?>" />
                                                                <input type="hidden" name="idkk" value="<?=encrypt_url($kk->id_kriteriaKry)?>>"> 
                                                                <input type="hidden" name="idk" value="<?=encrypt_url($kk->id_kriteria)?>>"> 
                                                                <div class="form-group row">
                                                                    <label for="kk<?=$kk->id_kriteriaKry?>" class="col-sm-4 control-label text-black"><?=$kk->kriteria?></label>
                                                                    <div class="col-sm-8">
                                                                        <?php if ($kk->satuan) { ?>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" class="form-control form-control-border" name="nilai_kriteriaKry" id="kk<?=$kk->id_kriteriaKry?>" value="<?=$kk->nilai_kriteriaKry?>" required>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text"><?=$kk->satuan?></span>
                                                                                </div>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <input type="text" class="form-control form-control-border" name="nilai_kriteriaKry" value="<?=$kk->nilai_kriteriaKry?>" id="kk<?=$kk->id_kriteriaKry?>" placeholder="<?=$kk->satuan?>">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <?php
                                } else { 
                            ?>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addKriteriaKry">
                                    <i class="fas fa-pencil-alt"></i> Isi Kriteria
                                </button>
                                <div class="modal fade" id="addKriteriaKry">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Kriteria Karyawan</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Nama : <b><?= $det->nama_lengkap ?></b><hr>
                                                <form class="form-horizontal" action="<?=base_url('KriteriaKry')?>" method="post">
                                                    <input type="hidden" name="process" value="add">
                                                    <input type="hidden" name="idkry" value="<?=encrypt_url($det->id_kry)?>" />
                                                    <?php foreach ($kriteria as $k) { ?>
                                                        <input type="hidden" name="id_kriteria[]" value="<?=encrypt_url($k->id_kriteria)?>" />
                                                        
                                                        <div class="form-group row">
                                                            <label for="kk<?=$k->id_kriteria?>" class="col-sm-4 control-label text-black"><?=$k->kriteria?></label>
                                                            <div class="col-sm-8">
                                                                <?php if ($k->satuan) { ?>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control" name="nilai_kriteriaKry[]" id="kk<?=$k->id_kriteria?>" required>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><?=$k->satuan?></span>
                                                                    </div>
                                                                </div>
                                                                <?php } else { ?>
                                                                <input type="text" class="form-control" name="nilai_kriteriaKry[]" id="kk<?=$k->id_kriteria?>" placeholder="<?=$k->satuan?>" required>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    
                                                    <button type="submit" class="btn btn-primary btn-sm float-right "><i class="fa fa-save"></i> SIMPAN</button>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Calon Kandidat Jabatan Sebagai : </h3>
                        </div>
                        <!-- /.card-header -->
                        <?php if ($kriteria_kry) { ?>
                            <div class="card-body">
                                <table class="table table-hover text-nowrap table-sm">
                                    <tbody>
                                        <?php $n=1; foreach ($jabatan as $j) { 
                                        foreach ($filter as $f) {
                                            if (($f->id_jabatan == $j->id_jabatan) && ($f->status_filter == '1')) {
                                        ?>
                                            <tr>
                                                <td><?=$n++?>.</td>
                                                <td><?=$j->jabatan?></td>
                                                <td>
                                                    <button type="button" class="btn bg-gradient-default btn-xs" title="Hapus Filter Jabatan" data-toggle="modal" data-target="#del<?=$f->id_filter?>"><i class="fas fa-trash-alt"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="del<?=$f->id_filter?>">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content bg-primary">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> Hapus Filter Jabatan</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Nama : <b><?= $det->nama_lengkap ?></b><hr>
                                                            <form action="<?=base_url('CancelFilterKry')?>" method="post">
                                                                <input type="hidden" name="idf" value="<?=encrypt_url($f->id_filter)?>>"> 
                                                                <h4>Apakah Anda yakin menghapus filter jabatan <?=$j->jabatan?> ini?</h4>
                                                                <button type="submit" class="btn btn-light float-right"><i class="fa fa-save"></i> IYA</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        } } ?>
                                    </tbody>
                                </table>     
                            </div>
                            <div class="card-footer">                           
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFilter">
                                    <i class="fas fa-pencil-alt"></i> Tambah Filter Jabatan
                                </button>
                                <div class="modal fade" id="addFilter">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"> Filter Jabatan</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Nama : <b><?= $det->nama_lengkap ?></b><hr>
                                                <form action="<?=base_url('Rekomendasi/FilterKry')?>" method="post">
                                                    <input type="hidden" name="idkry" value="<?=encrypt_url($det->id_kry)?>>">                       
                                                    <div class="form-group">
                                                        <select class="form-control" name="jbt" style="width: 100%;">
                                                        <option value="">- Pilih Jabatan -</option>
                                                        <?php foreach ($filnotinjab as $k) { ?>
                                                            <option value="<?=$k->id_jabatan?>"><?=$k->jabatan?></option>
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SIMPAN</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card-body">
                                <p class="lead">Kandidat akan muncul setelah Kriteria sudah diisi oleh Admin.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>