<div class="card">
    <div class="card-body">
        <h4 class="m-0">Daftar Penerima Beasiswa <?= $jenis_beasiswa['nama_beasiswa'] ?></h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Penerimaan</li>
                <li class="breadcrumb-item text-primary">Beasiswa</li>
            </ol>
        </nav>
        <?= $this->session->flashdata('msg') ?>
        <table class="table table-sm table-hover table-bordered table-striped" id="table">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">No.</th>
                    <th class="text-center">NIM</th>
                    <th class="text-center">Nama Mahasiswa</th>
                    <th class="text-center">Program Studi</th>
                    <th class="text-center">Potongan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_beasiswa as $beasiswa) :
                    if (isset($list_mahasiswa[$beasiswa['NOCUST']])) : ?>
                        <tr>
                            <td class="text-center">
                                <a href="<?= base_url('#') ?>" class="btn btn-sm btn-success">Edit</a>
                                <a href="<?= base_url('#') ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                            <td class="text-center"></td>
                            <td><?= $beasiswa['NOCUST'] ?></td>
                            <td><?= $list_mahasiswa[$beasiswa['NOCUST']]['nama'] ?></td>
                            <td>
                                <?php foreach ($list_prodi as $prodi) {
                                    if ($list_mahasiswa[$beasiswa['NOCUST']]['id_prodi'] === $prodi['id_prodi']) {
                                        echo $prodi['nama'];
                                        break;
                                    }
                                } ?>
                            </td>
                            <td class="text-end"><?= $beasiswa['BEASAM'] ?></td>
                        </tr>
                <?php endif;
                endforeach; ?>
            </tbody>
            <tfoot class="bg-primary text-white">
                <tr>
                    <th colspan="5" class="text-center">TOTAL</th>
                    <th class="text-end"></th>
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
                targets: [0, 1]
            },
            {
                targets: 5,
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

            totalTagihan = api.column(5, {
                page: 'current'
            }).data().reduce((a, b) => intVal(a) + intVal(b), 0);

            const formattedValueTagihan = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalTagihan);

            api.column(5).footer().innerHTML = formattedValueTagihan.replace(/^Rp\s+/, '');
        },
        lengthMenu: [
            [25, 50, -1],
            [25, 50, 'All'],
        ],
        order: [2, 'asc'],
    });

    table.on('order.dt search.dt', () => {
        let i = 1;

        table.cells(null, 1, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();
</script>