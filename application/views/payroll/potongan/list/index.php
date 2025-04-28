<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                        <li class="breadcrumb-item">Potongan Pegawai</li>
                        <li class="breadcrumb-item text-primary">Filter Data Potongan</li>
                    </ol>
                </nav>

                <div class="card">
                    <!-- Sinkron Potongan -->
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="p-1">
                                <h4 class="card-title">
                                    <strong>
                                        Sinkronkan Data Potongan
                                    </strong>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- Sinkron Potongan -->
                    <div class="card-body">
                        <form id="formSync" method="POST">
                            <div class="mb-3">
                                <label for="bulan_sync" class="form-label">Bulan</label>
                                <?php $curYear = date('Y');
                                $curMonth = date('m');
                                $yearMonth = $curYear . $curMonth;
                                ?>
                                <select class="form-select select2" name="bulan_sync" id="bulan_sync">
                                    <option value="" selected disabled>Pilih</option>
                                    <option value="<?= $yearMonth  ?>">
                                        <?= $yearMonth  ?>
                                    </option>
                                    <?php foreach ($tahun_gajian as $row) : ?>
                                        <option value="<?= $row["bulan"] ?>">
                                            <?= $row["bulan"] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback errorBulanSync"></div>
                            </div>
                            <div class="mb-4 d-grid gap-2 d-md-flex justify-content-md-end">
                                <button id="btnSync" type="submit" class="btn btn-primary"><i class="fa fa-refresh me-2" aria-hidden="true"></i>Sinkronkan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Sinkron Potongan -->

                <!-- Filter Search Potongan -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4"><strong>Filter Data Potongan</strong></h4>
                        <form id="formSearch" method="GET">
                            <div class="mb-3">
                                <label for="jenis_potongan" class="form-label">Potongan</label>
                                <select class="form-select select2" name="jenis_potongan" id="jenis_potongan">
                                    <option value="" selected disabled>Pilih</option>
                                    <?php foreach ($ref_potongan as $row) : ?>
                                        <option value="<?= $row["id"] ?>" <?= !empty($_GET['jenis_potongan']) && $_GET['jenis_potongan'] ==   $row["id"] ? 'selected' : '' ?>>
                                            <?php if (!empty($row["keterangan"])) : ?>
                                                <?= $row["nama"] ?> - <?= $row["keterangan"] ?> - <?= ucfirst("Rp ") . number_format($row["nominal"], 0, ",", ".") ?>
                                            <?php else : ?>
                                                <?= $row["nama"] ?> - <?= ucfirst("Rp ") . number_format($row["nominal"], 0, ",", ".") ?>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback errorJenisPotongan"></div>
                            </div>
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <?php $curYear = date('Y');
                                $curMonth = date('m');
                                $yearMonth = $curYear . $curMonth;
                                ?>
                                <select class="form-select select2" name="bulan" id="bulan">
                                    <option value="" selected disabled>Pilih</option>
                                    <option value="<?= $yearMonth  ?>" <?= !empty($_GET['bulan']) && $_GET['bulan'] ==  $yearMonth ? 'selected' : '' ?>>
                                        <?= $yearMonth  ?>
                                    </option>
                                    <?php foreach ($tahun_gajian as $row) : ?>
                                        <option value="<?= $row["bulan"] ?>" <?= !empty($_GET['bulan']) && $_GET['bulan'] ==  $row["bulan"] ? 'selected' : '' ?>>
                                            <?= $row["bulan"] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback errorBulan"></div>
                            </div>
                            <div class="mb-4">
                                <label for="potongan_rutin" class="form-label">Potongan Rutin Perbulan</label>
                                <select class="form-select select2" name="potongan_rutin" id="potongan_rutin">
                                    <option value="" selected>Pilih</option>
                                    <option value="Ya" <?= !empty($_GET['potongan_rutin']) && $_GET['potongan_rutin'] ==  "Ya" ? 'selected' : '' ?>>Ya</option>
                                    <option value="Tidak" <?= !empty($_GET['potongan_rutin']) && $_GET['potongan_rutin'] ==  "Tidak" ? 'selected' : '' ?>>Tidak</option>
                                </select>
                                <div class="invalid-feedback errorPotonganRutinPerbulan"></div>
                            </div>
                            <div class="mb-4 d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= base_url('administrator/payroll/potongan/list') ?>" class="btn btn-light me-md-2" type="button"><i class="fa fa-xmark me-2" aria-hidden="true"></i>Batal</a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search me-2" aria-hidden="true"></i>Cari</button>
                            </div>
                        </form>
                        <hr>

                        <div class="table-responsive mt-4">
                            <table class="datatable table table-sm table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Pegawai</th>
                                        <th>Potongan</th>
                                        <th>Nominal</th>
                                        <th>Status Kepegawaian</th>
                                        <!-- <th>Aksi</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($potongan_pegawai as $record) : ?>
                                        <tr>
                                            <th class="text-center"><?= $no++ ?>.</th>
                                            <td>
                                                <?=
                                                nama_gelar_belakang_ucwords(
                                                    $record['nama_depan'],
                                                    $record['nama_tengah'],
                                                    $record['nama_belakang'],
                                                    $record['gelar_depan'],
                                                    $record['gelar_belakang']
                                                )
                                                ?>
                                            </td>
                                            <td>
                                                <strong>
                                                    <?= $record['nama_potongan'] ?>
                                                </strong> <br>
                                                <small><?= $record['keterangan_potongan'] ?></small>
                                            </td>
                                            <td><?= format_rupiah($record['nominal']) ?></td>
                                            <td><?= $record['status_kepegawaian'] ?></td>
                                            <!-- <td>Aksi</td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Filter Search Potongan -->

                <!-- Isi page berakhir di sini -->
                <?php $this->load->view('_partials/footer') ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/script') ?>

    <!-- DataTables -->
    <script>
        function ShowLoading(message) {
            message = message || "";
            let opsi = {
                title: 'Mohon Tunggu !',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            };
            if (message !== "") {
                opsi.html = message;
            }
            Swal.fire(opsi);
        }

        $('#formSync').on('submit', function(e) {
            e.preventDefault();
            var form_data = $('#formSync').serializeArray();
            Swal.fire({
                title: "Sinkronkan Data?",
                html: "Data potongan untuk bulan <b>" + $('#bulan_sync').val() + "</b> akan disinkronkan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('administrator/payroll/sync-potongan') ?>",
                        dataType: "JSON",
                        data: form_data,
                        beforeSend: function() {
                            $("#btnSync").prop("disabled", true);
                            $('#btnSync').html('Proses');
                            ShowLoading();
                        },
                        complete: function() {
                            $("#btnSync").prop("disabled", false);
                            $('#btnSync').html('Sinkronkan');
                        },
                        success: function(data) {
                            if (data.type === 1) {
                                swal.close();
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: true,
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                            if (data.status == 0) {
                                swal.close();
                                if (data.error_message.bulan_sync) {
                                    $('#bulan_sync').addClass('is-invalid');
                                    $('.errorBulanSync').html(data.error_message.bulan_sync);
                                } else {
                                    $('#bulan_sync').removeClass('is-invalid');
                                    $('.errorBulanSync').html('');
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log('Error: ', err.Message);
                        }
                    });
                }
            });
        });

        $(document).ready(() => {
            $('select:not(.normal)').each(function() {
                $(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $(this).parent(),
                });
            });

            $('.datatable').DataTable({
                scrollCollapse: true,
                paging: true,
                scrollX: true,
                scrollY: 400,
                aLengthMenu: [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "All"]
                ],
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-6'B><'col-sm-12 col-md-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        });
    </script>
</body>

</html>