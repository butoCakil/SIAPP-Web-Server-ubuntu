<?php

echo "Tercatat!\n";

if (@$_POST) {
    include '../../config/konesi.php';

    // print_r($_POST);

    // $id = @$_POST['id'];
    $nis = @$_POST['nis'];
    $catatan = @$_POST['catatan'];
    $ruangan = @$_POST['ruangan'];
    $_tanggal = @$_POST['tanggal'];

    $pecahan = explode('#', $_tanggal);

    $tanggal = @$pecahan[0];
    $mulai_jamke = @$pecahan[1]; 

    $tanggal = date('Y-m-d', strtotime($tanggal));
    $timestamp = $tanggal . " 10:10:10";

    // cek Siswa ()
    $cek_presesnsi_kelas = "SELECT * FROM presensikelas WHERE mulai_jamke = '$mulai_jamke' AND nis = '$nis' AND tanggal LIKE '%$tanggal%'";
    $query_cek = mysqli_query($konek, $cek_presesnsi_kelas);
    $hasil_cek = mysqli_num_rows($query_cek);

    if ($hasil_cek) {
        echo mysqli_fetch_array($query_cek)['nama'] . ", ";
        echo " ";

        // update ststus presensi
        $update_catatan = "UPDATE presensikelas SET catatan = '$catatan' WHERE mulai_jamke = '$mulai_jamke' AND nis = '$nis' AND tanggal LIKE '%$tanggal%'";
        $update_query = mysqli_query($konek, $update_catatan);

        if ($update_query) {
            echo "Berhasil di Update \ncatatan : '" . $catatan . "'";
        } else {
            echo "Gagal update catatan";
        }
    } else {
        echo "Tidak ada data, Validasi dahulu.";
    }

    mysqli_close($konek);
}
