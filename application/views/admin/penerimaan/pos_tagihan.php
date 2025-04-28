<div class="card">
    <div class="card-body">
        <h4 class="m-0">Daftar Pos Tagihan</h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Penerimaan</li>
                <li class="breadcrumb-item text-primary">Pos Tagihan</li>
            </ol>
        </nav>
        <?= $this->session->flashdata('msg') ?>
        <table class="table table-sm table-hover table-bordered table-striped" id="table">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Nama Pos Tagihan</th>
                    <th class="text-center">Total (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_pos as $pos) : ?>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center"><?= $pos['POS_TAGIHAN'] ?></td>
                        <td><?= $pos['NAMA_POS'] ?></td>
                        <td class="text-end"><?= $pos['BILLAM'] ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('administrator/penerimaan/pos-tagihan/rincian/' . $pos['POS_TAGIHAN']) ?>" class="btn btn-sm btn-secondary">Rincian</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot class="bg-primary text-white">
                <tr>
                    <th colspan="3" class="text-center">TOTAL</th>
                    <th class="text-end"></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- DataTables -->
<script src="<?= base_url('assets/libs/datatables/datatables.min.js') ?>"></script>
<script>
    const table = new DataTable('#table', {
        columnDefs: [{
                searchable: false,
                orderable: false,
                targets: [0, 4]
            },
            {
                targets: 3,
                render: function(data, type, row) {
                    const formattedValue = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(data);

                    return formattedValue.replace(/^Rp\s+/, '').replace(/\,00$/, '');
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

            totalTagihan = api.column(3, {
                page: 'current'
            }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            const formattedValueTagihan = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalTagihan);

            api.column(3).footer().innerHTML = formattedValueTagihan.replace(/^Rp\s+/, '');
        },
        lengthMenu: [
            [25, 50, -1],
            [25, 50, 'All'],
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
</script>