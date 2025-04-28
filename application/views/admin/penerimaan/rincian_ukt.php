<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-baseline justify-content-between">
            <h4 class="m-0">Rincian UKT <?= $mahasiswa['nama'] ?></h4>
            <p class="fw-bold m-0">Saldo: <span id="saldo"><?= $saldo ?></span></p>
        </div>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Penerimaan</li>
                <li class="breadcrumb-item"><a href="<?= base_url('administrator/penerimaan/ukt') ?>" class="text-muted">UKT</a></li>
                <li class="breadcrumb-item text-primary">Rincian</li>
            </ol>
        </nav>
        <?= $this->session->flashdata('msg') ?>
        <table class="table table-sm table-hover table-bordered table-striped" id="table">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Akun</th>
                    <th class="text-center">Semester</th>
                    <th class="text-center">Jenis Tagihan</th>
                    <th class="text-center">Tagihan (Rp)</th>
                    <th class="text-center">Pembayaran (Rp)</th>
                    <th class="text-center">Tanggal Bayar</th>
                    <th class="text-center">Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ukt_mahasiswa as $ukt) : ?>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center"><?= $ukt['kode_akun'] ?></td>
                        <td class="fw-bolder text-center"><?= $ukt['semester'] ?></td>
                        <td><?= $ukt['jenis_tagihan'] ?></td>
                        <td class="text-end"><?= $ukt['tagihan'] ?></td>
                        <td class="text-end"><?= $ukt['pembayaran'] ?></td>
                        <td>
                            <?php if (!empty($ukt['tanggal_bayar'])) {
                                echo tanggal_indonesia(substr($ukt['tanggal_bayar'], 0, 10));
                            } ?>
                        </td>
                        <td><?= $ukt['metode_pembayaran'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot class="bg-primary text-white">
                <tr>
                    <th colspan="4" class="text-center">TOTAL</th>
                    <th class="text-end"></th>
                    <th class="text-end"></th>
                    <th class="text-center">SISA TAGIHAN *</th>
                    <th class="text-end"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/libs/datatables/datatables.min.js') ?>"></script>
<script>
    const saldo = document.getElementById('saldo');
    saldo.innerHTML = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(saldo.innerText);

    const table = new DataTable('#table', {
        dom: 'lrtip',
        drawCallback: function(settings) {
            $('.dataTables_info').append('<i class="float-end fs-2"><span style="color: red">*</span> Sisa Tagihan = Total Tagihan - (Total Pembayaran + Saldo)</i>');
        },
        columnDefs: [{
                searchable: false,
                orderable: false,
                targets: 0
            },
            {
                targets: [4, 5],
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

            const totalTagihan = api.column(4, {
                page: 'current'
            }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            const saldo = <?= $saldo ?>;

            const totalPembayaran = api.column(5, {
                page: 'current'
            }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            const sisaTagihan = totalTagihan - (totalPembayaran + saldo);

            if (sisaTagihan < 0) sisaTagihan = 0;

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

            const formattedValueSisaTagihan = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(sisaTagihan);

            api.column(4).footer().innerHTML = formattedValueTagihan.replace(/^Rp\s+/, '');
            api.column(5).footer().innerHTML = formattedValuePembayaran.replace(/^Rp\s+/, '');
            api.column(7).footer().innerHTML = formattedValueSisaTagihan.replace(/^Rp\s+/, '');

            if (sisaTagihan > 0) {
                api.column(6).footer().classList.add('bg-danger');
                api.column(7).footer().classList.add('bg-danger');
            }
        },
        order: [2, 'asc'],
        paging: false
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
</script>