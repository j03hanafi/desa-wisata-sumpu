<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>
<section class="section">

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">User Profile</h3>
                </div>
                <div class="col">
                    <a href="<?= base_url('dashboard/users/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-12 order-md-first order-last">
                    <div class="mb-5">
                        <p class="mb-2">First Name</p>
                        <p class="fw-bold fs-5"><?= (esc($data['first_name']) == '') ? '-' : esc($data['first_name']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Last Name</p>
                        <p class="fw-bold fs-5"><?= (esc($data['last_name']) == '') ? '-' : esc($data['last_name']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Email</p>
                        <p class="fw-bold fs-5"><?= (esc($data['email']) == '') ? '-' : esc($data['email']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Username</p>
                        <p class="fw-bold fs-5"><?= (esc($data['username']) == '') ? '-' : esc($data['username']); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Role</p>
                        <p class="fw-bold fs-5"><?= ucfirst(esc($data['role'])); ?></p>
                    </div>
                    <div class="mb-5">
                        <p class="mb-2">Address</p>
                        <p class="fw-bold fs-5"><?= (esc($data['address']) == '') ? '-' : esc($data['address']); ?></p>
                    </div>
                    <div class="">
                        <p class="mb-2">Phone</p>
                        <p class="fw-bold fs-5"><?= (esc($data['phone']) == '') ? '-' : esc($data['phone']); ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-12 order-md-last order-first mb-5">
                    <p class="mb-2">Profile Picture</p>
                    <div class="text-md-start text-center" id="avatar-container">
                        <img src="<?= base_url('media/photos'); ?>/<?= esc($data['avatar']); ?>" alt="avatar" class="img-fluid img-thumbnail rounded-circle">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?= $this->endSection() ?>