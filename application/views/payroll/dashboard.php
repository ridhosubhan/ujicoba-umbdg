<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
</head>

<body class="bg-light-gray">
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <?php $this->load->view('_partials/sidebar_payroll_staff') ?>
        <div class="body-wrapper">
            <?php $this->load->view('_partials/header') ?>
            <div class="container-fluid">
                <!-- Isi page mulai dari sini -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang di Sistem Informasi Keuangan 🎉</h5>
                        <p class="mb-2">
                            Sekarang <span class="fw-bold">Universitas Muhammadiyah Bandung</span> sedang ada pada periode tahun <span class="fw-bold"><?= $tahun['tahun_ajaran'] . ' ' . $tahun['nama'] ?></span>.
                            <br>Kamu bisa mengakses data keuangan melalui menu disamping kiri.
                        </p>
                    </div>
                </div>
                <!-- Isi page berakhir di sini -->
                <?php $this->load->view('_partials/footer') ?>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/script') ?>
</body>

</html>