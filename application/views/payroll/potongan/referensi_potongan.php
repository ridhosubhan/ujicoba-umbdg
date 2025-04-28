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
                        <li class="breadcrumb-item text-primary">Referensi Potongan</li>
                    </ol>
                </nav>
                <div class="card">

                    <!-- Modal Tambah Data -->
                    <div class="modal fade" id="modalTambahData" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog">
                            <form class="modal-content" id="formTambahData">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="backDropModalTitle"><strong>Tambah Data</strong></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <input type="hidden" id="store_id" name="store_id" class="form-control" readonly>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                            <label for="nama_potongan" class="form-label">Nama Potongan <span class="text-danger">*</span></label>
                                            <input type="text" id="nama_potongan" name="nama_potongan" class="form-control" placeholder="Nama Potongan">
                                            <div class="invalid-feedback errorNamaPotongan"></div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                            <label for="nominal_potongan" class="form-label">Nominal Potongan <span class="text-danger">*</span></label>
                                            <input type="number" id="nominal_potongan" name="nominal_potongan" class="form-control" placeholder="Nominal Potongan">
                                            <div class="invalid-feedback errorNominalPotongan"></div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                            <label for="keterangan" class="form-label">Keterangan</label>
                                            <textarea type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                            <div class="invalid-feedback errorKeterangan"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button id="buttonSimpan" type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal Tambah Data -->

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="modalEditData" data-bs-backdrop="static" tabindex="-1">
                        <div class="modal-dialog">
                            <form class="modal-content" id="formEditData">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="backDropModalTitle"><strong>Edit Data</strong></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <input type="hidden" id="edit_id" name="edit_id" class="form-control" readonly>
                                <div class="modal-body">
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                            <label for="edit_nama_potongan" class="form-label">Nama Potongan <span class="text-danger">*</span></label>
                                            <input type="text" id="edit_nama_potongan" name="edit_nama_potongan" class="form-control" placeholder="Nama Potongan">
                                            <div class="invalid-feedback errorEditNamaPotongan"></div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                            <label for="edit_nominal_potongan" class="form-label">Nominal Potongan <span class="text-danger">*</span></label>
                                            <input type="number" id="edit_nominal_potongan" name="edit_nominal_potongan" class="form-control" placeholder="Nominal Potongan">
                                            <div class="invalid-feedback errorEditNominalPotongan"></div>
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col mb-3">
                                            <label for="edit_keterangan" class="form-label">Keterangan</label>
                                            <textarea type="text" id="edit_keterangan" name="edit_keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                            <div class="invalid-feedback errorEditKeterangan"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button id="buttonEdit" type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal Edit Data -->

                    <div class="card-body">
                        <h4 class="mb-3"><strong>Data Referensi Potongan</strong></h4>
                        <button type="button" class="btn btn-sm btn-primary mt-2 mb-4" data-bs-toggle="modal" data-bs-target="#modalTambahData">
                            <i class="tf-icons bx bx-plus-circle me-1"></i>Tambah Data
                        </button>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-sm table-hover table-bordered table-striped" id="table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama Potongan - Keterangan</th>
                                        <th class="text-center">Nominal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    <?php foreach ($potongan as $row) : ?>
                                        <tr>
                                            <td class="text-center"><strong><?= $no++ . "." ?></strong></td>
                                            <td>
                                                <strong><?= $row['nama'] ?></strong><br>
                                                <small>
                                                    <?= $row['keterangan'] ?>
                                                </small>
                                            </td>
                                            <td>
                                                <?= format_rupiah($row['nominal']) ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a onclick="editData('<?= $row['id'] ?>')" type="button" class="btn btn-sm btn-icon btn-success me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data">
                                                        <i class="ti ti-pencil-alt"></i> Edit
                                                    </a>
                                                    <button onclick="hapusData('<?= $row['id'] ?>')" type="button" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
                                                        <i class="tf-icons bx bxs-trash"></i> delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
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
        function editData(id) {
            const modalEditAkun = new bootstrap.Modal('#modalEditData', {
                keyboard: false,
                backdrop: 'static'
            }).show();

            $.ajax({
                type: "POST",
                data: {
                    id: id,
                },
                async: true,
                dataType: 'json',
                url: "<?php echo site_url('administrator/payroll/referensi-potongan/edit'); ?>",
                success: function(response) {
                    if (response.status === 200) {
                        $('#edit_id').val(response.data.id);
                        $('#edit_nama_potongan').val(response.data.nama);
                        $('#edit_nominal_potongan').val(response.data.nominal);
                        $('#edit_keterangan').val(response.data.keterangan);
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('Error: ', err.Message);
                }
            });
        }

        function hapusData(id) {
            Swal.fire({
                title: 'Yakin?',
                text: "Data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo site_url('administrator/payroll/referensi-potongan/destroy'); ?>",
                        method: "POST",
                        data: {
                            id: id
                        },
                        async: true,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 1) {
                                Swal.fire(
                                    'Sukses!',
                                    response.message,
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                }
            });
        }

        $(document).ready(() => {
            $('.select2').select2({
                theme: 'bootstrap-5',
            });

            const table = new DataTable('#table', {});

            $('#formTambahData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    data: $('#formTambahData').serialize(),
                    async: true,
                    dataType: 'json',
                    url: "<?php echo site_url('administrator/payroll/referensi-potongan/store'); ?>",
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
                            if (response.error_message.nama_potongan) {
                                $('#nama_potongan').addClass('is-invalid');
                                $('.errorNamaPotongan').html(response.error_message.nama_potongan);
                            } else {
                                $('#nama_potongan').removeClass('is-invalid');
                                $('.errorNamaPotongan').html('');
                            }
                            if (response.error_message.nominal_potongan) {
                                $('#nominal_potongan').addClass('is-invalid');
                                $('.errorNominalPotongan').html(response.error_message.nominal_potongan);
                            } else {
                                $('#nominal_potongan').removeClass('is-invalid');
                                $('.errorNominalPotongan').html('');
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

            $('#formEditData').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    data: $('#formEditData').serialize(),
                    async: true,
                    dataType: 'json',
                    url: "<?php echo site_url('administrator/payroll/referensi-potongan/update'); ?>",
                    beforeSend: function() {
                        $("#buttonEdit").prop("disabled", true);
                        $('#buttonEdit').html('<i class="bx bx-loader-circle bx-spin"></i> Mengirim');
                    },
                    complete: function() {
                        $("#buttonEdit").prop("disabled", false);
                        $('#buttonEdit').html('<i class="bx bx-save me-1"></i>Edit');
                    },
                    success: function(response) {
                        if (response.status === 0) {
                            if (response.error_message.edit_nama_potongan) {
                                $('#edit_nama_potongan').addClass('is-invalid');
                                $('.errorEditNamaPotongan').html(response.error_message.edit_nama_potongan);
                            } else {
                                $('#edit_nama_potongan').removeClass('is-invalid');
                                $('.errorEditNamaPotongan').html('');
                            }
                            if (response.error_message.edit_nominal_potongan) {
                                $('#edit_nominal_potongan').addClass('is-invalid');
                                $('.errorEditNominalPotongan').html(response.error_message.edit_nominal_potongan);
                            } else {
                                $('#edit_nominal_potongan').removeClass('is-invalid');
                                $('.errorEditNominalPotongan').html('');
                            }
                            if (response.error_message.edit_keterangan) {
                                $('#edit_keterangan').addClass('is-invalid');
                                $('.errorEditKeterangan').html(response.error_message.edit_keterangan);
                            } else {
                                $('#edit_keterangan').removeClass('is-invalid');
                                $('.errorEditKeterangan').html('');
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
        });
    </script>
</body>

</html>