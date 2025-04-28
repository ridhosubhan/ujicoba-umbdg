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
        <!-- <img src="/var/www/html/keuangan/assets/kop/kop-header-surat.png" alt="Kop Header"> -->
        <img src="<?= base_url() ?>assets/kop/kop-header.png" alt="Kop Header">
        <hr style="height:1px; color:black; background-color:black">
    </header>

    <footer>
        <!-- <img src="/var/www/html/keuangan/assets/kop/kop-footer.png" alt="Kop Header"> -->
        <img src="<?= base_url() ?>assets/kop/kop-footer.png" alt="Kop Footer">
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <h4 style="margin-top:0.1cm; text-align: center;">
            <u>SLIP GAJI DOSEN / KARYAWAN</u>
        </h4>
        <p>
            Yang Bertanda tangan di bawah ini,
        </p>

        <table width="100%" style="border:none; border-collapse:collapse; margin-bottom: 1rem">
            <tr>
                <td style="border:none;" width="30%">
                    <p>
                        <span>Nama</span>
                    </p>
                </td>
                <td style="border:none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border:none; padding-left:0px;" width="68%">
                    <p>
                        <span><strong>Abin Suarsa, SE., MM., CESF., CSRS.</strong></span>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="border:none;" width="30%">
                    <p>
                        <span>Pangkat / Golongan</span>
                    </p>
                </td>
                <td style="border:none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border:none;" width="68%">
                    <p>
                        <span><strong>Penata Muda Tingkat I / III/b</strong></span>
                    </p>
                </td>
            </tr>
            <tr>
                <td style="border:none;" width="30%">
                    <p>
                        <span>Jabatan</span>
                    </p>
                </td>
                <td style="border:none;">
                    <p>
                        <span>:</span>
                    </p>
                </td>
                <td style="border:none;" width="68%">
                    <p>
                        <span>Kepala Bagian Keuangan</span>
                    </p>
                </td>
            </tr>
        </table>

        <p>
            dengan ini menerangkan dengan sesungguhnya bahwa :
        </p>

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
            <tr>
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
                            <strong>
                                <?= $data_pegawai->golongan . " / " . $data_pegawai->pangkat ?>
                            </strong>
                        </span>
                    </p>
                </td>
            </tr>
            <?php if (!empty($data_pegawai->nama_jabatan)) : ?>
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
            <?php endif; ?>
            <?php if (!empty($data_pegawai->j_struktural)) : ?>
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
                                <?= $data_pegawai->j_struktural ?>
                            </span>
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <p>
            Berdasarkan data kepegawaian kami, nama tersebut adalah benar <?= $data_pegawai->status_kepegawaian_nama ?> Universitas Muhammadiyah Bandung dengan perincian penghasilan sebagai berikut :
        </p>
        <ol type="I">
            <li style="font-weight:bold;">
                PENGHASILAN
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
                        <span><?= format_rupiah($data_pegawai->nominal_gaji) ?></span>
                    </p>
                </td>
            </tr>
            <?php if (!empty($data_pegawai->tunjangan_struktural)) : ?>
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
                            <span><?= format_rupiah($data_pegawai->tunjangan_struktural); ?></span>
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
                        <span><strong>JUMLAH PENGHASILAN</strong></span>
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
                                $jumlah_penghasilan = $data_pegawai->nominal_gaji +
                                    $data_pegawai->tunjangan_struktural +
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
                POTONGAN
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
                        <span><strong>JUMLAH POTONGAN</strong></span>
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
                        <span><strong>TOTAL GAJI BERSIH DAN PENGHASILAN LAINNYA</strong></span>
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
                        <span><strong><?= \Nasution\Terbilang::convert($gaji_bersih) ?> rupiah</strong></span>
                    </p>
                </td>
            </tr>
        </table>

        <p>
            Demikian surat keterangan ini dibuat untuk dapat digunakan sebagaimana mestinya.
        </p>

        <table style="margin-top: 1rem">
            <tr>
                <td style="border: none; width: 50%;"></td>
                <td class="center" style="border: none">
                    <p>
                        Bandung, <?= tanggal_indonesia(date('Y-m-d')) ?>
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
                        <span><strong>Abin Suarsa, SE., MM., CESF., CSRS.</strong></span>
                    </p>
                </td>
            </tr>
        </table>

    </main>
</body>

</html>