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
                        <li class="breadcrumb-item text-primary">Rapel Gaji</li>
                    </ol>
                </nav>


                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Isi page mulai dari sini -->
                    <!-- Contoh -->
                    <div class="card mb-4">
                        <!-- Header -->
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="p-1">
                                    <h4 class="card-title mb-4">
                                        <strong>
                                            Data Rapel Gaji
                                        </strong>
                                    </h4>
                                </div>
                                <div class="p-1 ms-auto">
                                    <span data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        <button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data">
                                            <span class="ti ti-plus me-1"></span> Tambah Data
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Header -->

                        <div class="card-body">
                            <?php if (!empty($this->session->flashdata('success'))) : ?>
                                <div class="col-md">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong><?= $this->session->flashdata('success'); ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- GENERATE GAJI -->
                            <div class="row">
                                <div class="col-md-10 mb-4">
                                    <div class="row mb-2">
                                        <label class="col-sm-3 col-form-label" for="bulan">Bulan</label>
                                        <div class="col-sm-9">
                                            <?php $curYear = date('Y');
                                            $curMonth = date('m');
                                            $yearMonth = $curYear . $curMonth;
                                            ?>
                                            <select class="form-control bulan_gajian" name="bulan" id="bulan" style="width: 100%">
                                                <option value="">Pilih</option>
                                                <option value="<?= $yearMonth  ?>">
                                                    <?= $yearMonth  ?>
                                                </option>
                                                <?php foreach ($tahun_gajian as $row) : ?>
                                                    <option value="<?= $row["bulan"] ?>">
                                                        <?= $row["bulan"] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-4">
                                    <a href="<?php echo site_url() . 'administrator/payroll/rapel-gaji/export-excel/' . $this->uri->segment('5') ?>" onclick="return confirm('Export excel gaji <?= $this->uri->segment('5') ?>?');" class="btn btn-sm btn-success me-2 mb-2" target="_blank">
                                        <span class="tf-icons fa-solid fa-file-excel me-1"></span> Export Excel
                                    </a>
                                    <a href="<?php echo site_url() . 'administrator/payroll/rapel-gaji/export-payroll/' . $this->uri->segment('5') ?>" onclick="return confirm('Export payroll <?= $this->uri->segment('5') ?>? \nData rapel gaji dengan status UNPAID akan berubah menjadi PAID');" target="_blank" class="btn btn-sm btn-warning me-2">
                                        <span class="tf-icons fa-solid fa-file-excel me-1"></span> Export Payroll
                                    </a>
                                    <!-- <button onclick="exportPayroll('<?= $this->uri->segment('5') ?>')" class="btn btn-sm btn-warning me-2">
                                        Export Payroll
                                    </button> -->
                                </div>
                            </div>

                            <!-- GENERATE GAJI -->
                            <div class="table-responsive text-nowrap">
                                <table width="100%" class="table-remun-dosen table table-sm table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <!-- <th class="text-center">Aksi</th> -->
                                            <th class="text-center">No.</th>
                                            <!-- <th class="text-center">Status Gaji</th> -->
                                            <th>Nama</th>
                                            <th>Gaji Pokok</th>
                                            <!-- <th>Tunjangan Jabatan Struktural</th>
                                            <th>Uang Kehadiran</th>
                                            <th>Lembur</th>
                                            <th>Potongan</th>
                                            <th>Gaji Bersih</th> -->
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
                                                    <!-- <td class="text-center">
                                                        <a href="<?php echo base_url('administrator/payroll/cetak-slip-gaji/') . $this->uri->segment('5') . "/" . $row["peg_id"] ?>" target="_blank" class="btn btn-primary btn-sm" onclick="return confirm('Cetak gaji?')">
                                                            <i class="tf-icons fa-solid fa-file-pdf me-1"></i>Slip PDF
                                                        </a>
                                                        <a href="<?php echo base_url('administrator/payroll/cetak-slip-gaji-excel/') . $this->uri->segment('5') . "/" . $row["peg_id"] ?>" target="_blank" class="btn btn-success btn-sm" onclick="return confirm('Cetak gaji?')">
                                                            <i class="tf-icons fa-solid fa-file-pdf me-1"></i>Slip Excel
                                                        </a>
                                                    </td> -->
                                                    <td class="text-center">
                                                        <strong>
                                                            <?= $no++ ?>.
                                                        </strong>
                                                    </td>
                                                    <!-- <td class="text-center">
                                                        <?php if ($row["status_payment"]  == 'PAID') : ?>
                                                            <span class="badge bg-success"><?= $row["status_payment"] ?></span>
                                                        <?php elseif ($row["status_payment"]  == 'UNPAID') : ?>
                                                            <span class="badge bg-warning"><?= $row["status_payment"] ?></span>
                                                        <?php elseif ($row["status_payment"]  == 'PENDING') : ?>
                                                            <span class="badge bg-danger"><?= $row["status_payment"] ?></span>
                                                        <?php endif; ?>
                                                    </td> -->
                                                    <td>
                                                        <strong>
                                                            <?=
                                                            nama_lengkap_ucwords($row['nama_depan'], $row['nama_tengah'], $row['nama_belakang'])
                                                            ?>
                                                        </strong>
                                                    </td>
                                                    <td><?= format_rupiah($row["gaji_pokok"]); ?></td>
                                                    <!-- <td><?= format_rupiah($row["t_jabatan_struktural"]); ?></td>
                                                    <td><?= format_rupiah($row["t_absensi"]); ?></td>
                                                    <td><?= format_rupiah($row["t_lembur"]); ?></td> -->
                                                    <!-- <td>
                                                        <span data-bs-toggle="modal" data-bs-target="#modalDetails">
                                                            <button type="button" class='btn btn-sm btn-outline-primary' data-bs-toggle="tooltip" data-bs-placement="top" title="Detail" onclick="checkPotongan('<?= $row['peg_id'] ?>','<?= $row['bulan'] ?>')">
                                                                <?= format_rupiah($row["potongan"]); ?>
                                                            </button>
                                                        </span>
                                                    </td>
                                                    <td><?= format_rupiah($row["take_home_pay"]); ?></td> -->
                                                    <td><?= $row["bank"]; ?></td>
                                                    <td><?= $row["no_rekening"]; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- GENERATE GAJI -->

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
    <!-- load view modal edit  -->
    <?php $this->load->view('payroll/rapel_gaji/modal'); ?>

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

    function exportPayroll(bulan) {
        Swal.fire({
            title: "Export Payroll?",
            text: "Data gaji dengan status UNPAID akan berubah menjadi PAID",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('administrator/payroll/gaji/export-payroll/' . $this->uri->segment('5')) ?>",
                    method: "POST",
                    cache: false,
                    contentType: 'application/json; charset=utf-8',
                    success: function(response) {
                        window.open('<?php echo site_url('administrator/payroll/gaji/export-payroll/' . $this->uri->segment('5')) ?>');
                        location.reload();
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        selectRefresh();

        $("#pegawai").select2({
            tags: true,
            width: '100%',
            theme: 'bootstrap-5',
            dropdownParent: $("#tambahModal")
        });

        $('.bulan_gajian').select2().val("<?= $this->uri->segment('5') ?>").trigger("change");

        $('.bulan_gajian').on('select2:select', function(e) {
            var newVal = this.options[this.selectedIndex].value;

            (isEmpty(newVal)) ?
            setTimeout(function() {
                    window.open("<?php echo site_url('administrator/payroll/rapel-gaji/'); ?>", "_self");
                }, 0):
                setTimeout(function() {
                    window.open("<?php echo site_url() . 'administrator/payroll/rapel-gaji/index/' ?>" + newVal, "_self");
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


        $('#formSubmit').on('submit', function(e) {
            e.preventDefault();
            var form_data = $('#formSubmit').serializeArray();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('administrator/payroll/rapel-gaji/store') ?>",
                dataType: "JSON",
                data: form_data,
                beforeSend: function() {
                    $(".buttonSimpan").prop("disabled", true);
                    $('.buttonSimpan').html('Mengirim');
                },
                complete: function() {
                    $(".buttonSimpan").prop("disabled", false);
                    $('.buttonSimpan').html('Simpan');
                },
                success: function(data) {
                    if (data.type === 1) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                    if (data.status == 0) {
                        if (data.error_message.bulan) {
                            $('#bulan').addClass('is-invalid');
                            $('.errorBulan').html(data.error_message.bulan);
                        } else {
                            $('#bulan').removeClass('is-invalid');
                            $('.errorBulan').html('');
                        }
                        if (data.error_message.pegawai) {
                            $('#pegawai').addClass('is-invalid');
                            $('.errorPegawai').html(data.error_message.pegawai);
                        } else {
                            $('#pegawai').removeClass('is-invalid');
                            $('.errorPegawai').html('');
                        }
                        if (data.error_message.rapel_gaji) {
                            $('#rapel_gaji').addClass('is-invalid');
                            $('.errorRapelGaji').html(data.error_message.rapel_gaji);
                        } else {
                            $('#rapel_gaji').removeClass('is-invalid');
                            $('.errorRapelGaji').html('');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('Error: ', err.Message);
                }
            });
        });
    });
</script>

</html>