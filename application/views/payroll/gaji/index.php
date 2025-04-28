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
                        <li class="breadcrumb-item text-primary">Gaji</li>
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
                                            Data Gaji
                                        </strong>
                                    </h4>
                                </div>
                                <div class="p-1 ms-auto">
                                    <!-- <a href="<?php echo site_url('SDMU/remunerasi-dosen/export-excel/') . $this->uri->segment('4') ?>" class="btn btn-sm btn-success me-2" target="_self">
                                            <span class="tf-icons fa-solid fa-file-excel me-1"></span> Export Excel
                                        </a> -->
                                    <!--<a href="#" class="btn btn-sm btn-danger" target="_blank">
                                            <span class="tf-icons fa-solid fa-file-pdf me-1"></span> Export PDF
                                        </a> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($this->session->flashdata('success'))) : ?>
                                <div class="col-md">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong><?= $this->session->flashdata('success'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            <?php elseif (!empty($this->session->flashdata('error'))) : ?>
                                <div class="col-md">
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong><?= $this->session->flashdata('error'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- GENERATE GAJI -->
                            <div class="row">
                                <div class="col-md-10 mb-2">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label" for="bulan">Bulan</label>
                                        <div class="col-sm-9">
                                            <?php $curYear = date('Y');
                                            $curMonth = date('m');
                                            $yearMonth = $curYear . $curMonth;
                                            ?>
                                            <select class="form-control bulan_gajian" name="bulan" id="bulan" style="width: 100%">
                                                <option value="">Pilih</option>
                                                <option value="<?= $yearMonth  ?>" <?= $this->uri->segment('5') == $yearMonth ? 'selected' : '' ?>>
                                                    <?= $yearMonth  ?>
                                                </option>
                                                <?php foreach ($tahun_gajian as $row) : ?>
                                                    <option value="<?= $row["bulan"] ?>" <?= $this->uri->segment('5') == $row["bulan"] ? 'selected' : '' ?>>
                                                        <?= $row["bulan"] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label" for="bulan">Kategori Pegawai</label>
                                        <div class="col-sm-9">
                                            <select class="form-control select2" name="kategori_pegawai" id="kategori_pegawai" style="width: 100%">
                                                <option value="" selected disabled>Kategori Pegawai</option>
                                                <option value="SemuaData" <?= $this->uri->segment('6') == 'SemuaData' ? 'selected' : '' ?>>Semua Data</option>
                                                <option value="Pimpinan" <?= $this->uri->segment('6') == 'Pimpinan' ? 'selected' : '' ?>>Pimpinan</option>
                                                <option value="Dosen" <?= $this->uri->segment('6') == 'Dosen' ? 'selected' : '' ?>>Dosen</option>
                                                <option value="TenagaKependidikan" <?= $this->uri->segment('6') == 'TenagaKependidikan' ? 'selected' : '' ?>>Tenaga Kependidikan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-end">
                                    <button type="button" id="btn_generate_gaji" class="btn btn-primary col-md-3 col-sm-6 me-1 mb-2">
                                        <span class="fa fa-fw fa-cogs me-1"></span> Generate Gaji
                                    </button>
                                    <button type="button" id="btn_export_excel" class="btn btn-success col-md-2 col-sm-6 me-1 mb-2">
                                        <span class="fa fa-fw fa-file-excel-o me-1"></span> Export Excel
                                    </button>
                                    <button type="button" id="btn_export_payroll" class="btn btn-warning col-md-3 col-sm-6 me-1 mb-2">
                                        <span class="fa fa-fw fa-file-excel-o me-1"></span> Export Payroll
                                    </button>
                                    <button type="button" id="btn_cari_data" class="btn btn-dark col-md-2 col-sm-6 me-1 mb-2">
                                        <i class="fa fa-fw fa-search me-1"></i>Cari Data
                                    </button>
                                    <a href="<?= base_url('administrator/payroll/gaji') ?>" type="button" class="btn btn-secondary col-md-2 col-sm-6 me-1 mb-2"><i class="fa fa-fw fa-refresh me-1"></i>Refresh</a>
                                </div>
                            </div>
                            <hr>

                            <!-- GENERATE GAJI -->
                            <div class="table-responsive text-nowrap">
                                <table class="table-remun-dosen table table-sm table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Aksi</th>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Status Gaji</th>
                                            <th>Nama</th>
                                            <th>Gaji Pokok</th>
                                            <th>Gaji Rapel</th>
                                            <th>Tunjangan Jabatan Struktural</th>
                                            <th>Uang Kehadiran</th>
                                            <th>Lembur</th>
                                            <th>Potongan</th>
                                            <th>Gaji Bersih</th>
                                            <th>Bank</th>
                                            <th>No. Rekening</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <?php if (is_array($gaji)) : ?>
                                            <?php
                                            $no = 1;
                                            ?>
                                            <?php foreach ($gaji as $row) : ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <?php if ($row['status_payment'] == 'PAID') : ?>
                                                            <a href="<?php echo base_url('administrator/payroll/cetak-slip-gaji/') . $this->uri->segment('5') . "/" . $row["peg_id"] ?>" target="_blank" class="btn btn-primary btn-sm" onclick="return confirm('Cetak gaji?')">
                                                                <i class="tf-icons fa-solid fa-file-pdf me-1"></i>Slip PDF
                                                            </a>
                                                            <a href="<?php echo base_url('administrator/payroll/cetak-slip-gaji-excel/') . $this->uri->segment('5') . "/" . $row["peg_id"] ?>" target="_blank" class="btn btn-success btn-sm" onclick="return confirm('Cetak gaji?')">
                                                                <i class="tf-icons fa-solid fa-file-pdf me-1"></i>Slip Excel
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong>
                                                            <?= $no++ ?>.
                                                        </strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($row["status_payment"]  == 'PAID') : ?>
                                                            <span class="badge bg-success"><?= $row["status_payment"] ?></span>
                                                        <?php elseif ($row["status_payment"]  == 'UNPAID') : ?>
                                                            <span class="badge bg-warning"><?= $row["status_payment"] ?></span>
                                                        <?php elseif ($row["status_payment"]  == 'PENDING') : ?>
                                                            <span class="badge bg-danger"><?= $row["status_payment"] ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <strong>
                                                            <?=
                                                            nama_lengkap_ucwords($row['nama_depan'], $row['nama_tengah'], $row['nama_belakang'])
                                                            ?>
                                                        </strong>
                                                    </td>
                                                    <td><?= format_rupiah($row["gaji_pokok"]); ?></td>
                                                    <td><?= format_rupiah($row["gaji_rapel"]); ?></td>
                                                    <td><?= format_rupiah($row["t_jabatan_struktural"]); ?></td>
                                                    <td><?= format_rupiah($row["t_absensi"]); ?></td>
                                                    <td><?= format_rupiah($row["t_lembur"]); ?></td>
                                                    <td>
                                                        <span data-bs-toggle="modal" data-bs-target="#modalDetails">
                                                            <button type="button" class='btn btn-sm btn-outline-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Detail" onclick="checkPotongan('<?= $row['peg_id'] ?>','<?= $row['bulan'] ?>')">
                                                                <?= format_rupiah($row["potongan"]); ?>
                                                            </button>
                                                        </span>
                                                    </td>
                                                    <td><?= format_rupiah($row["take_home_pay"]); ?></td>
                                                    <td><?= $row["bank"]; ?></td>
                                                    <td><?= $row["no_rekening"]; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
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

    <!-- Modal Details-->
    <div class="modal fade" id="modalDetails" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"><strong>Detail Potongan</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Details-->

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

    function checkPotongan(param, bulan) {
        $.ajax({
            url: "<?php echo site_url('administrator/payroll/gaji/detail-potongan'); ?>",
            type: "POST",
            data: {
                "param": param,
                "bulan": bulan
            },
            success: function(response) {
                if (response.status === 1) {
                    // Add response in Modal body
                    $('.modal-body').html(response.html);
                }
            },
            error: function(jqXHR, status, error) {
                // Hopefully we should never reach here
                console.log(jqXHR);
                console.log(status);
                console.log(error);
            }
        });
    }

    $(document).ready(function() {
        selectRefresh();

        $('#btn_generate_gaji').click(function() {
            Swal.fire({
                title: "Generate Gaji",
                text: "Generate gaji " + $("#kategori_pegawai option:selected").text() + " Bulan " + $('#bulan').val(),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    (isEmpty($('#bulan').val()) || isEmpty($('#kategori_pegawai').val())) ?
                    setTimeout(function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Mohon isi Bulan dan Kategori Pegawai',
                                icon: 'error',
                            })
                        }, 0):
                        setTimeout(function() {
                            window.open("<?php echo site_url() . 'administrator/payroll/gaji/generate/' ?>" + $('#bulan').val() + '/' + $('#kategori_pegawai').val(), "_self");
                        }, 0);
                }
            });

        });

        $('#btn_export_excel').click(function() {
            Swal.fire({
                title: "Export",
                text: "Export excel gaji " + $("#kategori_pegawai option:selected").text() + " Bulan " + $('#bulan').val(),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    (isEmpty($('#bulan').val()) || isEmpty($('#kategori_pegawai').val())) ?
                    setTimeout(function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Mohon isi Bulan dan Kategori Pegawai',
                                icon: 'error',
                            })
                        }, 0):
                        setTimeout(function() {
                            window.open("<?php echo site_url() . 'administrator/payroll/gaji/export-excel/' ?>" + $('#bulan').val() + '/' + $('#kategori_pegawai').val(), "_self");
                        }, 0);
                }
            });


        });

        $('#btn_export_payroll').click(function() {
            Swal.fire({
                title: "Export Payroll gaji " + $("#kategori_pegawai option:selected").text() + " Bulan " + $('#bulan').val(),
                text: "Data gaji dengan status UNPAID akan berubah menjadi PAID",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    (isEmpty($('#bulan').val()) || isEmpty($('#kategori_pegawai').val())) ?
                    setTimeout(function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Mohon isi Bulan dan Kategori Pegawai',
                                icon: 'error',
                            })
                        }, 0):
                        setTimeout(function() {
                            window.open("<?php echo site_url() . 'administrator/payroll/gaji/export-payroll/' ?>" + $('#bulan').val() + '/' + $('#kategori_pegawai').val(), "_self");
                        }, 0);
                }
                window.location.reload();
            });


        });

        $('#btn_cari_data').click(function() {
            (isEmpty($('#bulan').val()) || isEmpty($('#kategori_pegawai').val())) ?
            setTimeout(function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Mohon isi Bulan dan Kategori Pegawai',
                        icon: 'error',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open("<?php echo site_url('administrator/payroll/gaji'); ?>", "_self");
                        }
                    });
                }, 0):
                setTimeout(function() {
                    window.open("<?php echo site_url() . 'administrator/payroll/gaji/index/' ?>" + $('#bulan').val() + '/' + $('#kategori_pegawai').val(), "_self");
                }, 0);
        });

        $('.table-remun-dosen').DataTable({
            fixedColumns: {
                left: 4,
            },
            scrollCollapse: true,
            scrollX: true,
            scrollY: 400,
            "buttons": {
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<span class="tf-icons fa-solid fa-file-excel me-1"></span> Export Excel',
                    name: 'testExport',
                    exportOptions: {
                        orthogonal: 'export'
                    }
                }, ]
            },
            "dom": "<'row'<'col-sm-4'l><'col-sm-4'><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        });
    });
</script>

</html>