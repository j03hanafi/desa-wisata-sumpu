<?= $this->extend('web/layouts/visitor_app'); ?>

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
                        <tr class="text-center">
                            <td>1</td>
                            <td>22 Juni 2022</td>
                            <td class="fw-bold">Name</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>