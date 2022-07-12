<?= $this->extend('profile/index'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Change Password</h3>
            <?php foreach ($errors as $error): ?>
                <div class="alert <?= ($success) ? 'alert-success': 'alert-warning'; ?> alert-dismissible show fade">
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
            <form class="form form-vertical" action="<?= base_url('web/profile/changePassword'); ?>" method="post">
                <div class="form-body">
                    <div class="row">
                        <div class="col-8 mb-3">
                            <div class="form-group">
                                <label for="password" class="mb-2">New Password</label>
                                <input type="password" id="password" class="form-control"
                                       name="password" placeholder="New Password">
                            </div>
                        </div>
                        <div class="col-8 mb-3">
                            <div class="form-group">
                                <label for="confirm-password" class="mb-2">Confirm New Password</label>
                                <input type="password" id="confirm-password" class="form-control"
                                       name="pass_confirm" placeholder="Confirm New Password">
                            </div>
                        </div>
                        
                        <div class="col-8 d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
