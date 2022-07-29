<?php
$uri = service('uri')->getSegments();
$users = in_array('users', $uri);
?>

<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="card">
            <div class="card-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="card-title">Manage <?= $category; ?></h3>
                    </div>
                    <?php if ($category != 'Users'): ?>
                    <div class="col">
                        <a href="<?= current_url(); ?>/new" class="btn btn-primary float-end"><i class="fa-solid fa-plus me-3"></i> New <?= $category; ?></a>
                    </div>
                    <?php endif; ?>
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
                            <?php if (count($data) > 0 && array_key_exists('role', $data[0])): ?>
                            <th>Role</th>
                            <?php endif; ?>
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
                                        $name = esc($item['first_name']) . ' ' . esc($item['last_name']);
                                    }
                                    
                                ?>
                                <td class="fw-bold"><?= esc($name); ?></td>
                                <?php if (isset($item['role'])): ?>
                                <td><?= ucfirst(esc($item['role'])); ?></td>
                                <?php endif; ?>
                                <td>
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-outline-primary mx-1" href="<?= (isset($item['facility'])) ? base_url('dashboard/facility/edit') . '/' . esc($item['id']) : current_url() .'/'. esc($item['id']); ?>">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger mx-1" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($name); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
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
                    targets: ['_all'],
                    className: 'dt-head-center'
                }
            ],
            lengthMenu: [ 5, 10, 20, 50, 100 ]
        });
    } );
</script>
<?= $this->endSection() ?>
