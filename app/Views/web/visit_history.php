<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>
    
<section class="section"">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">Visit History</h4>
                </div>
                <div class="col">
                    <a href="<?= base_url('web/visitHistory/add'); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-plus me-3"></i>Add Visit History</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-12 table-responsive">
                    <table class="table table-hover mb-0 table-lg">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Object</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($data)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                            <tr class="text-center">
                                <td><?= esc($i); ?></td>
                                <td><?= date('Y-m-d', strtotime(esc($item['date_visit']))); ?></td>
                                <td class="fw-bold"><?= esc($item['object_name']); ?></td>
                            </tr>
                            <?php $i++ ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>