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
                {sidebar-items}
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">{label}</span>
                </li>
                {nav-items}
                <li class="sidebar-item">
                    {item}
                </li>
                {/nav-items}
                {/sidebar-items}
            </ul>
        </nav>
        <!-- Sidebar Navigation End -->
    </div>
    <!-- Sidebar Scroll End -->
</aside>
<!--  Sidebar End -->