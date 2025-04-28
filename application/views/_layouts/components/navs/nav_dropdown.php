<a class="sidebar-link {active} d-flex justify-content-between" data-bs-toggle="collapse" href="#" aria-expanded="false" aria-controls="collapse{label}">
    <div class="d-flex gap-3">
        <i class="{icon}"></i>
        <span class="hide-menu">{label}</span>
    </div>
    <i class="arrow"></i>
</a>
<ul class="collapse {in}" id="collapse{label}" aria-expanded="false">
    {nav-items}
    <li class="sidebar-item">
        <a class="sidebar-link {dropdown}" href="<?= base_url() ?>{href}" style="padding-left: 2rem">
            <i class="{icon} fs-1"></i>
            <span class="hide-menu">{label}</span>
        </a>
    </li>
    {/nav-items}
</ul>