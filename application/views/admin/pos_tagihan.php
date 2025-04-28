<div class="card">
    <div class="card-body">
        <h4 class="m-0">Data Pos Tagihan</h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Master</li>
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
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center">Nilai (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_pos as $pos) : ?>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center"><?= $pos['kode'] ?></td>
                        <td><?= $pos['nama_pos'] ?></td>
                        <td><?= $pos['deskripsi'] ?></td>
                        <td class="text-end"><?= $pos['nilai'] ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('#') ?>" class="btn btn-sm btn-success">Edit</a>
                            <a href="<?= base_url('#') ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
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
                targets: [0, 5]
            },
            {
                targets: 4,
                render: function(data, type, row) {
                    const formattedValue = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(data);

                    return formattedValue.replace(/^Rp\s+/, '').replace(/\,00$/, '');
                }
            }
        ],
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