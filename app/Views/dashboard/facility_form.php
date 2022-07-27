<?php
$uri = service('uri')->getSegments();
$edit = in_array('edit', $uri);
?>

<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>currentUrl = '<?= current_url(); ?>';</script>
    
        <!-- Object Detail Information -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"><?= $title; ?></h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="<?= ($edit) ? base_url('dashboard/facility/update') . '/' . $data['id'] : base_url('dashboard/facility'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group mb-4">
                                <label for="id" class="mb-2">ID</label>
                                <input type="text" id="id" class="form-control"
                                       name="id" placeholder="ID" readonly="readonly" required value='<?= ($edit) ? $data['id'] : $id; ?>'>
                            </div>
                            <div class="form-group mb-4">
                                <label for="facility" class="mb-2">Facility Name</label>
                                <input type="text" id="facility" class="form-control"
                                       name="facility" placeholder="Facility Name" value="<?= ($edit) ? $data['facility'] : old('facility'); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <button type="reset"
                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
