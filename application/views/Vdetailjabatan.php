<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0">Detail Jabatan</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"><?=$jab->jabatan?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <h4 class="lead">Kriteria</h4>
                            <div class="table-responsive" >   
                                <table class="table table-striped text-nowrap table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th><th>Kriteria Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($kriteria_jab as $kj) {
                                            if ($kj->id_jabatan == $jab->id_jabatan) {
                                        ?>
                                            <tr>
                                                <td><b><?=$kj->kriteria?></b></td>
                                                <td>
                                                    <?=$kj->nilai_kriteriaJab." ".$kj->satuan?>
                                                    <?php if($this->session->userdata('role')=='direksi') { ?>
                                                        <button type="button" class="btn btn-light btn-sm float-right" data-toggle="modal" data-target="#ed<?=$kj->id_kriteriaJab?>">
                                                            <i class="fas fa-pencil-alt"></i> 
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php if($this->session->userdata('role')=='direksi') { ?>
                                                <div class="modal fade" id="ed<?=$kj->id_kriteriaJab?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title"><i class="fas fa-pencil-alt"></i> Kriteria <?= $jab->jabatan ?></h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal" action="<?=base_url('Rekomendasi/Proses_kriteriaJB')?>" method="post">
                                                                    <input type="hidden" name="id_kJ" value="<?=encrypt_url($kj->id_kriteriaJab)?>">
                                                                    <div class="form-group row">
                                                                        <label for="kj<?=$kj->id_kriteriaJab?>" class="col-sm-4 control-label text-black"><?=$kj->kriteria?></label>
                                                                        <div class="col-sm-8">
                                                                            <?php if ($kj->satuan) { ?>
                                                                                <div class="input-group mb-3">
                                                                                    <input type="text" class="form-control form-control-border" name="nilai_kriteriaJab" id="kj<?=$kj->id_kriteriaJab?>" value="<?=$kj->nilai_kriteriaJab?>" required>
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><?=$kj->satuan?></span>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <input type="text" class="form-control form-control-border" name="nilai_kriteriaJab" value="<?=$kj->nilai_kriteriaJab?>" id="kj<?=$kj->id_kriteria?>" placeholder="<?=$kj->satuan?>">
                                                                            <?php } ?>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Filter Calon Kandidat Jabatan : </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-hover text-nowrap table-sm">
                                <tbody>
                                    <?php $n=1; 
                                    foreach ($filter as $f) {
                                        if (($f->id_jabatan == $jab->id_jabatan) && ($f->status_filter == '1')) {
                                    ?>
                                        <tr>
                                            <td><?=$n++?>.</td>
                                            <td><?=$f->nama_lengkap?></td>
                                            <td>
                                                <button type="button" class="btn bg-gradient-default btn-xs" title="Hapus Filter Jabatan" data-toggle="modal" data-target="#del<?=$f->id_filter?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="del<?=$f->id_filter?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content bg-primary">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> Hapus Calon Kandidat</h4>
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
                                    } ?>
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
                                            Jabatan : <b><?= $jab->jabatan ?></b><hr>
                                            <form action="<?=base_url('Rekomendasi/FilterKry')?>" method="post">
                                                <input type="hidden" name="idjab" value="<?=encrypt_url($jab->id_jabatan)?>>">                       
                                                <div class="form-group">
                                                    <select class="form-control select2" name="jbt" style="width: 100%;">
                                                    <option value="">- Pilih Karyawan -</option>
                                                    <?php foreach ($filnotinjab as $k) { ?>
                                                        <option value="<?=$k->id_kry?>"><?=$k->nama_lengkap?></option>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
