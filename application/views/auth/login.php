<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view('_partials/head') ?>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-10 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="d-flex align-items-center justify-content-center logo-img mb-3">
                                    <img src="<?= base_url('assets/images/logos/logo-blue.png') ?>" width="50" alt="" />
                                    <h1 class="fw-bolder mb-0 ms-3">KEUANGAN</h1>
                                </a>
                                <div class="w3-panel w3-blue w3-display-container">
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                                <?= form_open('login/autentikasi') ?>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" id="email">
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">Login</button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('_partials/script') ?>
</body>

</html>