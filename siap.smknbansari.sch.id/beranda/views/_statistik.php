<?php

if (@$_GET['page'] == 'chart') {
    $tmb1_aktif = 'disabled';
    $tmb2_aktif = '';
} elseif (@$_GET['page'] == 'table') {
    $tmb1_aktif = '';
    $tmb2_aktif = 'disabled';
} else {
    $tmb1_aktif = '';
    $tmb2_aktif = '';
}
?>

<!-- Small boxes (Stat box) -->

<style>
    #grafik_001 .progress {
        margin-bottom: 20px;
    }

    #tabel_ijin .tabel_curva_1 {
        max-height: 400px;
        overflow: auto;
        width: 100%;
    }

    .tombol_header {
        display: flex;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    /* .tombol_header .btn-group .active {} */
</style>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-navy elevation-2">
                    <div class="card-header bg-gradient-navy rounded">
                        <div class="tombol_header">
                            <div class="btn-group">
                                <a href="?page=chart" class="btn btn-primary bg-gradient-primary elevation-2 <?= $tmb1_aktif; ?>">
                                    <!-- <i class="fas fa-chart"></i> -->
                                    <?php if ($tmb1_aktif) { ?>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    <?php } else { ?>
                                        <i class="fas fa-chart-area"></i>
                                    <?php } ?>
                                    &nbsp;
                                    Grafik
                                </a>
                                <a href="?page=table" class="btn btn-success bg-gradient-success elevation-2 <?= $tmb2_aktif; ?>">
                                    <?php if ($tmb2_aktif) { ?>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    <?php } else { ?>
                                        <i class="fas fa-table"></i>
                                    <?php } ?>
                                    &nbsp;
                                    Tabel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
date_default_timezone_set('Asia/Jakarta');
$tanggal_pilih = date('Y-m-d');

include '../config/konesi.php';

$sql_kodeinfo = mysqli_query($konek, "SELECT * FROM kodeinfo ORDER BY info ASC");
$data_kodeinfo = array();
while ($hasil_kodeinfo = mysqli_fetch_array($sql_kodeinfo)) {
    $data_kodeinfo[] = $hasil_kodeinfo;
}

$sql_kehadiran_hari_ini = mysqli_query($konek, "SELECT * FROM datapresensi WHERE tanggal = '$tanggal_pilih' AND kode <> 'GR'");
$data_kehadiran_hari_ini = array();
while ($hasil_kehadiran_hari_ini = mysqli_fetch_array($sql_kehadiran_hari_ini)) {
    $data_kehadiran_hari_ini[] = $hasil_kehadiran_hari_ini;
}

$sql_kehadiran_semua = mysqli_query($konek, "SELECT * FROM datapresensi WHERE kode <> 'GR'");
$data_kehadiran_semua = array();
while ($hasil_kehadiran_hari_ini = mysqli_fetch_array($sql_kehadiran_semua)) {
    $data_kehadiran_semua[] = $hasil_kehadiran_hari_ini;
}

$sql_kehadiran_kelas_hari_ini = mysqli_query($konek, "SELECT * FROM presensikelas WHERE tanggal = '$tanggal_pilih'");
$data_kehadiran_kelas_hari_ini = array();
while ($hasil_kehadiran_kelas = mysqli_fetch_array($sql_kehadiran_kelas_hari_ini)) {
    $data_kehadiran_kelas_hari_ini[] = $hasil_kehadiran_kelas;
}

$sql_kehadiran_kelas = mysqli_query($konek, "SELECT * FROM presensikelas");
$data_kehadiran_kelas = array();
while ($hasil_kehadiran_kelas = mysqli_fetch_array($sql_kehadiran_kelas)) {
    $data_kehadiran_kelas[] = $hasil_kehadiran_kelas;
}

$sql_datasiswa = mysqli_query($konek, "SELECT * FROM datasiswa");
$data_datasiswa = array();
while ($hasil_datasiswa = mysqli_fetch_array($sql_datasiswa)) {
    $data_datasiswa[] = $hasil_datasiswa;
}

$sql_dataguru = mysqli_query($konek, "SELECT * FROM dataguru WHERE status = 'Guru'");
$data_dataguru = array();
while ($hasil_dataguru = mysqli_fetch_array($sql_dataguru)) {
    $data_dataguru[] = $hasil_dataguru;
}

$sql_jadwalkbm = mysqli_query($konek, "SELECT * FROM jadwalkbm WHERE tanggal = '$tanggal_pilih'");
$data_jadwalkbm = array();
while ($hasil_jadwalkbm = mysqli_fetch_array($sql_jadwalkbm)) {
    $data_jadwalkbm[] = $hasil_jadwalkbm;
}

$sql_jurnalguru = mysqli_query($konek, "SELECT * FROM jurnalguru WHERE tanggal = '$tanggal_pilih'");
$data_jurnalguru = array();
while ($hasil_jurnalguru = mysqli_fetch_array($sql_jurnalguru)) {
    $data_jurnalguru[] = $hasil_jurnalguru;
}

$jml_presensi_semua = count($data_kehadiran_semua);

$_jml_semua_siswa = count($data_datasiswa);

$_jml_tercatat_hadir_gate = count($data_kehadiran_hari_ini);
$_persen_tercatat_gate = round(($_jml_tercatat_hadir / $_jml_semua_siswa) * 100, 2);

$_jml_tercatat_hadir = count($data_kehadiran_kelas_hari_ini);
$_persen_tercatat = round(($_jml_tercatat_hadir / $_jml_semua_siswa) * 100, 2);

$_semua_data_presensi_kelas = count($data_kehadiran_kelas);
if ($_semua_data_presensi_kelas >= 100) {
    $_semua_data_presensi_kelas = $_semua_data_presensi_kelas / 1000;
}

mysqli_close($konek);
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <!-- AREA CHART -->
                <div class="card card-navy">
                    <div class="card-header bg-gradient-navy">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i>
                            &nbsp;
                            Kehadiran Siswa Hari ini (%)
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div id="tabel_ijin" class="card-body">
                        <div class="">
                            <?php
                            // echo "<pre>";
                            // print_r($data_kehadiran_hari_ini);
                            // echo "</pre>";
                            ?>
                            <div class="row w-100 mb-n2 text-center">
                                <div class="col-2 mb-1">
                                    <b>
                                        KELAS
                                    </b>
                                </div>
                                <div class="col-6 my-1">
                                    <b>
                                        PROGRES KEHADIRAN (%)
                                    </b>
                                </div>
                                <div class="col-4 my-1">
                                    <b>
                                        KETERANGAN
                                    </b>
                                </div>
                            </div>
                            <?php
                            $i = 0;
                            foreach ($data_kodeinfo as $value_kodeinfo) {
                                if ($i % 2 != 0) {
                                    $bg_baris = " bg-secondary";
                                } else {
                                    $bg_baris = " bg-dark";
                                }

                                if ($i > 2) {
                                    $jur = $value_kodeinfo['jur'];

                                    if ($jur == 'AT') {
                                        $bg_bar1 = 'success';
                                    } elseif ($jur == 'DKV') {
                                        $bg_bar1 = 'primary';
                                    } elseif ($jur == 'TE') {
                                        $bg_bar1 = 'warning';
                                    } else {
                                        $bg_bar1 = 'dark';
                                    }
                            ?>
                                    <div class="row w-100 border aktif_sorot">
                                        <div class="col-2 mt-2">
                                            <h6 style="font-size: 12px;"><?= $value_kodeinfo['info']; ?></h6>
                                        </div>

                                        <?php
                                        $_data_satukelas = cari_array_($value_kodeinfo['info'], $data_datasiswa, 'kelas');
                                        $_jml_1_kelas = count($_data_satukelas);

                                        $_data_presensi_gate = cari_array_($value_kodeinfo['info'], $data_kehadiran_hari_ini, 'info');
                                        $_jml_data = count($_data_presensi_gate);
                                        $_jml_data = (int)$_jml_data * 1;

                                        $_jml_ = $_jml_data + $_jml_1_kelas;

                                        $ww = 0;
                                        $_H = 0;
                                        $_T = 0;
                                        $_I = 0;
                                        $_S = 0;
                                        $_A = 0;

                                        foreach ($_data_presensi_gate as $value_data_kehadiran) {
                                            $__hdir = $_data_presensi_gate[$ww]['ketmasuk'];
                                            $_data_hadir[] = $__hdir;

                                            // echo "$__hdir<br>";

                                            if ($__hdir == 'On Time') {
                                                $_H++;
                                            } elseif ($__hdir == 'Terlambat') {
                                                $_T++;
                                            } elseif ($__hdir == 'Ijin') {
                                                $_I++;
                                            } elseif ($__hdir == 'Sakit') {
                                                $_S++;
                                            } else {
                                                $_A++;
                                            }

                                            $__hdir = "";
                                            $ww++;
                                        }

                                        if ($_jml_data > 0) {
                                            // $_persen_H = round($_H / $_jml_data * 100, 2);
                                            $_persen_H = round(($_H * 100) / $_jml_);
                                            $_persen_T = round(($_T * 100) / $_jml_);
                                            $_persen_I = round(($_I * 100) / $_jml_);
                                            $_persen_S = round(($_S * 100) / $_jml_);
                                            $_persen_A = round(($_A * 100) / $_jml_);

                                            $_persen_IS = $_persen_I + $_persen_S;
                                        } else {
                                            $_persen_H = 0;
                                            $_persen_T = 0;
                                            $_persen_I = 0;
                                            $_persen_S = 0;
                                            $_persen_A = 0;
                                            $_persen_IS = 0;
                                        }

                                        $_jml_persen_ = $_persen_H + $_persen_T + $_persen_I + $_persen_S + $_persen_A;
                                        ?>

                                        <div class="col-6 mt-2 mb-1">
                                            <div class="progress border">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= @$_persen_H; ?>%" aria-valuenow="<?= @$_persen_H; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <?= @$_persen_H; ?>
                                                </div>
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= @$_persen_T; ?>%" aria-valuenow="<?= @$_persen_T; ?>" aria-valuemin="0" aria-valuemax="0"><?= @$_persen_T; ?></div>
                                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= @$_persen_IS; ?>%" aria-valuenow="<?= @$_persen_IS; ?>" aria-valuemin="0" aria-valuemax="100"><?= @$_persen_IS; ?></div>
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= @$_persen_A; ?>%" aria-valuenow="<?= @$_persen_A; ?>" aria-valuemin="0" aria-valuemax="0"><?= @$_persen_A; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-4 my-1" style="font-size: 11px;">
                                            <span class="badge bg-black text-bg-light">
                                                <?= $_jml_persen_; ?>&nbsp;%
                                            </span>
                                            (<?= $_jml_data; ?>/<?= $_jml_1_kelas; ?>)
                                            <?php
                                            $jml_A = $_jml_1_kelas - $_jml_data;
                                            ?>
                                            <span class="badge badge-success"><?= $_H; ?></span>
                                            <span class="badge badge-warning"><?= $_T; ?></span>
                                            <span class="badge badge-info"><?= ($_S + $_I); ?></span>
                                            <span class="badge badge-danger"><?= $jml_A; ?></span>
                                        </div>
                                    </div>
                            <?php }
                                $i++;
                            } ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div style="font-size: 11px; font-style: italic;">
                                Data masuk:&nbsp;<?= $_jml_tercatat_hadir_gate; ?>&nbsp;/&nbsp;<?= $_jml_semua_siswa; ?>&nbsp;(<?= $_persen_tercatat_gate; ?>&nbsp;%)
                            </div>
                            <div>
                                <a href="#" class="btn btn-outline-secondary btn-sm float-md-right">
                                    <i class="fas fa-info"></i>
                                    &nbsp;
                                    Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- AREA CHART -->
                <div class="card card-navy">
                    <div class="card-header bg-gradient-navy">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            &nbsp;
                            Info
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <?php
                    // data 1 hari presensi
                    $_data_presensi_kelas = cari_array_orderby($data_kehadiran_hari_ini, 'status');
                    $_jml_data = count($_data_presensi_kelas);
                    $_jml_data = (int)$_jml_data * 1;

                    $_jml_ = $_jml_data + $_jml_1_kelas;

                    $_data_hadir = array();
                    $jj = 0;
                    $_H = 0;
                    $_T = 0;
                    $_I = 0;
                    $_S = 0;
                    $_A = 0;

                    foreach ($_data_presensi_kelas as $value_data_kehadiran) {
                        $__hdir = $_data_presensi_kelas[$jj]['ketmasuk'];
                        $_data_hadir[] = $__hdir;

                        if ($__hdir == 'On Time') {
                            $_H++;
                        } elseif ($__hdir == 'Terlambat') {
                            $_T++;
                        } elseif ($__hdir == 'Ijin') {
                            $_I++;
                        } elseif ($__hdir == 'Sakit') {
                            $_S++;
                        } else {
                            $_A++;
                        }

                        $jj++;
                    }

                    if ($_jml_data > 0) {
                        // $_persen_H = round($_H / $_jml_data * 100, 2);
                        $_persen_H = round(($_H * 100) / $_jml_semua_siswa);
                        $_persen_T = round(($_T * 100) / $_jml_semua_siswa);
                        $_persen_I = round(($_I * 100) / $_jml_semua_siswa);
                        $_persen_S = round(($_S * 100) / $_jml_semua_siswa);
                        $_persen_A = round(($_A * 100) / $_jml_semua_siswa);

                        $_persen_IS = $_persen_I + $_persen_S;
                        // echo "_persen_H: " . $_persen_H . "<br>";
                        // echo "H: " . $_H . "<br>";
                        // echo "T: " . $_T . "<br>";
                        // echo "I: " . $_I . "<br>";
                        // echo "S: " . $_S . "<br>";
                        // echo "A: " . $_A . "<br>";
                        // echo $_jml_data . "<pre>";
                        // print_r($_data_hadir);
                        // echo "</pre>";
                    } else {
                        $_persen_H = 0;
                        $_persen_T = 0;
                        $_persen_I = 0;
                        $_persen_S = 0;
                        $_persen_A = 0;
                        $_persen_IS = 0;
                    }

                    ?>

                    <div id="tabel_ijin" class="card-body">
                        <h6>Kehadiran hari ini</h6>
                        <div class="tabel_curva_1">
                            <div class="d-flex flex-wrap">
                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_H; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#00a65a" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Hadir</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_T; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#ffaf00" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Terlambat</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_I; ?>" data-skin="tron" data-thickness="0.2" data-angleOffset="0" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#00c0ef" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Ijin</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_S; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#3c8dbc" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Sakit</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_A; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#f56954" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Alpa</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_tercatat; ?>" data-skin="tron" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125" data-width="73" data-height="73" data-fgColor="#00011F" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">% Kehadiran Tercatat</div>
                                </div>

                            </div>
                        </div>
                        <hr>

                        <?php
                        // data 1 hari presensi
                        $_data_presensi_kelas = cari_array_orderby($data_kehadiran_semua, 'status');
                        $_jml_data = count($_data_presensi_kelas);
                        $_jml_data = (int)$_jml_data * 1;

                        $_jml_ = $_jml_data + $_jml_1_kelas;

                        $_data_hadir = array();
                        $jj = 0;
                        $_H = 0;
                        $_T = 0;
                        $_I = 0;
                        $_S = 0;
                        $_A = 0;

                        foreach ($_data_presensi_kelas as $value_data_kehadiran) {
                            $__hdir = $_data_presensi_kelas[$jj]['ketmasuk'];
                            $_data_hadir[] = $__hdir;

                            if ($__hdir == 'On Time') {
                                $_H++;
                            } elseif ($__hdir == 'Terlambat') {
                                $_T++;
                            } elseif ($__hdir == 'Ijin') {
                                $_I++;
                            } elseif ($__hdir == 'Sakit') {
                                $_S++;
                            } else {
                                $_A++;
                            }

                            $jj++;
                        }

                        if ($_jml_data > 0) {
                            // $_persen_H = round($_H / $_jml_data * 100, 2);
                            $_persen_H = round(($_H * 100) / $jml_presensi_semua);
                            $_persen_T = round(($_T * 100) / $jml_presensi_semua);
                            $_persen_I = round(($_I * 100) / $jml_presensi_semua);
                            $_persen_S = round(($_S * 100) / $jml_presensi_semua);
                            $_persen_A = round(($_A * 100) / $jml_presensi_semua);

                            $_persen_IS = $_persen_I + $_persen_S;
                            // echo "_persen_H: " . $_persen_H . "<br>";
                            // echo "H: " . $_H . "<br>";
                            // echo "T: " . $_T . "<br>";
                            // echo "I: " . $_I . "<br>";
                            // echo "S: " . $_S . "<br>";
                            // echo "A: " . $_A . "<br>";
                            // echo $_jml_data . "<pre>";
                            // print_r($_data_hadir);
                            // echo "</pre>";
                        } else {
                            $_persen_H = 0;
                            $_persen_T = 0;
                            $_persen_I = 0;
                            $_persen_S = 0;
                            $_persen_A = 0;
                            $_persen_IS = 0;
                        }

                        ?>
                        <h6>Seluruh Kehadiran</h6>
                        <div class="tabel_curva_1">
                            <div class="d-flex flex-wrap">
                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_H; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#00a65a" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Hadir</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_T; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#ffaf00" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Terlambat</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_I; ?>" data-skin="tron" data-thickness="0.2" data-angleOffset="0" data-width="73" data-height="73" data-angleArc="300" data-readonly="true" data-fgColor="#00c0ef">

                                    <div class="knob-label mt-n2 mb-2">Ijin</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_S; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#3c8dbc" data-angleArc="300" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Sakit</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_A; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#f56954" data-angleArc="300" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Alpa</div>
                                </div>

                                <div class="col-6 text-center">
                                    <input type="text" class="knob" value="<?= $_semua_data_presensi_kelas; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#011151" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Data Tercatat (K)</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="#" class="btn btn-outline-secondary btn-sm float-md-right">
                            <i class="fas fa-info"></i>
                            &nbsp;
                            Selengkapnya
                        </a>
                    </div>
                    <!-- /. card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <!-- AREA CHART -->
                <div class="card card-navy">
                    <div class="card-header bg-gradient-navy">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i>
                            &nbsp;
                            Kehadiran Siswa di Kelas Hari ini (%)
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div id="tabel_ijin" class="card-body">
                        <div class="">

                            <?php
                            $i = 0;
                            foreach ($data_kodeinfo as $value_kodeinfo) {
                                if ($i > 2) {
                                    $jur = $value_kodeinfo['jur'];

                                    if ($jur == 'AT') {
                                        $bg_bar1 = 'success';
                                    } elseif ($jur == 'DKV') {
                                        $bg_bar1 = 'primary';
                                    } elseif ($jur == 'TE') {
                                        $bg_bar1 = 'warning';
                                    } else {
                                        $bg_bar1 = 'dark';
                                    }
                            ?>
                                    <div class="row w-100 mb-n2">
                                        <div class="col-2 mb-0">
                                            <h6 style="font-size: 12px;"><?= $value_kodeinfo['info']; ?></h6>
                                        </div>

                                        <?php
                                        // data 1 kelas
                                        $_data_satukelas = cari_array_($value_kodeinfo['info'], $data_datasiswa, 'kelas');
                                        $_jml_1_kelas = count($_data_satukelas);

                                        $_data_presensi_kelas = cari_array_($value_kodeinfo['info'], $data_kehadiran_kelas_hari_ini, 'kelas');
                                        $_jml_data = count($_data_presensi_kelas);
                                        $_jml_data = (int)$_jml_data * 1;

                                        $_jml_ = $_jml_data + $_jml_1_kelas;

                                        $_data_hadir = array();
                                        $jj = 0;
                                        $_H = 0;
                                        $_T = 0;
                                        $_I = 0;
                                        $_S = 0;
                                        $_A = 0;

                                        foreach ($_data_presensi_kelas as $value_data_kehadiran) {
                                            $__hdir = $_data_presensi_kelas[$jj]['status'];
                                            $_data_hadir[] = $__hdir;

                                            if ($__hdir == 'H') {
                                                $_H++;
                                            } elseif ($__hdir == 'T') {
                                                $_T++;
                                            } elseif ($__hdir == 'I') {
                                                $_I++;
                                            } elseif ($__hdir == 'S') {
                                                $_S++;
                                            } elseif ($__hdir == 'A') {
                                                $_A++;
                                            }

                                            $jj++;
                                        }

                                        if ($_jml_data > 0) {
                                            // $_persen_H = round($_H / $_jml_data * 100, 2);
                                            $_persen_H = round(($_H * 100) / $_jml_);
                                            $_persen_T = round(($_T * 100) / $_jml_);
                                            $_persen_I = round(($_I * 100) / $_jml_);
                                            $_persen_S = round(($_S * 100) / $_jml_);
                                            $_persen_A = round(($_A * 100) / $_jml_);

                                            $_persen_IS = $_persen_I + $_persen_S;
                                            // echo "_persen_H: " . $_persen_H . "<br>";
                                            // echo "H: " . $_H . "<br>";
                                            // echo "T: " . $_T . "<br>";
                                            // echo "I: " . $_I . "<br>";
                                            // echo "S: " . $_S . "<br>";
                                            // echo "A: " . $_A . "<br>";
                                            // echo $_jml_data . "<pre>";
                                            // print_r($_data_hadir);
                                            // echo "</pre>";
                                        } else {
                                            $_persen_H = 0;
                                            $_persen_T = 0;
                                            $_persen_I = 0;
                                            $_persen_S = 0;
                                            $_persen_A = 0;
                                            $_persen_IS = 0;
                                        }

                                        $_jml_persen_ = $_persen_H + $_persen_T + $_persen_I + $_persen_S + $_persen_A;
                                        ?>

                                        <div class="col-8 my-0">
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $_persen_H; ?>%" aria-valuenow="<?= $_persen_H; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <?= $_persen_H; ?>
                                                </div>
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $_persen_T; ?>%" aria-valuenow="<?= $_persen_T; ?>" aria-valuemin="0" aria-valuemax="0"><?= $_persen_T; ?></div>
                                                <div class="progress-bar bg-info" role="progressbar" style="width: <?= $_persen_IS; ?>%" aria-valuenow="<?= $_persen_IS; ?>" aria-valuemin="0" aria-valuemax="100"><?= $_persen_IS; ?></div>
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $_persen_A; ?>%" aria-valuenow="<?= $_persen_A; ?>" aria-valuemin="0" aria-valuemax="0"><?= $_persen_A; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-2 my-1" style="font-size: 11px;">
                                            <?= $_jml_persen_; ?>&nbsp;%
                                        </div>
                                    </div>
                            <?php }
                                $i++;
                            } ?>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div style="font-size: 11px; font-style: italic;">
                                Data masuk:&nbsp;<?= $_jml_tercatat_hadir; ?>&nbsp;/&nbsp;<?= $_jml_semua_siswa; ?>&nbsp;(<?= $_persen_tercatat; ?>&nbsp;%)
                            </div>
                            <div>
                                <a href="#" class="btn btn-outline-secondary btn-sm float-md-right">
                                    <i class="fas fa-info"></i>
                                    &nbsp;
                                    Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /. card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col (LEFT) -->

            <div class="col-md-5">
                <!-- AREA CHART -->
                <div class="card card-navy">
                    <div class="card-header bg-gradient-navy">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            &nbsp;
                            Info Kehadiran
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <?php
                    // data 1 hari presensi
                    $_data_presensi_kelas = cari_array_orderby($data_kehadiran_kelas_hari_ini, 'status');
                    $_jml_data = count($_data_presensi_kelas);
                    $_jml_data = (int)$_jml_data * 1;

                    $_jml_ = $_jml_data + $_jml_1_kelas;

                    $_data_hadir = array();
                    $jj = 0;
                    $_H = 0;
                    $_T = 0;
                    $_I = 0;
                    $_S = 0;
                    $_A = 0;

                    foreach ($_data_presensi_kelas as $value_data_kehadiran) {
                        $__hdir = $_data_presensi_kelas[$jj]['status'];
                        $_data_hadir[] = $__hdir;

                        if ($__hdir == 'H') {
                            $_H++;
                        } elseif ($__hdir == 'T') {
                            $_T++;
                        } elseif ($__hdir == 'I') {
                            $_I++;
                        } elseif ($__hdir == 'S') {
                            $_S++;
                        } elseif ($__hdir == 'A') {
                            $_A++;
                        }

                        $jj++;
                    }

                    if ($_jml_data > 0) {
                        // $_persen_H = round($_H / $_jml_data * 100, 2);
                        $_persen_H = round(($_H * 100) / $_jml_);
                        $_persen_T = round(($_T * 100) / $_jml_);
                        $_persen_I = round(($_I * 100) / $_jml_);
                        $_persen_S = round(($_S * 100) / $_jml_);
                        $_persen_A = round(($_A * 100) / $_jml_);

                        $_persen_IS = $_persen_I + $_persen_S;
                        // echo "_persen_H: " . $_persen_H . "<br>";
                        // echo "H: " . $_H . "<br>";
                        // echo "T: " . $_T . "<br>";
                        // echo "I: " . $_I . "<br>";
                        // echo "S: " . $_S . "<br>";
                        // echo "A: " . $_A . "<br>";
                        // echo $_jml_data . "<pre>";
                        // print_r($_data_hadir);
                        // echo "</pre>";
                    } else {
                        $_persen_H = 0;
                        $_persen_T = 0;
                        $_persen_I = 0;
                        $_persen_S = 0;
                        $_persen_A = 0;
                        $_persen_IS = 0;
                    }

                    ?>

                    <div id="tabel_ijin" class="card-body">
                        <h6>Kehadiran hari ini</h6>
                        <div class="tabel_curva_1">
                            <div class="d-flex flex-wrap">
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_H; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#00a65a" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Hadir</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_I; ?>" data-skin="tron" data-thickness="0.2" data-angleOffset="0" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#00c0ef" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Ijin</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_S; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#3c8dbc" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Sakit</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_A; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#f56954" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Alpa</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_tercatat; ?>" data-skin="tron" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125" data-width="73" data-height="73" data-fgColor="#00011F" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">% Kehadiran Tercatat</div>
                                </div>

                            </div>
                        </div>
                        <hr>

                        <?php
                        // data 1 hari presensi
                        $_data_presensi_kelas = cari_array_orderby($data_kehadiran_kelas, 'status');
                        $_jml_data = count($_data_presensi_kelas);
                        $_jml_data = (int)$_jml_data * 1;

                        $_jml_ = $_jml_data + $_jml_1_kelas;

                        $_data_hadir = array();
                        $jj = 0;
                        $_H = 0;
                        $_T = 0;
                        $_I = 0;
                        $_S = 0;
                        $_A = 0;

                        foreach ($_data_presensi_kelas as $value_data_kehadiran) {
                            $__hdir = $_data_presensi_kelas[$jj]['status'];
                            $_data_hadir[] = $__hdir;

                            if ($__hdir == 'H') {
                                $_H++;
                            } elseif ($__hdir == 'T') {
                                $_T++;
                            } elseif ($__hdir == 'I') {
                                $_I++;
                            } elseif ($__hdir == 'S') {
                                $_S++;
                            } elseif ($__hdir == 'A') {
                                $_A++;
                            }

                            $jj++;
                        }

                        if ($_jml_data > 0) {
                            // $_persen_H = round($_H / $_jml_data * 100, 2);
                            $_persen_H = round(($_H * 100) / $_jml_);
                            $_persen_T = round(($_T * 100) / $_jml_);
                            $_persen_I = round(($_I * 100) / $_jml_);
                            $_persen_S = round(($_S * 100) / $_jml_);
                            $_persen_A = round(($_A * 100) / $_jml_);

                            $_persen_IS = $_persen_I + $_persen_S;
                            // echo "_persen_H: " . $_persen_H . "<br>";
                            // echo "H: " . $_H . "<br>";
                            // echo "T: " . $_T . "<br>";
                            // echo "I: " . $_I . "<br>";
                            // echo "S: " . $_S . "<br>";
                            // echo "A: " . $_A . "<br>";
                            // echo $_jml_data . "<pre>";
                            // print_r($_data_hadir);
                            // echo "</pre>";
                        } else {
                            $_persen_H = 0;
                            $_persen_T = 0;
                            $_persen_I = 0;
                            $_persen_S = 0;
                            $_persen_A = 0;
                            $_persen_IS = 0;
                        }

                        ?>
                        <h6>Seluruh Kehadiran</h6>
                        <div class="tabel_curva_1">
                            <div class="d-flex flex-wrap">
                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_H; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-angleArc="300" data-fgColor="#00a65a" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Hadir</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_I; ?>" data-skin="tron" data-thickness="0.2" data-angleOffset="0" data-width="73" data-height="73" data-angleArc="300" data-readonly="true" data-fgColor="#00c0ef">

                                    <div class="knob-label mt-n2 mb-2">Ijin</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_S; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#3c8dbc" data-angleArc="300" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Sakit</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_persen_A; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#f56954" data-angleArc="300" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Alpa</div>
                                </div>

                                <div class="col-4 text-center">
                                    <input type="text" class="knob" value="<?= $_semua_data_presensi_kelas; ?>" data-skin="tron" data-thickness="0.2" data-width="73" data-height="73" data-fgColor="#011151" data-readonly="true">

                                    <div class="knob-label mt-n2 mb-2">Data Tercatat (K)</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="#" class="btn btn-outline-secondary btn-sm float-md-right">
                            <i class="fas fa-info"></i>
                            &nbsp;
                            Selengkapnya
                        </a>
                    </div>
                    <!-- /. card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-navy">
                    <div class="card-header bg-gradient-navy">
                        <h3 class="card-title">Status kelas</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="chart col-5 shadow rounded">
                                <h3 class="text-center">NA</h3>
                                <div class="d-flex flex-wrap d-grid gap-1">
                                    <?php for ($i = 0; $i < 16; $i++) { ?>
                                        <div class="d-flex bg-light shadow rounded p-2 m-auto gap-1">
                                            <div class="bg-info p-2 m-auto rounded">R <?= $i + 3; ?></div>
                                            <div class="bg-danger p-2 m-auto rounded">Status</div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="d-flex flex-column col-7 shadow rounded">
                                <div class="chart pb-3 shadow rounded">
                                    <h3 class="text-center">AT</h3>
                                    <div class="d-flex flex-wrap d-grid gap-1">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <div class="d-flex bg-light shadow rounded p-2 m-auto gap-1">
                                                <div class="bg-info p-2 m-auto rounded">Lab <?= $i + 1; ?></div>
                                                <div class="bg-danger p-2 m-auto rounded">Status</div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="chart pb-3 shadow rounded">
                                    <h3 class="text-center">DKV</h3>
                                    <div class="d-flex flex-wrap d-grid gap-1">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <div class="d-flex bg-light shadow rounded p-2 m-auto gap-1">
                                                <div class="bg-info p-2 m-auto rounded">Lab <?= $i + 1; ?></div>
                                                <div class="bg-danger p-2 m-auto rounded">Status</div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="chart pb-3 shadow rounded">
                                    <h3 class="text-center">TE</h3>
                                    <div class="d-flex flex-wrap d-grid gap-1">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <div class="d-flex bg-light shadow rounded p-2 m-auto gap-1">
                                                <div class="bg-info p-2 m-auto rounded">Lab <?= $i + 1; ?></div>
                                                <div class="bg-danger p-2 m-auto rounded">Status</div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-navy">
                    <div class="card-header bg-gradient-navy">
                        <h3 class="card-title">Jadwal Kelas</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <?php
                                foreach ($data_dataguru as $value_guru) {
                                    $nick_guru = $value_guru['nick'];
                                    $nama_guru = $value_guru['nama'];
                                ?>
                                    <tr>
                                        <td><?= $nama_guru; ?></td>
                                        <td>
                                            <?php
                                            $data_guru_di_kbm = cari_array_($nick_guru, $data_jadwalkbm, 'nick');
                                            if ($data_guru_di_kbm) {
                                                $jml_dat = count($data_guru_di_kbm);

                                                for ($i = 0; $i < $jml_dat; $i++) {
                                                    echo '<div class="d-flex d-grid gap-1">';

                                                    echo "<div class='badge badge-secondary'>" .  $i + 1 . ". </div>";

                                                    $mulai_jamke = $data_guru_di_kbm[$i]['mulai_jamke'];
                                                    $sampai_jamke = $data_guru_di_kbm[$i]['sampai_jamke'];
                                                    $ruangan = $data_guru_di_kbm[$i]['ruangan'];
                                                    $kelas = $data_guru_di_kbm[$i]['kelas'];
                                                    $info = $data_guru_di_kbm[$i]['info'];

                                                    echo "<div class='badge badge-dark'>" . $mulai_jamke . ' - ' . $sampai_jamke . "</div>";
                                                    echo "<div class='badge badge-danger'>" . $ruangan . "</div>";
                                                    echo "<div class='badge badge-warning'>" . $kelas . "</div>";
                                                    echo "<div class='badge badge-success'>" . $info . "</div>";

                                                    echo "</div>";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $_data_jurnal = cari_array_($nick_guru, $data_jurnalguru, 'nick');
                                            if ($_data_jurnal) {
                                                // $jml_dat = count($_data_jurnal);

                                                for ($i = 0; $i < count($data_jurnalguru); $i++) {
                                                    $jurnal = $data_jurnalguru[$i]['jurnal'];
                                                    echo $i + 1 . '. ' . $jurnal . '<br>';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
</section>
<!-- /.content -->

<style>
    .grafik_progress_vertikal {
        height: 380px;
    }

    .grafik_progress_vertikal .progress {
        height: 80%;
    }

    .grafik_progress_vertikal .label_progres {
        /* vertikal degree */
        -webkit-transform: rotate(60deg);
        -moz-transform: rotate(60deg);
        -ms-transform: rotate(60deg);
        -o-transform: rotate(60deg);
        transform: rotate(60deg);
    }

    .grafik_progress_vertikal .div_label {
        /* background-color: aqua; */
        margin-top: 20px;
        color: darkgray;
    }
</style>

<?php

function cari_array_($_data_dicari, $_data_hasil_array, $_index_array)
{
    $_hasil_cari_array_ = array();
    foreach ($_data_hasil_array as $_value) {
        if ($_value[$_index_array] == $_data_dicari) {
            $_hasil_cari_array_[] = $_value;
        }
    }
    return $_hasil_cari_array_;
}

function cari_array_orderby($_data_hasil_array, $_index_array)
{
    $_hasil_cari_array_ = array();
    foreach ($_data_hasil_array as $_value) {
        $_hasil_cari_array_[] = $_value;
    }
    return $_hasil_cari_array_;
}

function cari_tanggal($tanggal_pilih, $_array)
{
    $hasil_cari_tanggal = array();
    foreach ($_array as $dtp) {
        if ($dtp['tanggal'] == $tanggal_pilih) {
            $hasil_cari_tanggal[] = $dtp;
        }
    }
    return $hasil_cari_tanggal;
}
?>

<script>
    $(function() {
        /* jQueryKnob */

        $('.knob').knob({
            /*change : function (value) {
             //console.log("change : " + value);
             },
             release : function (value) {
             console.log("release : " + value);
             },
             cancel : function () {
             console.log("cancel : " + this.value);
             },*/
            draw: function() {

                // "tron" case
                if (this.$.data('skin') == 'tron') {

                    var a = this.angle(this.cv) // Angle
                        ,
                        sa = this.startAngle // Previous start angle
                        ,
                        sat = this.startAngle // Start angle
                        ,
                        ea // Previous end angle
                        ,
                        eat = sat + a // End angle
                        ,
                        r = true

                    this.g.lineWidth = this.lineWidth

                    this.o.cursor &&
                        (sat = eat - 0.3) &&
                        (eat = eat + 0.3)

                    if (this.o.displayPrevious) {
                        ea = this.startAngle + this.angle(this.value)
                        this.o.cursor &&
                            (sa = ea - 0.3) &&
                            (ea = ea + 0.3)
                        this.g.beginPath()
                        this.g.strokeStyle = this.previousColor
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
                        this.g.stroke()
                    }

                    this.g.beginPath()
                    this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
                    this.g.stroke()

                    this.g.lineWidth = 2
                    this.g.beginPath()
                    this.g.strokeStyle = this.o.fgColor
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
                    this.g.stroke()

                    return false
                }
            }
        })
        /* END JQUERY KNOB */

        //INITIALIZE SPARKLINE CHARTS
        var sparkline1 = new Sparkline($('#sparkline-1')[0], {
            width: 240,
            height: 70,
            lineColor: '#92c1dc',
            endColor: '#92c1dc'
        })
        var sparkline2 = new Sparkline($('#sparkline-2')[0], {
            width: 240,
            height: 70,
            lineColor: '#f56954',
            endColor: '#f56954'
        })
        var sparkline3 = new Sparkline($('#sparkline-3')[0], {
            width: 240,
            height: 70,
            lineColor: '#3af221',
            endColor: '#3af221'
        })

        sparkline1.draw([1000, 1200, 920, 927, 931, 1027, 819, 930, 1021])
        sparkline2.draw([515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921])
        sparkline3.draw([15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21])

    })
</script>

<style>
    .aktif_sorot:hover {
        background-color: var(--bs-secondary);
        color: aliceblue;
    }
</style>