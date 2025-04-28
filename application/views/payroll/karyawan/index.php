<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
</head>

<body class="bg-light-gray">
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php $this->load->view('_partials/sidebar_payroll_staff') ?>
        <div class="body-wrapper">
            <?php $this->load->view('_partials/header') ?>
            <div class="container-fluid">
                <!-- Isi page mulai dari sini -->
                <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 pb-3">
                    <a class="btn btn-sm btn-primary rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item">Payroll</li>
                        <li class="breadcrumb-item text-primary">Karyawan</li>
                    </ol>
                </nav>


                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Isi page mulai dari sini -->
                    <!-- Contoh -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="p-1">
                                    <h4 class="card-title mb-4">
                                        <strong>
                                            Data Karyawan
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="datatable table table-sm table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIK</th>
                                            <th>Nama Dosen</th>
                                            <th>Gelar Depan</th>
                                            <th>Gelar Belakang</th>
                                            <th>Kelamin</th>
                                            <th>Tempat Tanggal Lahir</th>
                                            <th>Usia</th>
                                            <th>Status Perkawinan</th>
                                            <th>Alamat</th>
                                            <th>No.HP</th>
                                            <th>Email Pribadi</th>
                                            <th>Email Institusi</th>
                                            <th>NIDN</th>
                                            <th>Pangkat & Golongan</th>
                                            <th>Jabatan Akademik</th>
                                            <th>Jabatan Struktural</th>
                                            <th>Status Kepegawaian</th>
                                            <th>Homebase / Unit Kerja</th>
                                            <th>No NPWP</th>
                                            <th>TMT</th>
                                            <th>Masa Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <?php
                                        $no = 1;
                                        ?>
                                        <?php foreach ($pegawai as $row) : ?>
                                            <tr>
                                                <td><strong><?= $no++ . "." ?></strong></td>
                                                <td>
                                                    <?= $row['nik'] ?>
                                                </td>
                                                <td>
                                                    <?=
                                                    nama_lengkap_ucwords($row['nama_depan'], $row['nama_tengah'], $row['nama_belakang'])
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= $row['gelar_depan'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['gelar_belakang'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['jenis_kelamin'] == 'L' ? 'Laki - Laki' : 'Perempuan' ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['tempat_lahir']) && !empty($row['tanggal_lahir'])) {
                                                        echo $row['tempat_lahir'] . ", " . tanggal_indonesia($row['tanggal_lahir']);
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['tanggal_lahir'])) {
                                                        $dateOfBirth = $row['tanggal_lahir'];
                                                        $dob = new DateTime($dateOfBirth);

                                                        // Get current date
                                                        $now = new DateTime();

                                                        $diff = $now->diff($dob);

                                                        echo $diff->y;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= empty($row['status_pernikahan']) ? '-' : $row['status_pernikahan'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['alamat'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['kontak'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['email_pribadi'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['email_kampus'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['nidn_nidk_nitk'] ?>
                                                </td>
                                                <td>
                                                    <?= $row['golongan'] . " - " . $row['pangkat'] ?>
                                                </td>
                                                <td>
                                                    <?=
                                                    $row['nama_jabatan'] . " - " . $row['angka_kredit']
                                                    ?>
                                                </td>
                                                <td>
                                                    <?=
                                                    $row['nama_jabatan_struktural']
                                                    ?>
                                                </td>
                                                <td>
                                                    <?= $row['status_kepegawaian'] ?>
                                                </td>
                                                <td><?= !empty($row['nama_prodi']) ? $row['nama_prodi'] : $row['nama_divisi']  ?></td>
                                                <td><?= $row['no_npwp'] ?></td>
                                                <td><?= $row['tmt'] ?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['tmt'])) {
                                                        $dateOfBirth2 = $row['tmt'];
                                                        $dob2 = new DateTime($dateOfBirth2);

                                                        $diff2 = $now->diff($dob2);

                                                        echo $diff2->y . " tahun " . $diff2->m . " bulan " . $diff2->d . " hari.";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Contoh -->
                    <!-- Isi page berakhir di sini -->
                </div>
                <!-- Isi page berakhir di sini -->
                <?php $this->load->view('_partials/footer') ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/script') ?>


</body>

<!-- DataTables -->
<script>
    function selectRefresh() {
        $('select:not(.normal)').select2({
            //-^^^^^^^^--- update here
            tags: true,
            width: '100%'
        });
    }

    function isEmpty(value) {
        return (value == null || value.length === 0);
    }

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }

    $(document).ready(function() {
        selectRefresh();

        $('.datatable').DataTable({
            fixedColumns: {
                left: 2,
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 400,
            "buttons": {
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<span class="tf-icons fa-solid fa-file-excel me-1"></span> Export Excel',
                    name: 'testExport',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c[r^="B"]', sheet).attr('t', 's'); //.attr('s', 50);
                    }
                }]
            },
            "dom": "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        });
    });
</script>

</html>