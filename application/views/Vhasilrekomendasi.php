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
                            <h3 class="card-title">Detail Hasil Pencarian</h3>
                            <?php if($this->session->userdata('role')=='direksi') { ?>
                                <div class="box-tools"> 
                                    <a href="<?=base_url('Rekomendasi/Cetak_Rekomendasi/'.encrypt_url($log->id_log).'/'.encrypt_url($jbt->id_jabatan))?>" class="btn btn-outline-primary btn-sm float-right" target="_blank">
                                        <i class="fa fa-print"></i> .pdf
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h4>Jabatan : <?=$jbt->jabatan?></h4>
                                    <dl class="row">
                                        <?php $nop=1; foreach ($kriteria_jab as $kj) {?>
                                                <dt class="col-sm-8"><?=$nop."."?> <?=$kj->kriteria?></dt>
                                                <dd class="col-sm-4">: <?=$kj->nilai_kriteriaJab." ".$kj->satuan?></dd>
                                        <?php
                                        $nop++;    }
                                        ?>
                                    </dl>
                                </div>
                                <div class="col-8">
                                    <h4><i class="fas fa-user-check"></i> Hasil Rekomendasi
                                        <div class="info-box shadow-md">
                                            <span class="info-box-icon bg-success"><i class="far fa-star"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-number text-center"><?=$log->nama_lengkap?></span>
                                                <span class="info-box-text lead">Similarity Tertinggi  : <b> <?=$log->nilai_max_sim?> </b></span>
                                            </div>
                                        </div>
                                    </h4>
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <td>\</td>
                                            <?php foreach ($kriteria as $k) {
                                                echo "<th>".$k->kriteria." (".$k->pembobotan.")</th>";
                                            } ?>
                                        </tr>
                                        <tr>
                                            <th>Kriteria</th>
                                            <?php foreach ($kriteria_kry as $kk) {
                                                if ($kk->id_kry == $log->id_kry) {
                                                    echo "<td>".$kk->nilai_kriteriaKry."</td>";
                                                }
                                            } ?>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <h4>Kandidat</h4>
                                    <div class="table-responsive" >   
                                        <table class="table table-hover text-nowrap table-head-fixed table-bordered table-sm" id="tbl_kry">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>NIK</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Nilai Similarity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $nop = 1; 
                                                    foreach ($kandidat as $p) { 
                                                ?>
                                                    <tr>
                                                        <td><?= $nop++ ?></td>
                                                        <td>
                                                            <p class="text-success text-center"><b><?= $p->nik ?></b></p>
                                                        </td>
                                                        <td><?= $p->nama_lengkap ?></td>
                                                        <td>
                                                            <span class="badge badge-info"><?=$p->sim?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan=4>
                                                            <table class="table table-sm table-bordered">
                                                                <tr>
                                                                    <td>\</td>
                                                                    <?php foreach ($kriteria as $k) {
                                                                        echo "<th>".$k->kriteria." (".$k->pembobotan.")</th>";
                                                                    } ?>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kriteria</th>
                                                                    <?php foreach ($kriteria_kry as $kk) {
                                                                        if ($kk->id_kry == $p->id_kry) {
                                                                            echo "<td>".$kk->nilai_kriteriaKry."</td>";
                                                                        }
                                                                    } ?>
                                                                </tr>
                                                                <tr>
                                                                    <th>Konversi</th>
                                                                        <?php foreach ($kandidat as $kd) {
                                                                            if ($kd->id_kry == $p->id_kry) {
                                                                                $konversi = json_decode($kd->konversi);
                                                                                foreach ($konversi as $key => $value) {
                                                                                    echo "<td>".$value."</td>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                </tr>
                                                                <tr>
                                                                    <th>Perbandingan</th>
                                                                        <?php foreach ($kandidat as $kd) {
                                                                            if ($kd->id_kry == $p->id_kry) {
                                                                                $perbandingan = json_decode($kd->perbandingan);
                                                                                foreach ($perbandingan as $key => $value) {
                                                                                    echo "<td>".$value."</td>";
                                                                                }
                                                                            }
                                                                        } ?>
                                                                </tr>
                                                            </table>
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
        </div>
    </div>