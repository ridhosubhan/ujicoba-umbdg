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
                    <a class="sidebar-link" href="<?= base_url('administrator') ?>">
                        <i class="ti ti-layout-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <!-- MASTER -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master</span>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/master/akun*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/master/akun') ?>">
                        <i class="ti ti-receipt"></i>
                        <span class="hide-menu">Akun</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/master/pos-tagihan*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/master/pos-tagihan') ?>">
                        <i class="ti ti-receipt"></i>
                        <span class="hide-menu">Pos Tagihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/master/portal-krs*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/master/portal-krs') ?>">
                        <i class="ti ti-clipboard-list"></i>
                        <span class="hide-menu">Portal KRS</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/master/portal-uts*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/master/portal-uts') ?>">
                        <i class="ti ti-clipboard-list"></i>
                        <span class="hide-menu">Portal UTS</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/master/portal-uas*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/master/portal-uas') ?>">
                        <i class="ti ti-clipboard-list"></i>
                        <span class="hide-menu">Portal UAS</span>
                    </a>
                </li>

                <!-- PENERIMAAN -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Penerimaan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-school"></i>
                        <span class="hide-menu">PMB</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/penerimaan/ukt*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/ukt') ?>">
                        <i class="ti ti-cash"></i>
                        <span class="hide-menu">UKT</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <?php fnmatch('administrator/penerimaan/pos-tagihan*', uri_string()) ? $menu = 'active' : $menu = '' ?>
                    <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/pos-tagihan') ?>">
                        <i class="ti ti-receipt"></i>
                        <span class="hide-menu">Pos Tagihan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link d-flex justify-content-between" data-bs-toggle="collapse" href="#" aria-expanded="false" aria-controls="collapseBeasiswa">
                        <div class="d-flex gap-3">
                            <i class="ti ti-certificate"></i>
                            <span class="hide-menu">Beasiswa</span>
                        </div>
                        <i class="arrow"></i>
                    </a>
                    <ul class="collapse" id="collapseBeasiswa" aria-expanded="false">
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/baznas-kota-bandung*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/baznas-kota-bandung') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">BAZNAS Kota Bandung</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/baznas-ri*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/baznas-ri') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">BAZNAS RI</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/dakwah-keumatan*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/dakwah-keumatan') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">Dakwah Keumatan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/guru*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/guru') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">Guru</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/hafizh*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/hafizh') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">Hafizh</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/kader-muhammadiyah*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/kader-muhammadiyah') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">Kader Muhammadiyah</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/kip*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/kip') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">KIP</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/lazismu-kl*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/lazismu-kl') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">Lazismu KL</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <?php if (fnmatch('administrator/penerimaan/beasiswa/prestasi*', uri_string())) {
                                $icon = 'circle-filled';
                                $menu = 'dropdown';
                            } else {
                                $icon = 'circle';
                                $menu = '';
                            } ?>
                            <a class="sidebar-link <?= $menu ?>" href="<?= base_url('administrator/penerimaan/beasiswa/prestasi') ?>" style="padding-left: 2rem">
                                <i class="ti ti-<?= $icon ?> fs-1"></i>
                                <span class="hide-menu">Prestasi</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-gift-card"></i>
                        <span class="hide-menu">Dana Hibah</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-briefcase"></i>
                        <span class="hide-menu">Dana Amal Usaha</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-border-all"></i>
                        <span class="hide-menu">Dana Lainnya</span>
                    </a>
                </li>

                <!-- PENGELUARAN -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengeluaran</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-building"></i>
                        <span class="hide-menu">Sarana Prasarana</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-building-warehouse"></i>
                        <span class="hide-menu">Non Sarana Prasarana</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-package"></i>
                        <span class="hide-menu">Pemeliharaan Aset</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-receipt-2"></i>
                        <span class="hide-menu">Pembayaran Remunerasi</span>
                    </a>
                </li>

                <!-- PELAPORAN -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pelaporan</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-activity"></i>
                        <span class="hide-menu">Keuangan Kegiatan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-building-estate"></i>
                        <span class="hide-menu text-wrap">Operasional Universitas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-luggage"></i>
                        <span class="hide-menu text-wrap">Operasional Unit Kerja</span>
                    </a>
                </li>

                <!-- PAJAK -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pajak</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-chart-line"></i>
                        <span class="hide-menu text-wrap">PPN</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <i class="ti ti-calendar"></i>
                        <span class="hide-menu text-wrap">PPh</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Sidebar Navigation End -->
    </div>
    <!-- Sidebar Scroll End -->
</aside>
<!--  Sidebar End -->