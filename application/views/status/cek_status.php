<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
</head>

<body class="bg-light-gray">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Daftar Jadwal</h4>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered table-striped w-100" id="table">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Kode MK</th>
                                <th class="text-center">Nama MK</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Dosen Pengampu</th>
                                <th class="text-center">Program Studi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_jadwal as $jadwal) : ?>
                                <tr>
                                    <td></td>
                                    <td><?= $jadwal['kode_matkul'] ?></td>
                                    <td><?= $jadwal['nama_matkul'] ?></td>
                                    <td class="text-center"><?= $jadwal['kelas_matkul'] ?></td>
                                    <td>
                                        <?= nama_gelar_lengkap_ucwords(
                                            $jadwal['nama_depan'],
                                            $jadwal['nama_tengah'],
                                            $jadwal['nama_belakang'],
                                            $jadwal['gelar_depan'],
                                            $jadwal['gelar_belakang']
                                        ) ?>
                                    </td>
                                    <td class="text-center"><?= $jadwal['nama_prodi'] ?></td>
                                    <td>
                                        <a href="<?= base_url('cek-status/' . $jadwal['id_jadwal'] . '/detail') ?>" class="btn btn-sm btn-info">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/footer') ?>
    <?php $this->load->view('_partials/script') ?>
    <script>
        const table = $('#table').DataTable({
            columnDefs: [{
                targets: [0, 6],
                orderable: false,
                searchable: false
            }],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            order: [1, 'asc']
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
</body>

</html>