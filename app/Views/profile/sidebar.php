<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <!-- Sidebar Header -->
        <?= $this->include('web/layouts/sidebar_header'); ?>
    
        <!-- Sidebar -->
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center avatar avatar-xl me-3" id="avatar-sidebar">
                    <img src="<?= base_url('media/photos/pesona_sumpu.png'); ?>" alt="" srcset="">
                </div>
                <?php if (logged_in()): ?>
                <div class="p-2 text-center">
                    <?php if (!empty(user()->first_name)): ?>
                        Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span>
                    <?php else: ?>
                        Hello, <span class="fw-bold">@<?= user()->username; ?></span>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <?php endif; ?>
                <ul class="menu">
                    <li class="sidebar-item">
                        <a href="<?= base_url('web'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-house"></i><span> Home</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= ($uri2 == '' || $uri2 == 'update') ? 'active' : '' ?>">
                        <a href="<?= base_url('web/profile'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-user"></i><span> Manage Profile</span>
                        </a>
                    </li>

                    <li class="sidebar-item  <?= ($uri2 == 'changePassword') ? 'active' : '' ?>">
                        <a href="<?= base_url('web/profile/changePassword'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-key"></i><span> Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>
        
        </div>
    </div>
</div>