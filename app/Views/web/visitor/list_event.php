<?= $this->extend('web/layouts/visitor_app'); ?>

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
                    <?= $this->include('web/layouts/header-map'); ?>
                </div>
            </div>
            <?= $this->include('web/layouts/main-map'); ?>
        </div>
    </div>
    
    <div class="col-md-4 col-12">
        <div class="row">
            <!-- List Event -->
            <div class="col-12" id="list-ev-col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">List Event</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive overflow-auto" id="table-user">
                            <script>clearMarker();</script>
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

            <!-- Check nearby -->
            <div class="col-12" id="check-nearby-col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Object Around</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" id="check-cp" class="form-check-input" checked>
                                <label for="check-cp">Culinary</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" id="check-wp" class="form-check-input">
                                <label for="check-cp">Worship</label>
                            </div>
                        </div>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" id="check-sp" class="form-check-input">
                                <label for="check-cp">Souvenir</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="inputRadiusNearby" class="form-label">Radius: </label>
                            <label id="radiusValueNearby" class="form-label">0 m</label>
                            <input type="range" class="form-range" min="0" max="50" value="0" id="inputRadiusNearby" name="inputRadius">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search result nearby -->
            <div class="col-12" id="result-nearby-col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Search Result Object Around</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive overflow-auto" id="table-result-nearby">
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-cp">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-wp">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-sp">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Direction section -->
<div class="row" id="direction-row">
    <div class="col-md-8 col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-center">Directions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-lg">
                        <thead>
                        <tr>
                            <th>Distance (m)</th>
                            <th>Steps</th>
                        </tr>
                        </thead>
                        <tbody id="table-direction">

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
<script>
    $('#direction-row').hide();
    $('#check-nearby-col').hide();
    $('#result-nearby-col').hide();

</script>
<?= $this->endSection() ?>
