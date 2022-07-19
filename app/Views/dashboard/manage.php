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
                        <a href="<?= current_url(); ?>/new" class="btn btn-primary float-end"><i class="fa-solid fa-plus me-3"></i> New <?= $category; ?></a>
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php if (isset($data)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                            <tr>
                                <td><?= esc($i); ?></td>
                                <?php if (isset($item['username'])): ?>
                                <td>@<?= esc($item['username']); ?></td>
                                <?php else: ?>
                                <td><?= esc($item['id']); ?></td>
                                <?php endif; ?>
                                <?php
                                    $name = '';
                                    if (isset($item['name'])) {
                                        $name = esc($item['name']);
                                    } elseif (isset($item['facility'])) {
                                        $name = esc($item['facility']);
                                    } else {
                                        $name = esc($item['first_name']) . ' ' . esc($item['first_name']);
                                    }
                                    
                                ?>
                                <td class="fw-bold"><?= esc($name); ?></td>
                                <td>
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-outline-primary mx-1" href="<?= current_url() .'/'. $item['id']; ?>">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= $item['id']; ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
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
