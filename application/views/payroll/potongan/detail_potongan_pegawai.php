<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
    <style>
        .card-header-custom {
            min-height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-custom {
            border-top: 2px solid #696cff;
        }

        span.select2-container {
            z-index: 10050;
        }
    </style>
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
                        <li class="breadcrumb-item"><a href="<?= base_url('administrator/payroll/potongan') ?>" class="text-muted">Potongan Pegawai</a></li>
                        <li class="breadcrumb-item text-primary">Detail</li>
                    </ol>
                </nav>
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Isi page mulai dari sini -->
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12 mb-4">
                            <div class="card flex-fill h-100 mb-3">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Profil</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content border-left-right overflow-auto">
                                        <?php if (($profil->kat_pegawai == "Dosen") && (!empty($profil->foto_peg))) : ?>
                                            <img alt="image" class="img-thumbnail img-fluid mx-auto d-block" style="max-height: 256px; xmin-width: 256px; margin: 10px auto;" src="https://mentari.umbandung.ac.id/uploads/foto-dosen/<?= $profil->foto_peg ?>" />
                                        <?php elseif (($profil->kat_pegawai == "Tenaga Kependidikan") && (!empty($profil->foto_peg))) : ?>
                                            <img alt="image" class="img-thumbnail img-fluid mx-auto d-block" style="max-height: 256px; xmin-width: 256px; margin: 10px auto;" src="https://mentari.umbandung.ac.id/uploads/foto-tendik/<?= $profil->foto_peg ?>" />
                                        <?php else : ?>
                                            <img alt="image" class="img-thumbnail img-fluid mx-auto d-block" style="max-height: 256px; xmin-width: 256px; margin: 10px auto;" src="https://cdn.landesa.org/wp-content/uploads/default-user-image.png" />
                                        <?php endif; ?>
                                        <table class="table table-hover">
                                            <tbody>
                                                <?php if ($profil->kat_pegawai == "Dosen") : ?>
                                                    <tr>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">NIDN</td>
                                                        <td>:</td>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">
                                                            <?= !empty($profil->nidn_nidk_nitk) ? $profil->nidn_nidk_nitk : '-' ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nomor Baku Muhammadiyah</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= !empty($profil->nbm) ? $profil->nbm : '-' ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nama</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?php
                                                        echo nama_lengkap_ucwords($profil->nama_depan, $profil->nama_tengah, $profil->nama_belakang)
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Gelar</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->gelar_depan . " " . $profil->gelar_belakang ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Jenis Kelamin</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->jenis_kelamin == 'L' ? 'Laki - laki' : 'Perempuan' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Tempat Lahir</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->tempat_lahir ?></td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid #e7eaec;">
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= empty($profil->tanggal_lahir) ? '-' : tanggal_indonesia($profil->tanggal_lahir) ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100 mb-3">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Kepegawaian</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <?php if ($profil->kat_pegawai == "Dosen") : ?>
                                                    <tr>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">Program Studi</td>
                                                        <td>:</td>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">
                                                            <?= $profil->nama_prodi ?>
                                                        </td>
                                                    </tr>
                                                <?php elseif ($profil->kat_pegawai == "Tenaga Kependidikan") : ?>
                                                    <tr>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">Unit Kerja</td>
                                                        <td>:</td>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">
                                                            <?= $profil->nama_divisi ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-5">NIP</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-5"><?= $profil->nip ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Status Kepegawaian</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->status_kepegawaian_nama ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Status</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->status_keaktifan_nama ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Pangkat/Golongan</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->golongan . " - " . $profil->pangkat ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Jabatan Akademik</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->nama_jabatan . " - " . $profil->angka_kredit ?></td>
                                                </tr>
                                                <?php if (!empty($profil->nama_jabatan_struktural)) : ?>
                                                    <tr>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">Jabatan Struktural</td>
                                                        <td>:</td>
                                                        <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->nama_jabatan_struktural ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr style="border-bottom: 1px solid #e7eaec;">
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Sumber Gaji</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->sumber_gaji ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100 mb-3">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Kependudukan</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nomor Induk Kependudukan</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->nik ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Kartu Tanda Penduduk</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?php if (empty($profil->dokumen_ktp)) : ?>
                                                            -
                                                        <?php else : ?>
                                                            <a href="https://mentari.umbandung.ac.id/uploads/dokumen-kependudukan/<?= $profil->dokumen_ktp ?>" target="_blank" class='btn btn-sm btn-info' data-bs-toggle="tooltip" data-bs-placement="left" title="Lihat dokumen">
                                                                Lihat Dokumen
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Kartu Keluarga</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?php if (empty($profil->dokumen_kartu_keluarga)) : ?>
                                                            -
                                                        <?php else : ?>
                                                            <a href="https://mentari.umbandung.ac.id/uploads/dokumen-kependudukan/<?= $profil->dokumen_kartu_keluarga ?>" target="_blank" class='btn btn-sm btn-info' data-bs-toggle="tooltip" data-bs-placement="left" title="Lihat dokumen">
                                                                Lihat Dokumen
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Agama</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->agama_nama ?>
                                                    </td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid #e7eaec;">
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Kewarganegaraan</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->kewarganegaraan ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Alamat dan Kontak</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Email Kampus</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->email_kampus ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Email Pribadi</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->email_pribadi ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Alamat</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->alamat ?>
                                                    </td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid #e7eaec;">
                                                    <td class="col-lg-6 col-md-3 col-xs-12">No. HP</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->kontak ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Keluarga</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Status Perkawinan</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->status_pernikahan ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nama Suami/Istri</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= strtoupper($profil->nama_pasangan) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Pekerjaan Suami/Istri</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->pekerjaan_pasangan ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Lain - lain</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nomor Pokok Wajib Pajak</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->no_npwp ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Dokumen NPWP</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?php if (empty($profil->dokumen_npwp)) : ?>
                                                            -
                                                        <?php else : ?>
                                                            <a href="http://mentari.umbandung.ac.id/uploads/dokumen-lain-lain/<?= $profil->dokumen_npwp ?>" target="_blank" class='btn btn-sm btn-info' data-bs-toggle="tooltip" data-bs-placement="left" title="Lihat dokumen">
                                                                Lihat Dokumen
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nama Wajib Pajak</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= strtoupper($profil->nama_wajib_pajak) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">PUBLONS ID</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->publons_id ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">SCOPUS ID</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->scopus_id ?></td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid #e7eaec;">
                                                    <td class="col-lg-6 col-md-3 col-xs-12">SINTA ID</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12"><?= $profil->sinta_id ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Gaji dan Tunjangan</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Gaji Pokok</td>
                                                    <td>:</td>
                                                    <?php if (!empty($profil->nominal_gaji)) : ?>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">
                                                            <span class="badge bg-primary">
                                                                <strong>
                                                                    <?= ucfirst("Rp ") . number_format($profil->nominal_gaji, 0, ",", ".") ?>
                                                                </strong>
                                                            </span>
                                                        </td>
                                                    <?php else : ?>
                                                        <td class="col-lg-6 col-md-3 col-xs-12">
                                                            -
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover table-striped mt-4">
                                            <tr>
                                                <td class="col-lg-6 col-md-3 col-xs-12"><strong>Tunjangan</strong></td>
                                                <td class="col-lg-6 col-md-3 col-xs-12">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                        <div class="demo-inline-spacing mt-0">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    Jabatan Struktural
                                                    <strong>
                                                        <?= format_rupiah($tunjangan->tunjangan_struktural) ?>
                                                    </strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Riwayat Potongan</strong></h4>
                                        </div>
                                        <div class="p-1 ms-auto">
                                            <span data-bs-toggle="modal" data-bs-target="#tambahPotonganModal">
                                                <button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="left" title="Tambah Data">
                                                    Tambah potongan
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="datatable table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Bulan</th>
                                                    <th>Potongan</th>
                                                    <th>Nominal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1 ?>
                                                <?php foreach ($potongan as $row) : ?>
                                                    <tr>
                                                        <td class="text-center"><strong><?= $no++ ?>.</strong></td>
                                                        <td><?= $row["bulan"] ?></td>
                                                        <td><?= $row["nama"] ?></td>
                                                        <td><?= ucfirst("Rp ") . number_format($row["nominal"], 0, ",", ".") ?></td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <!-- <span data-bs-toggle="modal" data-bs-target="#editPotonganModal">
                                                                        <button onclick="editDataPotongan('<?= $row['gaji_potongan_trans_id'] ?>')" type="button" class="btn btn-sm btn-icon btn-outline-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data">
                                                                            <span class="tf-icons bx bx-edit"></span>
                                                                        </button>
                                                                    </span> -->
                                                                <button onclick="hapusDataPotongan('<?= $row['gaji_potongan_trans_id'] ?>','<?= $row['gaji_potongan_ref_id'] ?>','<?= $row['pegawai_id'] ?>')" type="button" class="btn btn-sm btn-icon btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
                                                                    Hapus
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12 fright mb-4">
                            <div class="card flex-fill h-100 mb-3">
                                <div class="card-header">
                                    <div class="d-flex">
                                        <div class="p-1">
                                            <h4><strong>Rekening</strong></h4>
                                        </div>
                                        <div class="p-1 ms-auto">
                                            <span data-bs-toggle="modal" data-bs-target="#editRekeningModal">
                                                <button class='btn btn-sm btn-primary' data-bs-toggle="tooltip" data-bs-placement="left" title="Perubahan Data" onclick="editRekeningDosen('<?= $profil->rekening_id ?>')">
                                                    Edit
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="ibox-content overflow-auto">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Nomor Rekening</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->no_rekening ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Bank</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->bank ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">Keterangan</td>
                                                    <td>:</td>
                                                    <td class="col-lg-6 col-md-3 col-xs-12">
                                                        <?= $profil->keterangan_rekening ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Isi page berakhir di sini -->
                </div>
                <!-- Isi page berakhir di sini -->
                <?php $this->load->view('_partials/footer') ?>
            </div>
        </div>
    </div>

    <!-- load view modal edit  -->
    <?php $this->load->view('payroll/potongan/modal_detail_potongan_pegawai'); ?>

    <?php $this->load->view('_partials/script') ?>

    <!-- DataTables -->
    <script>
        function selectRefresh() {
            $('select:not(.normal)').select2({
                //-^^^^^^^^--- update here
                // tags: true,
                width: '100%',
                theme: 'bootstrap-5',
                dropdownParent: $("#tambahPotonganModal")
            });
        }

        // store potongan
        $('#formPotongan').on('submit', function(e) {
            e.preventDefault();
            var form_data = $('#formPotongan').serializeArray();
            form_data.push({
                name: "tipe-edit",
                value: "tambah-potongan-dosen"
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('administrator/payroll/potongan/add-potongan') ?>",
                dataType: "JSON",
                data: form_data,
                beforeSend: function() {
                    $(".buttonSimpan").prop("disabled", true);
                    $('.buttonSimpan').html('<i class="fa fa-spinner" aria-hidden="true" fa-spin></i> Mengirim');
                },
                complete: function() {
                    $(".buttonSimpan").prop("disabled", false);
                    $('.buttonSimpan').html('Simpan Data');
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
                        if (data.error_message.bulan_potongan) {
                            $('#bulan_potongan').addClass('is-invalid');
                            $('.errorBulanPotongan').html(data.error_message.bulan_potongan);
                        } else {
                            $('#bulan_potongan').removeClass('is-invalid');
                            $('.errorBulanPotongan').html('');
                        }
                        if (data.error_message.potongan) {
                            $('#potongan').addClass('is-invalid');
                            $('.errorPotongan').html(data.error_message.potongan);
                        } else {
                            $('#potongan').removeClass('is-invalid');
                            $('.errorPotongan').html('');
                        }
                        if (data.error_message.potongan_perbulan) {
                            $('#potongan_perbulan').addClass('is-invalid');
                            $('.errorPotonganPerbulan').html(data.error_message.potongan_perbulan);
                        } else {
                            $('#potongan_perbulan').removeClass('is-invalid');
                            $('.errorPotonganPerbulan').html('');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('Error: ', err.Message);
                }
            });
        });
        // delete potongan
        function hapusDataPotongan(id, ref_potongan, pegawai) {
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
                        url: "<?php echo site_url('administrator/payroll/potongan/destroy-potongan'); ?>",
                        method: "POST",
                        data: {
                            id: id,
                            ref_potongan: ref_potongan,
                            pegawai: pegawai,
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

        // edit Rekening Dosen
        function editRekeningDosen(id) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('administrator/payroll/potongan/get-rekening') ?>",
                dataType: "JSON",
                data: {
                    'rekening-id': id,
                },
                success: function(value) {
                    if (value.type === 1) {
                        $('#no_rekening').val(value.data.no_rekening);
                        $('#bank').val(value.data.bank);
                        $('#keterangan').val(value.data.keterangan);
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('Error: ', err.Message);
                }
            });
        }
        // update Rekening Dosen
        $('#formRekening').on('submit', function(e) {
            e.preventDefault();
            var form_data = $('#formRekening').serializeArray();
            form_data.push({
                name: "tipe-edit",
                value: "edit-rekening-dosen"
            });

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('administrator/payroll/potongan/update-rekening') ?>",
                dataType: "JSON",
                data: form_data,
                beforeSend: function() {
                    $(".buttonSimpan").prop("disabled", true);
                    $('.buttonSimpan').html('<i class="fa fa-spinner" aria-hidden="true" fa-spin></i> Mengirim');
                },
                complete: function() {
                    $(".buttonSimpan").prop("disabled", false);
                    $('.buttonSimpan').html('Simpan Data');
                },
                success: function(data) {
                    if (data.status === 1) {
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
                        if (data.error_message.no_rekening) {
                            $('#no_rekening').addClass('is-invalid');
                            $('.errorNoRekening').html(data.error_message.no_rekening);
                        } else {
                            $('#no_rekening').removeClass('is-invalid');
                            $('.errorNoRekening').html('');
                        }
                        if (data.error_message.bank) {
                            $('#bank').addClass('is-invalid');
                            $('.errorBank').html(data.error_message.bank);
                        } else {
                            $('#bank').removeClass('is-invalid');
                            $('.errorBank').html('');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    console.log('Error: ', err.Message);
                }
            });
        });

        $(document).ready(() => {
            selectRefresh();
            $(".datatable").DataTable({});
        });
    </script>
</body>

</html>