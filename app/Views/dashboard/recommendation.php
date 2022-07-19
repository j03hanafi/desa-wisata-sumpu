<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="card">
            <div class="card-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="card-title">Manage <?= $category; ?></h3>
                    </div>
                    <div class="col">
                        <a href="<?= current_url(); ?>/add" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk me-3"></i>Save</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover dt-head-center" id="table-manage">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Recommendation</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php if (isset($data)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                            <tr>
                                <td><?= esc($i); ?></td>
                                <td><?= esc($item['id']); ?></td>
                                <td class="fw-bold"><?= esc($item['name']); ?></td>
                                <td>
                                    <script>getRecommendation(`<?= esc($item['id']); ?>`, `<?= esc($item['recom']); ?>`);</script>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="recommendationSelect<?= esc($item['id']); ?>">
                                        </select>
                                    </fieldset>
                                </td>
                                <?php $i++ ?>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $(document).ready( function () {
        $('#table-manage').DataTable({
            columnDefs: [
                {
                    targets: [0, 1, 2, 3],
                    className: 'dt-head-center'
                }
            ]
        });
    } );
</script>
<?= $this->endSection() ?>
