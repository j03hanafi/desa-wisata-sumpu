<?php
$uri = service('uri')->getSegments();
$edit = in_array('edit', $uri);
?>

<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('styles') ?>
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link
    href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
    rel="stylesheet"
/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/form-element-select.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Profile</h3>
            <?php if (isset($errors)): ?>
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
            <?php endif; ?>
        </div>
        <div class="card-body">
            <form class="form form-vertical" action="<?= ($edit) ? base_url('dashboard/users/update') . '/' . $data['id'] : base_url('dashboard/users'); ?>" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <div class="row gx-md-5">
                        <div class="col-md-6 col-12 order-md-first order-last">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="first-name" class="mb-2">First Name</label>
                                        <input type="text" id="first-name" class="form-control"
                                               name="first_name" placeholder="First Name" value="<?= ($edit) ? $data['first_name'] : old('first_name'); ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="last-name" class="mb-2">Last Name</label>
                                        <input type="text" id="last-name" class="form-control"
                                               name="last_name" placeholder="Last Name" value="<?= ($edit) ? $data['last_name'] : old('last_name'); ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="email" class="mb-2">Email</label>
                                        <input type="email" id="email" class="form-control"
                                               name="email" placeholder="Email" value="<?= ($edit) ? $data['email'] : old('email'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="username" class="mb-2">Username</label>
                                        <input type="text" id="username" class="form-control"
                                               name="username" placeholder="Username" value="<?= ($edit) ? $data['username'] : old('username'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="password" class="mb-2">New Password</label>
                                        <input type="password" id="password" class="form-control"
                                               name="password" placeholder="New Password">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="confirm-password" class="mb-2">Confirm New Password</label>
                                        <input type="password" id="confirm-password" class="form-control"
                                               name="pass_confirm" placeholder="Confirm New Password">
                                    </div>
                                </div>
                                <fieldset class="form-group mb-4">
                                    <label for="role" class="mb-2">Roles</label>
                                    <select class="form-select" id="role" name="role">
                                        <?php foreach ($roles as $role) : ?>
                                        <?php if ($edit && esc($role['name']) == esc($data['role'])): ?>
                                            <option value="<?= esc($role['id']); ?>" selected><?= ucfirst(esc($role['name'])); ?></option>
                                        <?php else: ?>
                                            <option value="<?= esc($role['id']); ?>"><?= ucfirst(esc($role['name'])); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </fieldset>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="address" class="mb-2">Address</label>
                                        <input type="text" id="address" class="form-control"
                                               name="address" placeholder="Address" value="<?= ($edit) ? $data['address'] : old('address'); ?>">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="phone" class="mb-2">Phone</label>
                                        <input type="number" id="phone" class="form-control"
                                               name="phone" placeholder="Phone" value="<?= ($edit) ? $data['phone'] : old('phone'); ?>">
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
                                        <input class="form-control" type="file" id="avatar" name="avatar" accept="image/png, image/jpeg, image/gif">
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

<?= $this->section('javascript') ?>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageResize,
        FilePondPluginImageTransform
    );

    // Get a reference to the file input element
    const inputElement = document.querySelector('input[id="avatar"]');

    // Create a FilePond instance
    const pond = FilePond.create(inputElement, {
        labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
        imagePreviewHeight: 300,
        imageCropAspectRatio: '1:1',
        imageResizeTargetWidth: 300,
        imageResizeTargetHeight: 300,
        stylePanelLayout: 'compact circle',
        styleLoadIndicatorPosition: 'center bottom',
        styleButtonRemoveItemPosition: 'center bottom',
        credits: false,
    });
    <?php if ($edit): ?>
    pond.addFile(`<?= base_url('media/photos/' . $data['avatar']); ?>`);
    <?php endif; ?>
    FilePond.setOptions({
        server: '/upload/avatar'
    })
</script>
<?= $this->endSection() ?>
