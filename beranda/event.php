<?php
ini_set('display_errors', 1);
include('app/get_user.php');
$tanggal = date('Y-m-d');
$tanggal_dmY = date('d-m-Y');
$tahun = date('Y');

$title = 'Presensi Kegiatan/Pembiasaan';
$navlink = 'Wali';
$navlink_sub = 'kegiatan';

$GetEvent = @$_GET['event'];
$data = array();

include "../config/konesi.php";

if (isSafeInput($GetEvent) || (!$GetEvent)) {
    if ($GetEvent == "pembiasaanpagi") {
        $ket = "PAGI";
    } elseif ($GetEvent == "masjid") {
        $ket = "MASJID";
    } else {
        $ket = "EVENT";
    }
    $query_select_event = "SELECT * FROM presensiEvent WHERE keterangan = ?";
    $stmt_select_event = mysqli_stmt_init($konek);
    mysqli_stmt_prepare($stmt_select_event, $query_select_event);
    mysqli_stmt_bind_param(
        $stmt_select_event,
        "s",
        $ket
    );
    mysqli_stmt_execute($stmt_select_event);
    $result_select_event = mysqli_stmt_get_result($stmt_select_event);

    while ($row = mysqli_fetch_assoc($result_select_event)) {
        $data[] = $row;
    }

    // Tutup prepared statement
    mysqli_stmt_close($stmt_select_event);
} else {
    die("InputSalah");
}

// echo "<pre>";
// print_r($data);
// echo "</pre>";
// die;

include "views/header.php";
?>

<section class="content">
    <div class="container-fluid">
        <div class="card elevation-3 bg-primary bg-gradient-primary border-0" style="z-index: 1;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>&nbsp;
                    Rekap Presensi Pembiasaan & Kegiatan
                </h3>
                <div class="card-tools">
                    <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Menampilkan Catatan Presensi Semua siswa dan dapat memilih perkelas serta perjurusan"></i>
                    &nbsp;
                </div>
            </div>
        </div>

        <div class="col-12" style="margin-top: -20px;">
            <div class="card elevation-3">
                <div class="card-body mb-5">
                    <!-- Pilih Event -->
                    <div class="w-50 mb-2">
                        <select name="pilihEvent" id="pilihEVent" class="form-control" onchange="pilihevent(this.value);">
                            <option value="">-- Pilih --</option>
                            <option <?= ($GetEvent == "pembiasaanpagi") ? "selected" : ""; ?> value="pembiasaanpagi">Pembiasaan Pagi</option>
                            <option <?= ($GetEvent == "masjid") ? "selected" : ""; ?> value="masjid">Sholat Berjamaan</option>
                            <option <?= ($GetEvent == "eventlainnya") ? "selected" : ""; ?> value="eventlainnya">Event Lainnya</option>
                        </select>
                    </div>

                    <?php if ($GetEvent) { ?>
                        <div>
                            <h4>Rekap Presensi Kegiatan</h4>
                        </div>

                        <!-- dataTables -->
                        <div class="table-responsive">
                            <table id="evemttable" class="table">
                                <thead>
                                    <th>No.</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>info</th>
                                    <th>Waktu</th>
                                    <th>tanggal</th>
                                    <th>ket</th>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < count($data); $i++) {
                                        $ni = $data[$i]['nis'];
                                        $ruang = $data[$i]['ruang'];
                                        $mulai = $data[$i]['mulai'];
                                        $selesai = $data[$i]['selesai'];
                                        $tanggal = $data[$i]['tanggal'];
                                        $keterangan = $data[$i]['keterangan'];
                                    ?>
                                        <tr>
                                            <td><?= ($i + 1); ?></td>
                                            <td><?= $ni; ?></td>
                                            <td>
                                                <?php
                                                $query_select_event = "SELECT * FROM datasiswa WHERE nis = ?";
                                                $stmt_select_event = mysqli_stmt_init($konek);
                                                mysqli_stmt_prepare($stmt_select_event, $query_select_event);
                                                mysqli_stmt_bind_param(
                                                    $stmt_select_event,
                                                    "s",
                                                    $ni
                                                );
                                                mysqli_stmt_execute($stmt_select_event);
                                                $result_select_event = mysqli_stmt_get_result($stmt_select_event);

                                                if ($row = mysqli_fetch_assoc($result_select_event)) {
                                                    $nama = $row['nama'];
                                                    $info = $row['kelas'];
                                                } else {
                                                    $nama = "";
                                                    $info = "";
                                                }

                                                // Tutup prepared statement
                                                mysqli_stmt_close($stmt_select_event);

                                                if (!$nama) {
                                                    $query_select_event = "SELECT * FROM dataguru WHERE nip = ?";
                                                    $stmt_select_event = mysqli_stmt_init($konek);
                                                    mysqli_stmt_prepare($stmt_select_event, $query_select_event);
                                                    mysqli_stmt_bind_param(
                                                        $stmt_select_event,
                                                        "s",
                                                        $ni
                                                    );
                                                    mysqli_stmt_execute($stmt_select_event);
                                                    $result_select_event = mysqli_stmt_get_result($stmt_select_event);

                                                    if ($row = mysqli_fetch_assoc($result_select_event)) {
                                                        $nama = $row['nama'];
                                                        $info = $row['status'] . " - " . $row['info'];
                                                    } else {
                                                        $nama = "";
                                                        $info = "";
                                                    }

                                                    // Tutup prepared statement
                                                    mysqli_stmt_close($stmt_select_event);
                                                }
                                                echo $nama;
                                                ?>
                                            </td>
                                            <td><?= @$info; ?></td>
                                            <td>
                                                <span class="badge bg-<?= $mulai ? "success" : "danger" ?>"><?= $mulai ? $mulai : "-"; ?></span>
                                                <span class="badge bg-<?= $selesai ? "success" : "danger" ?>"><?= $selesai ? $selesai : "-"; ?></span>
                                            </td>
                                            <td><?= @$tanggal; ?></td>
                                            <td><?= @$keterangan; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div>
                            <h4>-- Pilih Kegiatan --</h4>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
</section>

<script>
    function pilihevent(_select) {
        // alert(_select);
        window.location.href = " ?event=" + _select;
    }

    $(function() {
        $(" #evemttable").DataTable({
            dom: 'Bfltip',
            "autoWidth": false,
            "responsive": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Semua"]
            ],
            "pagingType": "full",
            "language": {
                "emptyTable": "Tida ada data untuk tanggal yang dipilih.",
                "info": "Ditampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Ditampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(Disaring dari _MAX_ total data)",
                "lengthMenu": "Tampilkan _MENU_ baris data",
                "loadingRecords": "Memuat...",
                "processing": "Memproses...",
                "search": "Cari:",
                "zeroRecords": "Tidak ditemukan data yang sesuai.",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "next": "lanjut >",
                    "previous": "< sebelum"
                },
            },
            "buttons": ["print", "excel", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<?php
include "views/footer.php";
?>
<?php
function isSafeInput($input)
{
    // Buat pola regex untuk karakter yang dianggap aman
    $safePattern = "/^[a-zA-Z0-9\s]+$/";

    // Periksa apakah input mengandung karakter mencurigakan
    if (preg_match($safePattern, $input)) {
        return true; // Input aman
    } else {
        return false; // Input mencurigakan
    }
}
?>