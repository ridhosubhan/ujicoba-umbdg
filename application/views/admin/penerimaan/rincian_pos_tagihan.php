<div class="card">
    <div class="card-body">
        <h4 class="m-0">Rincian Pos <?= $pos_tagihan['nama_pos'] ?></h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Penerimaan</li>
                <li class="breadcrumb-item"><a href="<?= base_url('administrator/penerimaan/pos-tagihan') ?>" class="text-muted">Pos Tagihan</a></li>
                <li class="breadcrumb-item text-primary">Rincian</li>
            </ol>
        </nav>
        <?= $this->session->flashdata('msg') ?>
        <div class="col-sm-6 col-md-4">
            <?= form_open('admin/penerimaan/Penerimaan/ubah_prodi/pos-tagihan/rincian/' . $this->uri->segment(5, 0)) ?>
            <div class="d-flex align-items-baseline mb-3">
                <select class="form-select select2" name="prodi" required>
                    <option selected disabled value="">Pilih Program Studi</option>
                    <?php if ($this->uri->segment(6, 0) === 'all') : ?>
                        <option selected value="all">Seluruh Program Studi</option>
                    <?php else : ?>
                        <option value="all">Seluruh Program Studi</option>
                    <?php endif ?>
                    <?php foreach ($list_prodi as $prodi) :
                        if ($this->uri->segment(6, 0) === $prodi['id_prodi']) : ?>
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
        <?php if ($this->uri->segment(6, 0) === 'all') : ?>
            <table class="table table-sm table-hover table-bordered table-striped" id="table">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">NIM</th>
                        <th class="text-center">Nama Mahasiswa</th>
                        <th class="text-center">Program Studi</th>
                        <th class="text-center">Total Tagihan (Rp)</th>
                        <th class="text-center">Total Pembayaran (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_mahasiswa as $mahasiswa) :
                        if (empty($rincian_per_pos[$mahasiswa['nim']]['tagihan'])) continue;
                        if ($rincian_per_pos[$mahasiswa['nim']]['tagihan'] != 0) : ?>
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
                                <td class="text-end"><?= $rincian_per_pos[$mahasiswa['nim']]['tagihan'] ?></td>
                                <td class="text-end"><?= $rincian_per_pos[$mahasiswa['nim']]['pembayaran'] ?></td>
                            </tr>
                    <?php endif;
                    endforeach; ?>
                </tbody>
                <tfoot class="bg-primary text-white">
                    <tr>
                        <th colspan="4" class="text-center">TOTAL</th>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list_mahasiswa as $mahasiswa) :
                        if (empty($rincian_per_pos[$mahasiswa['nim']]['tagihan'])) continue;
                        if ($rincian_per_pos[$mahasiswa['nim']]['tagihan'] != 0) : ?>
                            <tr>
                                <td class="text-center"></td>
                                <td><?= $mahasiswa['nim'] ?></td>
                                <td class="fw-bolder text-wrap"><?= ucwords(strtolower($mahasiswa['nama'])) ?></td>
                                <td class="text-end"><?= $rincian_per_pos[$mahasiswa['nim']]['tagihan'] ?></td>
                                <td class="text-end"><?= $rincian_per_pos[$mahasiswa['nim']]['pembayaran'] ?></td>
                            </tr>
                    <?php endif;
                    endforeach; ?>
                </tbody>
                <tfoot class="bg-primary text-white">
                    <tr>
                        <th colspan="3" class="text-center">TOTAL</th>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                    </tr>
                </tfoot>
            </table>
        <?php endif ?>
    </div>
</div>

<!-- DataTables -->
<?php $kolom_tagihan = ($this->uri->segment(6, 0) === 'all') ? 4 : 3;
$kolom_pembayaran = ($this->uri->segment(6, 0) === 'all') ? 5 : 4; ?>
<script src="<?= base_url('assets/libs/datatables/datatables.min.js') ?>"></script>
<script>
    const kolom_tagihan = <?= $kolom_tagihan ?>;
    const kolom_pembayaran = <?= $kolom_pembayaran ?>;
    const table = new DataTable('#table', {
        columnDefs: [{
                searchable: false,
                orderable: false,
                targets: [0]
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