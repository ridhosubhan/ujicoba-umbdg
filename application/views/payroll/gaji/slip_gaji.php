<html>

<head>
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span {
            font-family: Helvetica, Tahoma, sans-serif;
            font-size: 10pt;
        }

        @page {
            margin: 0.5cm 1.5cm;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 8pt;
            padding: 0;
            width: 100%;
        }

        th {
            background-color: silver;
            border: 1px solid black;
            padding: 0.2rem;
        }

        td {
            border: 1px solid black;
            padding: 0.2rem;
        }

        header>img {
            width: 720px;
        }

        main>h1 {
            font-size: 14pt;
            margin: 0.3rem 0 0 0;
            text-align: center;
        }

        footer {
            position: absolute;
            bottom: 0;
        }

        footer>img {
            width: 700px;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .line-height-p {
            line-height: 225%;
        }
    </style>
</head>
<title><?= $title ?></title>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
        <img src="/var/www/html/keuangan/assets/kop/kop-header-surat.png" alt="Kop Header">
        <!-- <img src="<?= base_url() ?>assets/kop/kop-header.png" alt="Kop Header"> -->
        <hr style="height:1px; color:black; background-color:black">
    </header>

    <footer>
        <img src="/var/www/html/keuangan/assets/kop/kop-footer.png" alt="Kop Header">
        <!-- <img src="<?= base_url() ?>assets/kop/kop-footer.png" alt="Kop Footer"> -->
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <h4 style="margin-top:0.1cm; text-align: center;">
            <u>SLIP GAJI DOSEN/KARYAWAN</u> <br>
            <u><?= bulan_panjang(substr($data_remun_dosen['bulan'], -2)) ?> <?= substr($data_remun_dosen['bulan'], 0, 4) ?></u>
        </h4>

        <table style="width:100%; border:none; border-collapse:collapse; margin-bottom: 1rem">
            <tr>
                <td style="border: none;" width="30%">
                    <p>
                        <span>Nama</span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="68%">
                    <p>
                        <span>
                            <strong>
                                <?= $data_remun_dosen['nama_lengkap'] ?>
                            </strong>
                        </span>
                    </p>
                </td>
            </tr>
            <!-- <tr>
                <td style="border: none;" width="30%">
                    <p>
                        <span>Pangkat / Golongan</span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="68%">
                    <p>
                        <span>
                            <?= $data_pegawai->golongan . " / " . $data_pegawai->pangkat ?>
                        </span>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="border: none;" width="30%">
                    <p>
                        <span>Status</span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="68%">
                    <p>
                        <span>
                            <?= $data_pegawai->status_kepegawaian_nama ?>
                        </span>
                    </p>
                </td>
            </tr> -->
            <!-- <?php if (!empty($data_pegawai->nama_jabatan)) : ?>
                <tr>
                    <td style="border: none;" width="30%">
                        <p>
                            <span>Jabatan Akademik</span>
                        </p>
                    </td>
                    <td style="border: none;">
                        <p>
                            <span>:</span>
                        </p>
                    </td>
                    <td style="border: none;" width="68%">
                        <p>
                            <span>
                                <?= $data_pegawai->nama_jabatan . " - " . $data_pegawai->angka_kredit ?>
                            </span>
                        </p>
                    </td>
                </tr>
            <?php endif; ?> -->
            <?php if (!empty($jabatan_struktural_aktif) && empty($jabatan_struktural_history)) : ?>
                <tr>
                    <td style="border: none;" width="30%">
                        <p>
                            <span>Jabatan Struktural</span>
                        </p>
                    </td>
                    <td style="border: none;">
                        <p>
                            <span>:</span>
                        </p>
                    </td>
                    <td style="border: none;" width="68%">
                        <p>
                            <span>
                                <?= $jabatan_struktural_aktif->nama_jabatan ?> -
                                <?php if (!empty($jabatan_struktural_aktif->nomenklatur_lain)) : ?>
                                    <?= $jabatan_struktural_aktif->nomenklatur_lain ?>
                                <?php elseif (!empty($jabatan_struktural_aktif->unit_kerja)) : ?>
                                    <?= $jabatan_struktural_aktif->unit_kerja ?>
                                    <?php if (!empty($jabatan_struktural_aktif->nama_pusat_studi)) : ?>
                                        <ul>
                                            <li class="fw-bold">
                                                <?= $jabatan_struktural_aktif->nama_pusat_studi ?>
                                            </li>
                                        </ul>
                                    <?php elseif (!empty($jabatan_struktural_aktif->unit_gugus_mutu_nama)) : ?>
                                        <ul>
                                            <li class="fw-bold">
                                                <?= $jabatan_struktural_aktif->unit_gugus_mutu_nama ?> <?= !empty($jabatan_struktural_aktif->nama_fakultas) ? ' - ' . $jabatan_struktural_aktif->nama_fakultas : (!empty($jabatan_struktural_aktif->nama_prodi) ? ' - ' . $jabatan_struktural_aktif->nama_prodi : '') ?>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                <?php elseif (!empty($jabatan_struktural_aktif->nama_fakultas) && empty($jabatan_struktural_aktif->nama_prodi)) : ?>
                                    <?= $jabatan_struktural_aktif->nama_fakultas ?>
                                <?php elseif (!empty($jabatan_struktural_aktif->nama_fakultas) && !empty($jabatan_struktural_aktif->nama_prodi)) : ?>
                                    <?= $jabatan_struktural_aktif->nama_fakultas ?>
                                    <ul>
                                        <li class="fw-bold">
                                            <?= $jabatan_struktural_aktif->nama_prodi ?>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </span>
                        </p>
                    </td>
                </tr>
            <?php elseif (empty($jabatan_struktural_aktif) && !empty($jabatan_struktural_history)) : ?>
                <tr>
                    <td style="border: none;" width="30%">
                        <p>
                            <span>Jabatan Struktural</span>
                        </p>
                    </td>
                    <td style="border: none;">
                        <p>
                            <span>:</span>
                        </p>
                    </td>
                    <td style="border: none;" width="68%">
                        <p>
                            <span>
                                <?= $jabatan_struktural_history->nama_jabatan ?> -
                                <?php if (!empty($jabatan_struktural_history->nomenklatur_lain)) : ?>
                                    <?= $jabatan_struktural_history->nomenklatur_lain ?>
                                <?php elseif (!empty($jabatan_struktural_history->unit_kerja)) : ?>
                                    <?= $jabatan_struktural_history->unit_kerja ?>
                                    <?php if (!empty($jabatan_struktural_history->nama_pusat_studi)) : ?>
                                        <ul>
                                            <li class="fw-bold">
                                                <?= $jabatan_struktural_history->nama_pusat_studi ?>
                                            </li>
                                        </ul>
                                    <?php elseif (!empty($jabatan_struktural_history->unit_gugus_mutu_nama)) : ?>
                                        <ul>
                                            <li class="fw-bold">
                                                <?= $jabatan_struktural_history->unit_gugus_mutu_nama ?> <?= !empty($jabatan_struktural_history->nama_fakultas) ? ' - ' . $jabatan_struktural_history->nama_fakultas : (!empty($jabatan_struktural_history->nama_prodi) ? ' - ' . $jabatan_struktural_history->nama_prodi : '') ?>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                <?php elseif (!empty($jabatan_struktural_history->nama_fakultas) && empty($jabatan_struktural_history->nama_prodi)) : ?>
                                    <?= $jabatan_struktural_history->nama_fakultas ?>
                                <?php elseif (!empty($jabatan_struktural_history->nama_fakultas) && !empty($jabatan_struktural_history->nama_prodi)) : ?>
                                    <?= $jabatan_struktural_history->nama_fakultas ?>
                                    <ul>
                                        <li class="fw-bold">
                                            <?= $jabatan_struktural_history->nama_prodi ?>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </span>
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
        </table>



        <ol type="I">
            <li style="font-weight:bold;">
                <u>PENGHASILAN</u>
            </li>
        </ol>
        <table style="width:100%; border:none; border-collapse:collapse; margin-bottom: 1rem">
            <tr>
                <td style="border: none; padding-left: 6%;" width="65%">
                    <p>
                        <span>Gaji Pokok</span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="33%">
                    <p>
                        <span><?= format_rupiah($data_pegawai->gaji_generate_gaji_pokok) ?></span>
                    </p>
                </td>
            </tr>
            <?php if (!empty($data_pegawai->gaji_rapel) && $data_pegawai->gaji_rapel > 0) : ?>
                <tr>
                    <td style="border: none; padding-left: 6%;" width="65%">
                        <p>
                            <span>Gaji Rapel</span>
                        </p>
                    </td>
                    <td style="border: none;">
                        <p>
                            <span>:</span>
                        </p>
                    </td>
                    <td style="border: none;" width="33%">
                        <p>
                            <span><?= format_rupiah($data_pegawai->gaji_rapel) ?></span>
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if (!empty($jabatan_struktural_aktif) || !empty($jabatan_struktural_history)) : ?>
                <tr>
                    <td style="border: none; padding-left: 6%;" width="65%">
                        <p>
                            <span>Tunjangan Jabatan Struktural</span>
                        </p>
                    </td>
                    <td style="border: none;">
                        <p>
                            <span>:</span>
                        </p>
                    </td>
                    <td style="border: none;" width="33%">
                        <p>
                            <span><?= format_rupiah($data_pegawai->gaji_generate_t_jabatan_struktural); ?></span>
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="border: none; padding-left: 6%;" width="65%">
                    <p>
                        <span>Tunjangan Kehadiran</span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="33%">
                    <p>
                        <span>
                            <?php
                            $tunjangan_kehadiran = empty($data_kehadiran_single->total) ? 0 :  $data_kehadiran_single->total;
                            ?>
                            <?= format_rupiah($tunjangan_kehadiran); ?>
                        </span>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="border: none; padding-left: 6%;" width="65%">
                    <p>
                        <span>Tunjangan Lembur</span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="33%">
                    <p>
                        <span>
                            <?php
                            $tunjangan_lembur =  0;
                            if (empty($data_lembur_single->total_nilai) && empty($data_lembur_single->nilai_bulk)) {
                                $tunjangan_lembur =  0;
                            } else if (!empty($data_lembur_single->total_nilai)) {
                                $tunjangan_lembur = $data_lembur_single->total_nilai;
                            } else if (!empty($data_lembur_single->nilai_bulk)) {
                                $tunjangan_lembur = $data_lembur_single->nilai_bulk;
                            }
                            ?>
                            <?= format_rupiah($tunjangan_lembur); ?>
                        </span>
                    </p>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="border: none; padding-left: 6%;" width="65%">
                    <p>
                        <span><strong>TOTAL PENGHASILAN (A)</strong></span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="33%">
                    <p>
                        <span>
                            <strong>
                                <?php
                                $jumlah_penghasilan = $data_pegawai->gaji_generate_gaji_pokok +
                                    $data_pegawai->gaji_rapel +
                                    $data_pegawai->gaji_generate_t_jabatan_struktural +
                                    $tunjangan_kehadiran + $tunjangan_lembur
                                ?>
                                <?= format_rupiah($jumlah_penghasilan); ?>
                            </strong>
                        </span>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>

        <ol type="I" start="2">
            <li style="font-weight:bold;">
                <u>POTONGAN</u>
            </li>
        </ol>

        <table style="width:100%; border:none; border-collapse:collapse; margin-bottom: 1rem">
            <?php foreach ($data_potongan as $row) : ?>
                <tr>
                    <td style="border: none; padding-left: 6%;" width="65%">
                        <p>
                            <span><?= ucwords($row["nama"]) ?></span>
                        </p>
                    </td>
                    <td style="border: none;">
                        <p>
                            <span>:</span>
                        </p>
                    </td>
                    <td style="border: none;" width="33%">
                        <p>
                            <span>
                                <?= format_rupiah($row["nominal"]); ?>
                            </span>
                        </p>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td style="border: none; padding-left: 6%;" width="65%">
                    <p>
                        <span><strong>TOTAL POTONGAN (B)</strong></span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="33%">
                    <p>
                        <span>
                            <strong>
                                <?= format_rupiah($total_potongan->nominal_potongan); ?>
                            </strong>
                        </span>
                    </p>
                </td>
            </tr>
        </table>

        <br>

        <table style="width:100%; border:none; border-collapse:collapse; margin-bottom: 1rem">
            <tr>
                <td style="border: none; padding-left:6%;" width="65%">
                    <p>
                        <span><strong>PENERIMAAN BERSIH (A - B) </strong></span>
                    </p>
                </td>
                <td style="border: none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border: none;" width="33%">
                    <p>
                        <span>
                            <strong>
                                <?php
                                $gaji_bersih = $jumlah_penghasilan - $total_potongan->nominal_potongan;
                                ?>
                                <?= format_rupiah($gaji_bersih); ?>
                            </strong>
                        </span>
                    </p>
                </td>
            </tr>
        </table>

        <table style="width:100%; border:none; border-collapse:collapse; margin-bottom: 1rem">
            <tr>
                <td style="padding-left: 6%;">
                    <p>
                        <span><strong><?= ucwords(\Nasution\Terbilang::convert($gaji_bersih)) ?> Rupiah</strong></span>
                    </p>
                </td>
            </tr>
        </table>

        <table style="margin-top: 2rem">
            <tr>
                <td style="border: none; width: 50%;"></td>
                <td class="center" style="border: none">
                    <p>
                        Bandung, <?= bulan_panjang(substr($data_remun_dosen['bulan'], -2)) ?> <?= substr($data_remun_dosen['bulan'], 0, 4) ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="center" style="border: none; padding-top: 0.5rem; width: 50%;"></td>
                <td class="center" style="border: none; padding-top: 0.5rem;">
                    <p>Kepala Bagian Keuangan</p>
                </td>
            </tr>
            <tr>
                <td style="border: none; padding-top: 5rem;"></td>
            </tr>
            <tr>
                <td class="bold center" style="border: none; padding: 0; text-decoration: underline; width: 50%;"></td>
                <td class="bold center" style="border: none; padding: 0; text-decoration: underline;">
                    <p>
                        <span>
                            <strong>
                                <?= nama_gelar_lengkap_ucwords(
                                    $kepala_bagian_keuangan->nama_depan,
                                    $kepala_bagian_keuangan->nama_tengah,
                                    $kepala_bagian_keuangan->nama_belakang,
                                    $kepala_bagian_keuangan->gelar_depan,
                                    $kepala_bagian_keuangan->gelar_belakang
                                ) ?>
                            </strong>
                        </span>
                    </p>
                </td>
            </tr>
        </table>

    </main>
</body>

</html>