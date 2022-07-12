<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tourism Village</h3>
                <p class="text-subtitle text-muted">Desa Wisata Kampuang Minang Nagari Sumpu</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first mb-md-0 mb-3">
                <div class="float-end">
                    <?php if (logged_in()) : ?>
                    <div class="btn-group mb-1">
                        <div class="dropdown">
                            <a class="" role="button"
                               id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <div class="card mb-0">
                                    <div class="card-body py-3 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-lg me-0">
                                                <img src="<?= base_url('media/photos'); ?>/<?= user()->avatar; ?>" alt="Face 1" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?= base_url('web/profile'); ?>">My Profile</a>
                                <a class="dropdown-item" href="<?= base_url('logout'); ?>">Log Out</a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="<?= base_url('login'); ?>" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>setBaseUrl("<?= base_url(); ?>");</script>