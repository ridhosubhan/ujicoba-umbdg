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
                        <li class="breadcrumb-item text-primary">Potongan Pegawai</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3"><strong>Data Potongan Pegawai</strong></h4>

                        <div class="mb-4 d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="<?= base_url('administrator/payroll/potongan/upload') ?>" class="btn btn-outline-success">
                                <i class="fa fa-solid fa-upload me-2"></i>Upload Potongan
                            </a>
                            <a href="<?= base_url('administrator/payroll/potongan/list') ?>" class="btn btn-outline-dark">
                                <i class="fa fa-solid fa-search me-2"></i>Filter Detail Potongan
                            </a>
                        </div>

                        <div class="table-responsive text-nowrap">
                            <table class="table table-sm table-hover table-bordered table-striped" id="table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kategori Kepegawaian</th>
                                        <th class="text-center">Status Kepegawaian</th>
                                        <th class="text-center">Kelamin</th>
                                        <th class="text-center">Pangkat & Golongan</th>
                                        <th class="text-center">Jabatan Akademik</th>
                                        <th class="text-center">Jabatan Struktural</th>
                                        <th class="text-center">Homebase</th>
                                        <th class="text-center">TMT</th>
                                        <th class="text-center">Masa Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($pegawai as $row) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <a href="<?= base_url() ?>administrator/payroll/potongan/detail/<?= $row['peg_id'] ?>" class="btn btn-sm btn-icon btn-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                                    Detail
                                                </a>
                                            </td>
                                            <td><strong><?= $no++ . "." ?></strong></td>
                                            <td>
                                                <?=
                                                nama_gelar_lengkap_ucwords($row['nama_depan'], $row['nama_tengah'], $row['nama_belakang'], $row['gelar_depan'], $row['gelar_belakang'])
                                                ?>
                                            </td>
                                            <td>
                                                <?= $row['kat_pegawai'] ?>
                                            </td>
                                            <td>
                                                <?= $row['status_kepegawaian'] ?>
                                            </td>
                                            <td>
                                                <?= $row['jenis_kelamin'] == 'L' ? 'Laki - Laki' : 'Perempuan' ?>
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
                                                <?php
                                                if (empty($row["nama_prodi"])) {
                                                    echo $row["nama_divisi"];
                                                } else if (empty($row["nama_divisi"])) {
                                                    echo $row["nama_prodi"];
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td><?= $row['tmt'] ?></td>
                                            <td>
                                                <?php
                                                if (!empty($row['tmt'])) {
                                                    // Get current date
                                                    $now = new DateTime();

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
                <!-- Isi page berakhir di sini -->
                <?php $this->load->view('_partials/footer') ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/script') ?>

    <!-- DataTables -->
    <script>
        $(document).ready(() => {
            $('.select2').select2({
                theme: 'bootstrap-5',
            });

            // var table = $('#table').DataTable({
            //     lengthChange: false,
            //     buttons: ['excel', 'pdf']
            // });
            // table.buttons().container()
            //     .appendTo('#table_wrapper .col-md-6:eq(0)');

            $('#table').DataTable({
                scrollCollapse: true,
                paging: true,
                scrollX: true,
                scrollY: 400,
                aLengthMenu: [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "All"]
                ],
                "buttons": {
                    buttons: [{
                        extend: 'excelHtml5',
                        text: '<span class="tf-icons fa-solid fa-file-excel me-1"></span> Excel',
                        name: 'testExport',
                        exportOptions: {
                            orthogonal: 'export'
                        }
                    }, {
                        extend: 'pdf',
                        text: '<span class="tf-icons fa-solid fa-file-excel me-1"></span> PDF',
                        name: 'testExport',
                        exportOptions: {
                            orthogonal: 'export'
                        }
                    }]
                },
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        });
    </script>
</body>

</html>