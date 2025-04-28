<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
</head>

<body class="bg-light-gray">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Status Mahasiswa <?= $jadwal['nama'] . ' ' . $jadwal['kelas'] ?></h4>
                <nav aria-label="breadcrumb" class="d-flex align-items-baseline gap-3 my-3">
                    <a class="btn btn-sm btn-primary d-flex align-items-center rounded-2 px-3" onclick="javascript:history.go(-1)"><i class="ti ti-arrow-left fs-3"></i></a>
                </nav>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered table-striped w-100" id="table">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Nama Mahasiswa</th>
                                <th class="text-center">Program Studi</th>
                                <th class="text-center">Angkatan</th>
                                <th class="text-center" style="width: 15%">KRS</th>
                                <th class="text-center" style="width: 15%">UTS</th>
                                <th class="text-center" style="width: 15%">UAS</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/footer') ?>
    <?php $this->load->view('_partials/script') ?>
    <script>
        const table = $('#table').DataTable({
            ajax: {
                url: '<?= base_url('status/get_list_mahasiswa/' . $this->uri->segment(2, '')) ?>',
                method: 'POST'
            },
            columns: [{
                    data: 'nomor',
                    className: 'text-center'
                },
                {
                    data: 'nim'
                },
                {
                    data: 'nama_mahasiswa'
                },
                {
                    data: 'nama_prodi',
                    className: 'text-center'
                },
                {
                    data: 'tahun_angkatan',
                    className: 'text-center'
                },
                {
                    data: 'krs',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data === 'Y' ?
                            '<button class="btn btn-sm btn-success">Aktif</button>' :
                            '<button class="btn btn-sm btn-danger">Non-Aktif</button>';
                    }
                },
                {
                    data: 'uts',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data === 'Y' ?
                            '<button class="btn btn-sm btn-success">Aktif</button>' :
                            '<button class="btn btn-sm btn-danger">Non-Aktif</button>';
                    }
                },
                {
                    data: 'uas',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data === 'Y' ?
                            '<button class="btn btn-sm btn-success">Aktif</button>' :
                            '<button class="btn btn-sm btn-danger">Non-Aktif</button>';
                    }
                },
            ],
            columnDefs: [{
                targets: [0],
                orderable: false,
                searchable: false
            }],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            order: [1, 'asc'],
            processing: true,
            serverSide: true
        });
    </script>
</body>

</html>