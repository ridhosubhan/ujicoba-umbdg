<div class="card">
    <div class="card-body">
        <h4 class="m-0">Penerimaan UKT Mahasiswa</h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Penerimaan</li>
                <li class="breadcrumb-item text-primary">UKT</li>
            </ol>
        </nav>
        <div id="chart"></div>
        <?= $this->session->flashdata('msg') ?>
        <div class="col-sm-6 col-md-4">
            <?= form_open('admin/penerimaan/Penerimaan/ubah_prodi/ukt') ?>
            <div class="d-flex align-items-baseline mb-3">
                <select class="form-select select2" name="prodi" required>
                    <option selected disabled value="">Pilih Program Studi</option>
                    <?php if ($this->uri->segment(4, 0) === 'all') : ?>
                        <option selected value="all">Seluruh Program Studi</option>
                    <?php else : ?>
                        <option value="all">Seluruh Program Studi</option>
                    <?php endif ?>
                    <?php foreach ($list_prodi as $prodi) :
                        if ($this->uri->segment(4, 0) === $prodi['id_prodi']) : ?>
                            <option selected value="<?= $prodi['id_prodi'] ?>">
                                <?= $prodi['jenjang'] . ' - ' . $prodi['nama'] ?>
                            </option>
                        <?php else : ?>
                            <option value="<?= $prodi['id_prodi'] ?>">
                                <?= $prodi['jenjang'] . ' - ' . $prodi['nama'] ?>
                            </option>
                    <?php endif;
                    endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary mx-3">Pilih</button>
            </div>
            <?= form_close() ?>
        </div>
        <?php if ($this->uri->segment(4, 0) === 'all') : ?>
            <table class="table table-sm table-hover table-bordered table-striped" id="table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">NIM</th>
                        <th class="text-center">Nama Mahasiswa</th>
                        <th class="text-center">Program Studi</th>
                        <th class="text-center">Total Tagihan (Rp)</th>
                        <th class="text-center">Total Pembayaran (Rp)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_mahasiswa as $mahasiswa) : ?>
                        <tr>
                            <td class="text-center"></td>
                            <td><?= $mahasiswa['nim'] ?></td>
                            <td class="fw-bolder text-wrap"><?= ucwords(strtolower($mahasiswa['nama'])) ?></td>
                            <td>
                                <?php foreach ($list_prodi as $prodi) {
                                    if ($mahasiswa['id_prodi'] === $prodi['id_prodi']) {
                                        echo $prodi['nama'];
                                        break;
                                    }
                                } ?>
                            </td>
                            <td class="text-end">
                                <?php if (isset($ukt_per_mahasiswa[$mahasiswa['nim']]['total_tagihan'])) {
                                    echo $ukt_per_mahasiswa[$mahasiswa['nim']]['total_tagihan'];
                                } else {
                                    echo '0';
                                } ?>
                            </td>
                            <td class="text-end">
                                <?php if (isset($ukt_per_mahasiswa[$mahasiswa['nim']]['total_pembayaran'])) {
                                    echo $ukt_per_mahasiswa[$mahasiswa['nim']]['total_pembayaran'];
                                } else {
                                    echo '0';
                                } ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('administrator/penerimaan/ukt/rincian/' . $mahasiswa['nim']) ?>" class="btn btn-sm btn-secondary">Rincian</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot class="bg-primary text-white">
                    <tr>
                        <th colspan="4" class="text-center">TOTAL</th>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        <?php else : ?>
            <table class="table table-sm table-hover table-bordered table-striped" id="table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">NIM</th>
                        <th class="text-center">Nama Mahasiswa - <?= $prodi_pilihan['nama'] ?></th>
                        <th class="text-center">Total Tagihan (Rp)</th>
                        <th class="text-center">Total Pembayaran (Rp)</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_mahasiswa as $mahasiswa) : ?>
                        <tr>
                            <td class="text-center"></td>
                            <td><?= $mahasiswa['nim'] ?></td>
                            <td class="fw-bolder text-wrap"><?= ucwords(strtolower($mahasiswa['nama'])) ?></td>
                            <td class="text-end">
                                <?php if (isset($ukt_per_mahasiswa[$mahasiswa['nim']]['total_tagihan'])) {
                                    echo $ukt_per_mahasiswa[$mahasiswa['nim']]['total_tagihan'];
                                } else {
                                    echo '0';
                                } ?>
                            </td>
                            <td class="text-end">
                                <?php if (isset($ukt_per_mahasiswa[$mahasiswa['nim']]['total_pembayaran'])) {
                                    echo $ukt_per_mahasiswa[$mahasiswa['nim']]['total_pembayaran'];
                                } else {
                                    echo '0';
                                } ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('administrator/penerimaan/ukt/rincian/' . $mahasiswa['nim']) ?>" class="btn btn-sm btn-secondary">Rincian</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot class="bg-primary text-white">
                    <tr>
                        <th colspan="3" class="text-center">TOTAL</th>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        <?php endif ?>
    </div>
</div>

<!-- ApexCharts -->
<script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js') ?>"></script>
<script>
    var options = {
        series: [{
            name: 'Total Tagihan',
            data: [
                <?php foreach ($list_ukt_per_prodi as $ukt) {
                    echo $ukt['tagihan'] . ', ';
                } ?>
            ]
        }, {
            name: 'Total Pembayaran',
            data: [
                <?php foreach ($list_ukt_per_prodi as $ukt) {
                    echo $ukt['pembayaran'] . ', ';
                } ?>
            ]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        grid: {
            row: {
                colors: ['#fff', '#f2f2f2']
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [
                <?php foreach ($list_ukt_per_prodi as $ukt) {
                    echo '\'' . $ukt['nama_prodi'] . '\'' . ', ';
                } ?>
            ],
            labels: {
                rotate: -35
            },
            tickPlacement: 'on'
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(val);
                }
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(val);
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<!-- DataTables -->
<?php $kolom_tagihan = ($this->uri->segment(4, 0) === 'all') ? 4 : 3;
$kolom_pembayaran = ($this->uri->segment(4, 0) === 'all') ? 5 : 4;
$kolom_aksi = ($this->uri->segment(4, 0) === 'all') ? 6 : 5; ?>
<script src="<?= base_url('assets/libs/datatables/datatables.min.js') ?>"></script>
<script>
    const kolom_tagihan = <?= $kolom_tagihan ?>;
    const kolom_pembayaran = <?= $kolom_pembayaran ?>;
    const kolom_aksi = <?= $kolom_aksi ?>;
    const table = new DataTable('#table', {
        columnDefs: [{
                searchable: false,
                orderable: false,
                targets: [0, kolom_aksi]
            },
            {
                targets: [kolom_tagihan, kolom_pembayaran],
                render: function(data, type, row) {
                    const formattedValue = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(data);

                    return formattedValue.replace(/^Rp\s+/, '');
                }
            }
        ],
        footerCallback: function(row, data, start, end, display) {
            let api = this.api();

            let intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ? i : 0;
            };

            totalTagihan = api.column(kolom_tagihan, {
                page: 'current'
            }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            totalPembayaran = api.column(kolom_pembayaran, {
                page: 'current'
            }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            const formattedValueTagihan = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalTagihan);

            const formattedValuePembayaran = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalPembayaran);

            api.column(kolom_tagihan).footer().innerHTML = formattedValueTagihan.replace(/^Rp\s+/, '');
            api.column(kolom_pembayaran).footer().innerHTML = formattedValuePembayaran.replace(/^Rp\s+/, '');
        },
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        order: [1, 'asc'],
    });

    table.on('order.dt search.dt', () => {
        let i = 1;

        table.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();

    $(document).ready(() => {
        $('.select2').select2({
            theme: 'bootstrap-5',
        });
    });
</script>