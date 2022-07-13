<?= $this->extend('profile/index'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Profile</h3>
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-warning alert-dismissible show fade">
                    <?= esc($error) ?>
                    <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"
                    ></button>
                </div>
            <?php endforeach ?>
        </div>
        <div class="card-body">
            <form class="form form-vertical" action="<?= base_url('web/profile/update'); ?>" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="row gx-md-5">
                        <div class="col-md-6 col-12 order-md-first order-last">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="first-name" class="mb-2">First Name</label>
                                        <input type="text" id="first-name" class="form-control"
                                               name="first_name" placeholder="First Name" value="<?= (user()->first_name == '') ? '' : user()->first_name; ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="last-name" class="mb-2">Last Name</label>
                                        <input type="text" id="last-name" class="form-control"
                                               name="last_name" placeholder="Last Name" value="<?= (user()->last_name == '') ? '' : user()->last_name; ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="email" class="mb-2">Email</label>
                                        <input type="email" id="email" class="form-control"
                                               name="email" placeholder="Email" value="<?= user()->email; ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="username" class="mb-2">Username</label>
                                        <input type="text" id="username" class="form-control"
                                               name="username" placeholder="Username" value="<?= user()->username; ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="address" class="mb-2">Address</label>
                                        <input type="text" id="address" class="form-control"
                                               name="address" placeholder="Address" value="<?= (user()->address == '') ? '' : user()->address; ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="phone" class="mb-2">Phone</label>
                                        <input type="number" id="phone" class="form-control"
                                               name="phone" placeholder="Phone" value="<?= (user()->phone == '') ? '' : user()->phone; ?>">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mb-3">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset"
                                            class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 order-md-last order-first">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="avatar" class="mb-2">Profile Picture</label>
                                        <div class="text-md-start text-center mb-3" id="avatar-container">
                                            <img src="<?= base_url('media/photos'); ?>/<?= user()->avatar; ?>" alt="avatar" class="img-fluid img-thumbnail rounded-circle" id="avatar-preview">
                                        </div>
                                        <input class="form-control" type="file" id="avatar" name="avatar" onchange="showPreview(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
