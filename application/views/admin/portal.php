<div class="card">
    <div class="card-body">
        <h4 class="m-0">Portal <?= strtoupper($type) ?> Mahasiswa</h4>
        <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
            <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url('administrator') ?>" class="text-muted">Dashboard</a></li>
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item text-primary">Portal <?= strtoupper($type) ?></li>
            </ol>
        </nav>
        <?= $this->session->flashdata('msg') ?>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <label class="form-label">Tahun Ajaran</label>
                <?= form_open('admin/Administrator/ubah_tahun/' . $type . '/' . $this->uri->segment(4, '')) ?>
                <div class="d-flex align-items-baseline mb-3">
                    <select class="form-select select2" name="tahun" required>
                        <option selected disabled value="">Pilih Tahun Ajaran</option>
                        <?php $tahun_ajaran = $this->uri->segment(5, '');
                        if ($tahun_ajaran == '') $tahun_ajaran = $this->session->tahun; ?>
                        <?php foreach ($list_tahun as $tahun) : ?>
                            <?php if ($tahun_ajaran == $tahun['id_tahun']) : ?>
                                <option selected value="<?= $tahun['id_tahun'] ?>"><?= $tahun['id_tahun'] . ' - ' . $tahun['tahun_ajaran'] . ' ' . $tahun['nama'] ?></option>
                            <?php else : ?>
                                <option value="<?= $tahun['id_tahun'] ?>"><?= $tahun['id_tahun'] . ' - ' . $tahun['tahun_ajaran'] . ' ' . $tahun['nama'] ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                    <button type="submit" class="btn btn-primary mx-3">Pilih</button>
                </div>
                </form>
            </div>
            <div class="col-sm-6 col-lg-4">
                <label class="form-label">Program Studi</label>
                <?= form_open('admin/Administrator/ubah_prodi/' . $type . '/' . $this->uri->segment(5, '')) ?>
                <div class="d-flex align-items-baseline mb-3">
                    <select class="form-select select2" name="prodi" required>
                        <option selected disabled value="">Pilih Program Studi</option>
                        <?php $prodi_pilihan = $this->uri->segment(4, '');
                        if ($prodi_pilihan == '') $prodi_pilihan = 'AG'; ?>
                        <?php foreach ($list_prodi as $prd) :
                            if ($prodi_pilihan === $prd['id_prodi']) : ?>
                                <option selected value="<?= $prd['id_prodi'] ?>"><?= $prd['jenjang'] . ' - ' . $prd['nama'] ?></option>
                            <?php else : ?>
                                <option value="<?= $prd['id_prodi'] ?>"><?= $prd['jenjang'] . ' - ' . $prd['nama'] ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary mx-3">Pilih</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
        <div class="progress my-3" style="height : 25px">
            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: <?= $Y ?>%" aria-valuenow="<?= $Y ?>" aria-valuemin="0" aria-valuemax="100">
                <b>
                    <?= number_format($Y / ($Y + $N) * 100, 2) . '%' ?>
                </b>
            </div>
            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated shadow-none" role="progressbar" style="width: <?= $N ?>%" aria-valuenow="<?= $N ?>" aria-valuemin="0" aria-valuemax="100">
                <b>
                    <?= number_format($N / ($Y + $N) * 100, 2) . '%' ?>
                </b>
            </div>
        </div>
        <table class="table table-sm table-hover table-bordered table-striped" id="table">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">NIM</th>
                    <th class="text-center">Nama Mahasiswa - <?php if ($prodi == null) {
                                                                    echo 'Agribisnis';
                                                                } else {
                                                                    echo $prodi['nama'];
                                                                } ?></th>
                    <th class="text-center">Angkatan</th>
                    <th class="text-center" style="width: 15%">Status <?= strtoupper($type) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_mahasiswa as $mahasiswa) : ?>
                    <tr>
                        <td class="text-center"></td>
                        <td><?= $mahasiswa['nim'] ?></td>
                        <td class="fw-bolder"><?= ucwords(strtolower($mahasiswa['nama'])) ?></td>
                        <td class="text-center"><?= $mahasiswa['tahun_angkatan'] ?></td>
                        <td class="text-center">
                            <?php if ($prodi == null) :
                                if ($mahasiswa[$type] == 'Y') : ?>
                                    <a class="btn btn-sm btn-success" href="<?= base_url('admin/Administrator/aktifator/' . $type . '/' . $mahasiswa['nim'] . '/AG' . '/' . $this->uri->segment(5, '')) ?>">Aktif</a>
                                <?php else : ?>
                                    <a class="btn btn-sm btn-danger" href="<?= base_url('admin/Administrator/aktifator/' . $type . '/' . $mahasiswa['nim'] . '/AG' . '/' . $this->uri->segment(5, '')) ?>">Non-Aktif</a>
                                <?php endif;
                            else :
                                if ($mahasiswa[$type] == 'Y') : ?>
                                    <a class="btn btn-sm btn-success" href="<?= base_url('admin/Administrator/aktifator/' . $type . '/' . $mahasiswa['nim'] . '/' . $prodi['id_prodi'] . '/' . $this->uri->segment(5, '')) ?>">Aktif</a>
                                <?php else : ?>
                                    <a class="btn btn-sm btn-danger" href="<?= base_url('admin/Administrator/aktifator/' . $type . '/' . $mahasiswa['nim'] . '/' . $prodi['id_prodi'] . '/' . $this->uri->segment(5, '')) ?>">Non-Aktif</a>
                            <?php endif;
                            endif; ?>
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
            targets: [0]
        }],
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