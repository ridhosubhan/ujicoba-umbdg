<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar Scroll -->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="<?= base_url('administrator') ?>" class="d-flex align-items-center justify-content-center logo-img">
                <img src="<?= base_url('assets/images/logos/logo-blue.png') ?>" width="30" alt="" />
                <h2 class="fw-bolder mb-0 ms-3">KEUANGAN</h2>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <!-- HOME -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="<?= base_url('payroll') ?>">
                        <i class="ti ti-layout-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- PAYROLL -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">PAYROLL</span>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/payroll/referensi-potongan*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/payroll/referensi-potongan') ?>">
                        <i class="ti ti-cut"></i>
                        <span class="hide-menu text-wrap">Referensi Potongan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link  d-flex justify-content-between" data-bs-toggle="collapse" href="#" aria-expanded="false" aria-controls="collapsePotongan">
                        <div class="d-flex gap-3">
                            <i class="ti ti-receipt"></i>
                            <span class="hide-menu">Potongan</span>
                        </div>
                        <i class="arrow"></i>
                    </a>
                    <ul class="collapse " id="collapsePotongan" aria-expanded="false">
                        <li class="sidebar-item">
                            <?php fnmatch('administrator/payroll/potongan*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                            <a class="sidebar-link " href="<?= base_url('administrator/payroll/potongan') ?>" style="padding-left: 2rem">
                                <i class="ti ti-circle fs-1"></i>
                                <span class="hide-menu">Data Potongan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php fnmatch('administrator/payroll/potongan/upload*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                            <a class="sidebar-link " href="<?= base_url('administrator/payroll/potongan/upload') ?>" style="padding-left: 2rem">
                                <i class="ti ti-circle fs-1"></i>
                                <span class="hide-menu">Upload Potongan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php fnmatch('administrator/payroll/potongan/list*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                            <a class="sidebar-link " href="<?= base_url('administrator/payroll/potongan/list') ?>" style="padding-left: 2rem">
                                <i class="ti ti-circle fs-1"></i>
                                <span class="hide-menu">Detail Potongan</span>
                            </a>
                        </li>
                    </ul>
                    <!-- <li class="sidebar-item">
                    <?php fnmatch('administrator/payroll/potongan*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/payroll/potongan') ?>">
                        <i class="ti ti-receipt"></i>
                        <span class="hide-menu text-wrap">Potongan</span>
                    </a>
                </li> -->
                <li class="sidebar-item">
                    <?php fnmatch('administrator/payroll/gaji*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/payroll/gaji') ?>">
                        <i class="ti ti-wallet"></i>
                        <span class="hide-menu text-wrap">Gaji</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/payroll/rapel-gaji*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/payroll/rapel-gaji') ?>">
                        <i class="ti ti-wallet"></i>
                        <span class="hide-menu text-wrap">Rapel Gaji</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/payroll/karyawan*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/payroll/karyawan') ?>">
                        <i class="ti ti-id-badge"></i>
                        <span class="hide-menu text-wrap">Karyawan</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Sidebar Navigation End -->
    </div>
    <!-- Sidebar Scroll End -->
</aside>
<!--  Sidebar End -->