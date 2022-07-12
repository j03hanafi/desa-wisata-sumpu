<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section"">
    <div class="row">
        <!--map-->
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-auto">
                            <h5 class="card-title">Google Maps with Location</h5>
                        </div>
                        <?= $this->include('web/layouts/map-head'); ?>
                    </div>
                </div>
                <?= $this->include('web/layouts/map-body'); ?>
            </div>
        </div>
        
        <div class="col-md-4 col-12">
            <div class="row">
                <!-- List Rumah Gadang -->
                <div class="col-12" id="list-rg-col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">List Rumah Gadang</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive overflow-auto" id="table-user">
                                <script>clearMarker();clearRadius();clearRoute();</script>
                                <table class="table table-hover mb-0 table-lg">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-data">
                                    <?php if (isset($data)): ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($data as $item) : ?>
                                        <tr>
                                            <script>objectMarker("<?= esc($item['id']); ?>", <?= esc($item['lat']); ?>, <?= esc($item['lng']); ?>);</script>
                                            <td><?= esc($i); ?></td>
                                            <td class="fw-bold"><?= esc($item['name']); ?></td>
                                            <td>
                                                <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-primary mx-1" onclick="focusObject(`<?= esc($item['id']); ?>`);">
                                                    <span class="material-symbols-outlined">info</span>
                                                </a>
                                            </td>
                                            <?php $i++ ?>
                                        </tr>
                                    <?php endforeach; ?>
                                        <script>boundToObject();</script>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nearby section -->
                <?= $this->include('web/layouts/nearby'); ?>
            </div>
        </div>
    </div>

    <!-- Direction section -->
    <?= $this->include('web/layouts/direction'); ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $('#direction-row').hide();
    $('#check-nearby-col').hide();
    $('#result-nearby-col').hide();
    
</script>
<?= $this->endSection() ?>