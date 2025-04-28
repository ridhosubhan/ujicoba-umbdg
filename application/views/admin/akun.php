<div class="card">
    <div class="card-body">
        <h4 class="m-0">Data Akun</h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item text-primary">Akun</li>
            </ol>
        </nav>
        <?= $this->session->flashdata('msg') ?>
        <table class="table table-sm table-hover table-bordered table-striped" id="table">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center dt-nowrap">No.</th>
                    <th class="text-center dt-nowrap">Induk</th>
                    <th class="text-center dt-nowrap">Kode Detail</th>
                    <th class="text-center dt-nowrap">Nama Detail</th>
                    <th class="text-center dt-nowrap">Kode Sub Detail</th>
                    <th class="text-center dt-nowrap">Nama Sub Detail</th>
                    <th class="text-center dt-nowrap">Kode Rincian</th>
                    <th class="text-center dt-nowrap">Nama Rincian</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_akun as $akun) : ?>
                    <tr>
                        <td class="text-center"></td>
                        <td style="width: 15%"><?= $akun['kode_induk'] . ' ' . $akun['nama_akun_induk'] ?></td>
                        <td class="text-center"><?= $akun['kode_akun_detail'] ?></td>
                        <td><?= $akun['nama_akun_detail'] ?></td>
                        <td class="text-center"><?= $akun['kode_akun_sub_detail'] ?></td>
                        <td><?= $akun['nama_akun_sub_detail'] ?></td>
                        <td class="text-center"><?= $akun['kode_rincian_sub_detail'] ?></td>
                        <td><?= $akun['nama_rincian_sub_detail'] ?></td>
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
            targets: [0]
        }],
        lengthMenu: [
            [25, 50, -1],
            [25, 50, 'All'],
        ],
        order: [4, 'asc']
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