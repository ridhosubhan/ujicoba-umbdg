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
                        <li class="breadcrumb-item">Potongan Pegawai</li>
                        <li class="breadcrumb-item text-primary">Upload</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-1"><strong>Upload Potongan</strong></h4> <br>
                        <div class="mb-2">
                            <label for="upload_potongan" class="form-label">Download Excel Template File
                                <a href="<?= base_url('administrator/payroll/potongan/upload-template') ?>" target="_blank" class="btn btn-outline-success ms-4"><i class="fa fa-solid fa-file-excel-o me-2"></i>Excel Template</a>
                            </label>
                        </div>
                        <hr>

                        <form id="formUploadPotongan" method="POST">
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <?php $curYear = date('Y');
                                $curMonth = date('m');
                                $yearMonth = $curYear . $curMonth;
                                ?>
                                <select class="form-select select2" name="bulan" id="bulan">
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
                                <div class="invalid-feedback errorBulan"></div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_potongan" class="form-label">Potongan</label>
                                <select class="form-select select2" name="jenis_potongan" id="jenis_potongan">
                                    <option value="" selected disabled>Pilih</option>
                                    <?php foreach ($ref_potongan as $row) : ?>
                                        <option value="<?= $row["id"] ?>">
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
                            <div class="mb-2">
                                <label for="upload_potongan" class="form-label">Upload Potongan</label>
                                <input type="file" class="form-control" name="upload_potongan" id="upload_potongan">
                                <div class="invalid-feedback errorUploadPotongan"></div>
                            </div>
                            <div class="mb-4">
                                <button class="btn btn-primary float-end mb-4 rounded-2"><i class="fa fa-upload me-2" aria-hidden="true"></i>Upload</button>
                            </div>
                        </form>
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
            $('select:not(.normal)').each(function() {
                $(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $(this).parent(),
                });
            });

            $('#table').DataTable({
                scrollCollapse: true,
                paging: true,
                scrollX: true,
                scrollY: 400,
                aLengthMenu: [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "All"]
                ],
                dom: "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        });

        $('#formUploadPotongan').on('submit', function(e) {
            e.preventDefault();
            var form_data = new FormData($('#formUploadPotongan')[0]);
            $.ajax({
                type: "POST",
                data: form_data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                url: "<?php echo site_url('administrator/payroll/potongan/upload-store'); ?>",
                beforeSend: function() {
                    $("#buttonSimpan").prop("disabled", true);
                    $('#buttonSimpan').html('<i class="bx bx-loader-circle bx-spin"></i> Mengirim');
                },
                complete: function() {
                    $("#buttonSimpan").prop("disabled", false);
                    $('#buttonSimpan').html('<i class="bx bx-save me-1"></i>Simpan');
                },
                success: function(response) {
                    if (response.status === 0) {
                        if (response.error_message.bulan) {
                            $('#bulan').addClass('is-invalid');
                            $('.errorBulan').html(response.error_message.bulan);
                        } else {
                            $('#bulan').removeClass('is-invalid');
                            $('.errorBulan').html('');
                        }
                        if (response.error_message.jenis_potongan) {
                            $('#jenis_potongan').addClass('is-invalid');
                            $('.errorJenisPotongan').html(response.error_message.jenis_potongan);
                        } else {
                            $('#jenis_potongan').removeClass('is-invalid');
                            $('.errorJenisPotongan').html('');
                        }
                        if (response.error_message.upload_potongan) {
                            $('#upload_potongan').addClass('is-invalid');
                            $('.errorUploadPotongan').html(response.error_message.upload_potongan);
                        } else {
                            $('#upload_potongan').removeClass('is-invalid');
                            $('.errorUploadPotongan').html('');
                        }
                    }

                    if (response.status === 1) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('Error: ', err.Message);
                }
            });
        });
    </script>
</body>

</html>