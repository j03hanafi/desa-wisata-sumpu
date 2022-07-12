<?= $this->extend('profile/index'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <?php foreach ($datas as $data): ?>
                    <div class="col-12 alert alert-success alert-dismissible show fade">
                        <?= esc($data) ?>
                        <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close"
                        ></button>
                    </div>
                <?php endforeach ?>
                <div class="col">
                    <h3 class="card-title">My Profile</h3>
                </div>
                <div class="col">
                    <a href="<?= base_url('web/profile/update'); ?>" class="btn btn-primary float-end">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12 order-md-first order-last">
                    <div class="mb-5">
                        <p class="mb-2">First Name</p>
                        <p class="fw-bold fs-5"><?= (user()->first_name == '') ? '-' : user()->first_name; ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Last Name</p>
                        <p class="fw-bold fs-5"><?= (user()->last_name == '') ? '-' : user()->last_name; ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Email</p>
                        <p class="fw-bold fs-5"><?= user()->email; ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Username</p>
                        <p class="fw-bold fs-5"><?= user()->username; ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Address</p>
                        <p class="fw-bold fs-5"><?= (user()->address == '') ? '-' : user()->address; ?></p>
                    </div>
                    <div class="">
                        <p class="mb-2">Phone</p>
                        <p class="fw-bold fs-5"><?= (user()->phone == '') ? '-' : user()->phone; ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-12 order-md-last order-first mb-5">
                    <p class="mb-2">Profile Picture</p>
                    <div class="text-md-start text-center" id="avatar-container">
                        <img src="<?= base_url('media/photos'); ?>/<?= user()->avatar; ?>" alt="avatar" class="img-fluid img-thumbnail rounded-circle">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
