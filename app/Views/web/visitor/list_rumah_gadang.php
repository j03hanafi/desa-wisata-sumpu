<?= $this->extend('web/layouts/visitor_app'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <!--map-->
        <div class="col-md-7 col-12">
            <div class="card">
                <?= $this->include('web/layouts/main-map'); ?>
            </div>
        </div>
        
        <!--  -->
        <div class="col-md-5 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">List Rumah Gadang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto" id="table-user">
                        <table class="table table-hover mb-0 table-lg">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td class="fw-bold"><?= esc($item['name']); ?></td>
                                    <td>
                                        <a target=”_blank” href="<?= base_url('/web/rumahGadang/' . esc($item['id'])); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-primary mx-1"><span class="material-symbols-outlined">info</span></a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Route" onclick="routeTo(<?= esc($item['lat']); ?>, <?= esc($item['long']); ?>)" class="btn icon btn-primary mx-1"><span class="material-symbols-outlined">directions_car</span></a>
                                    </td>
                                    <?php $i++ ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY&callback=initMap">
</script>
<?= $this->endSection() ?>
