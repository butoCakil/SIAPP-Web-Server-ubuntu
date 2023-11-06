<section class="content">
    <div class="container-fluid">
        <div class="card elevation-3 bg-primary bg-gradient-primary border-0" style="z-index: 1;">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>&nbsp;
                    Rekap Data Guru
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
                    <div class="alert alert-info">
                        <p>
                            <i class="fas fa-info-circle"></i>&nbsp;
                            Tips : <br>
                            &nbsp;&nbsp;&nbsp;<i class="far fa-circle"></i>
                            Klik Judul kolom pada tabel untuk mengurutkan data. <br>
                            &nbsp;&nbsp;&nbsp;<i class="far fa-circle"></i>
                            Ketikkan kata pada kolom "Cari" untuk mencari data tabel.
                        </p>
                        <!-- <i class="fas fa-file text-fuchsia"></i> -->
                        <!-- <i class="far fa-circle"></i> -->
                        <!-- <i class="fas fa-heart"></i> -->
                    </div>
                    <button class="btn btn-sm btn-dark shadow bg-gradient-dark border-0 m-1" onclick="history.go(-1);"><i class="fas fa-arrow-left"></i>&nbsp;&nbsp;Kembali</button>

                    <table id="datagururekap" class="table table-bordered table-striped">
                        <thead>
                            <tr style="text-align: center; position: sticky;">
                                <th>No.</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>info</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($ii = 0; $ii < $jumlah_data_dataguru; $ii++) { ?>
                                <tr>
                                    <td><?= $ii + 1; ?></td>
                                    <td>
                                        <img src="../img/user/<?= $data_dataguru[$ii]['foto']; ?>" alt="" style="height: 50px; width: 50px; object-fit: cover; object-position: center; border-radius: 50%;">
                                    </td>
                                    <td><?= $data_dataguru[$ii]['nama']; ?></td>
                                    <td><?= $data_dataguru[$ii]['status']; ?></td>
                                    <td><?= $data_dataguru[$ii]['jabatan']; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="detail_gtk.php?nick=<?= $data_dataguru[$ii]['nick']; ?>&data=detail" class="btn btn-sm btn-success shadow bg-gradient-success border-0">
                                                <i class="fas fa-info-circle"></i>&nbsp;
                                                Detail</a>
                                            <a href="detail_jurnal.php?nick=<?= $data_dataguru[$ii]['nick']; ?>&data=jurnal" class="btn btn-sm btn-warning shadow bg-gradient-warning border-0">
                                                <i class="fas fa-file"></i>
                                                Jurnal</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>