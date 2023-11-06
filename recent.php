<?php
ini_set('session.cookie_lifetime', 2000000);
session_start();
include "config/konesi.php";
//baca tanggal saat ini
date_default_timezone_set('Asia/Jakarta');
$tanggal = date('Y-m-d');

if (@$_SESSION['tampilanriwayat']) {
    $tampilhari = $_SESSION['tampilhaririwayat'];
    $tampilket = $_SESSION['tampilketriwayat'];
    $tampiljlm = $_SESSION['tampiljmlriwayat'];
    // unset($_SESSION['tampilhaririwayat']);
    // unset($_SESSION['tampilketriwayat']);
    // unset($_SESSION['tampiljlmriwayat']);

    if ($tampilhari == "0") {
        $kethari = "Hari ini";
        $pilih = "WHERE tanggal = '$tanggal'";
    } elseif ($tampilhari == "1") {
        $tanggal = date('Y-m-d', strtotime('-1 days'));
        $kethari = "Kemarin";
        $pilih = "WHERE tanggal = '$tanggal'";
    } elseif ($tampilhari == "2") {
        $tanggal = date('Y-m-d', strtotime('-2 days'));
        $kethari = "Dua Hari Yang Lalu";
        $pilih = "WHERE tanggal = '$tanggal'";
    } elseif ($tampilhari == "3") {
        $tanggal = date('Y-m-d', strtotime('-3 days'));
        $kethari = "Tiga Hari Yang Lalu";
        $pilih = "WHERE tanggal = '$tanggal'";
    } elseif ($tampilhari == "4") {
        $tanggal = date('Y-m-d', strtotime('-4 days'));
        $kethari = "Empat Hari Yang Lalu";
        $pilih = "WHERE tanggal = '$tanggal'";
    } elseif ($tampilhari == "5") {
        $tanggal = date('Y-m-d', strtotime('-7 days'));
        $kethari = "Minggu Ini";
        $pilih = "WHERE tanggal = '$tanggal'";
    } elseif ($tampilhari == "6") {
        $tanggal = "";
        $kethari = "Semua";
        $pilih = " WHERE keterangan IS NOT NULL ";
    }

    if ($tampilket == "semua") {
        $pilih = $pilih;
    } elseif ($tampilket == "masuk") {
        $pilih = $pilih . " AND ketmasuk IS NOT NULL ";
    } elseif ($tampilket == "pulang") {
        $pilih = $pilih . " AND ketpulang IS NOT NULL ";
    } elseif ($tampilket == "terlambat") {
        $pilih = $pilih . " AND ketmasuk = 'Terlambat '";
    } elseif ($tampilket == "pulangawal") {
        $pilih = $pilih . " AND ketpulang = 'Pulang Awal '";
    } elseif ($tampilket == "ijin") {
        $pilih = $pilih . " AND keterangan = 'Ijin '";
    } elseif ($tampilket == "WFH") {
        $pilih = $pilih . " AND keterangan = 'WFH '";
    } elseif ($tampilket == "PJJ") {
        $pilih = $pilih . " AND keterangan = 'PJJ '";
    } elseif ($tampilket == "dinasluar") {
        $pilih = $pilih . " AND keterangan = 'Dinas Luar '";
    } elseif ($tampilket == "sakit") {
        $pilih = $pilih . " AND keterangan = 'Sakit '";
    } elseif ($tampilket == "lainnya") {
        if ($pilih) {
            $pilih = $pilih . " AND keterangan IS NOT NULL ";
        } else {
            $pilih = " WHERE keterangan IS NOT NULL ";
        }
    }

    if ($tampiljlm == "10") {
        $jlm = " LIMIT " . 10;
    } elseif ($tampiljlm == "20") {
        $jlm = " LIMIT " . 20;
    } elseif ($tampiljlm == "30") {
        $jlm = " LIMIT " . 30;
    } elseif ($tampiljlm == "40") {
        $jlm = " LIMIT " . 40;
    } elseif ($tampiljlm == "50") {
        $jlm = " LIMIT " . 50;
    } elseif ($tampiljlm == "100") {
        $jlm = " LIMIT " . 100;
    } elseif ($tampiljlm == "semua") {
        $jlm = "";
    }
} else {
    $tampilhari = "0";
    $tampilket = "semua";
    $tampiljlm = "20";
    $ket = $tanggal;
    $jlm = " LIMIT " . 20;
    $kethari = "Hari ini";
    $pilih = "WHERE tanggal = '$tanggal'";
}


$query = "SELECT * FROM datapresensi " . $pilih . "ORDER BY updated_at DESC" . $jlm;
$sql = mysqli_query($konek, $query);
$jml = mysqli_num_rows($sql);

if ($jml) {
?>
    <style>
        /* Menyembunyikan tampilan scrollbar di browser berbasis Webkit */
        .divrecent::-webkit-scrollbar {
            width: 0.5em;
        }

        .divrecent::-webkit-scrollbar-thumb {
            background-color: darkgrey;
            outline: 1px solid slategrey;
        }
    </style>
    <div id="divrecent">
        <!-- <h6 style="font-size: 14px; font-weight: 400; font-style: italic; float: right;">Tampilkan: <?= $kethari; ?>, sortir <?= $tampilket; ?>, <?= $tampiljlm; ?> Data</h6> -->
        <table class="table recent-detail mt-1">
            <?php
            $no = 0;
            while ($data = mysqli_fetch_array($sql)) {
                $tgl_recent = $data['updated_at'];
                $tgl_recent = date('d-m-Y', strtotime($tgl_recent));
                $no++;
            ?>
                <tr>
                    <td><img id="foto-list" src="img/user/<?php echo $data['foto']; ?>"></td>
                    <td><b><?php echo $data['nama']; ?></b>

                        <div style="display: flex; flex-direction: column;">
                            <div style="font-size: 12px;">
                                <label style="color: aliceblue; font-weight: 600; background-color: rgba(0, 0, 0, 0.5); border-radius: 10px 0px 10px 0px; padding: 1px 7px 0px 7px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 28 28" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    <!-- <span class="iconify" data-icon="carbon:recently-viewed"></span>&nbsp; -->
                                    <?= date('H:i:s', strtotime($data['updated_at'])); ?>
                                </label>
                                <label style="background-color: rgba(255, 255, 255, 0.7); border-radius: 10px 0px 10px 0px; padding: 1px 7px 0px 7px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="12" height="12">
                                        <path fill-rule="evenodd" d="M4.75 0a.75.75 0 01.75.75V2h5V.75a.75.75 0 011.5 0V2h1.25c.966 0 1.75.784 1.75 1.75v10.5A1.75 1.75 0 0113.25 16H2.75A1.75 1.75 0 011 14.25V3.75C1 2.784 1.784 2 2.75 2H4V.75A.75.75 0 014.75 0zm0 3.5h8.5a.25.25 0 01.25.25V6h-11V3.75a.25.25 0 01.25-.25h2zm-2.25 4v6.75c0 .138.112.25.25.25h10.5a.25.25 0 00.25-.25V7.5h-11z"></path>
                                    </svg>
                                    <!-- <span class="iconify" data-icon="clarity:date-line"></span>&nbsp; -->
                                    <?= $tgl_recent; ?>
                                </label>
                                <!-- </div>
                            <div> -->
                                <label class="mx-2">
                                    <!-- recent -->
                                    <?php
                                    if ($data['ketmasuk'] == "Terlambat") {
                                    ?>
                                        <label class="bg-warning badge">+<?php echo $data['a_time'] ? $data['a_time'] : "null"; ?></label>
                                    <?php
                                    } elseif ($data['ketmasuk'] == "On Time") {
                                    ?>
                                        <label class="bg-success badge">-<?php echo $data['a_time'] ? $data['a_time'] : "null"; ?></label>
                                    <?php
                                    } elseif ($data['keterangan']) {
                                    ?>
                                        <label class="bg-primary badge"><?= $data['keterangan']; ?></label>
                                    <?php
                                    } else {
                                    ?>
                                        <label class="bg-danger badge">- - - - -</label>
                                    <?php
                                    }
                                    ?>
                                    &#124;
                                    <?php
                                    if ($data['ketpulang'] == "Pulang") {
                                    ?>
                                        <label class="bg-success badge">+<?php echo $data['b_time'] ? $data['b_time'] : "null"; ?></label>
                                    <?php
                                    } elseif ($data['ketpulang'] == "Pulang Awal") {
                                    ?>
                                        <label class="bg-warning badge">-<?php echo $data['b_time'] ? $data['b_time'] : "null"; ?></label>
                                    <?php
                                    } elseif ($data['keterangan']) {
                                    ?>
                                        <label class="bg-primary badge"><?= $data['keterangan']; ?></label>
                                    <?php
                                    } else {
                                    ?>
                                        <label class="bg-danger badge">- - - - -</label>
                                    <?php
                                    }
                                    ?>
                                </label>
                            </div>
                        </div>
                    </td>
                    <td style="font-size: 14px; vertical-align: middle;"><i><?php echo $data['info']; ?></i></td>
                </tr>
            <?php }
            mysqli_close($konek); ?>
        </table>
        <!-- <a class="label-tombol text-decoration-none badge" href="datapresensi.php">Tampilkan semua</a> -->
    </div>
<?php } else { ?>
    <h6 style="font-size: 14px; font-weight: 400; font-style: italic; float: right; margin-right: 10px;">Tampilkan: <?= $kethari; ?>, sortir <?= $tampilket; ?>, <?= $tampiljlm; ?> Data</h6><br>
    <h6 style="margin-left: 10%; margin-right: auto;">- Belum ada data untuk <?= $kethari; ?>, sortir: <?= $tampilket; ?> -</h6>
<?php } ?>