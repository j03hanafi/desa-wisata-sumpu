<?= $this->extend('web/layouts/visitor_app'); ?>

<?= $this->section('content') ?>

<section class="section">
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
                <!--popular-->
                <div class="col-12" id="list-rec-col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">Recommendation</h5>
                        </div>
                        <div class="card-body">
                            <?php $i = 0; ?>
                            <script>clearMarker();clearRadius();clearRoute();</script>
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php foreach ($data as $item) : ?>
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= esc($i); ?>" class="<?= ($i == 0) ? 'active' : ''; ?>"></li>
                                        <?php $i++; ?>
                                    <?php endforeach ; ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php $i = 0; ?>
                                    <?php foreach ($data as $item) : ?>
                                        <div class="carousel-item<?= ($i == 0) ? ' active' : ''; ?>">
                                            <script>objectMarker("<?= esc($item['id']); ?>", <?= esc($item['lat']); ?>, <?= esc($item['lng']); ?>);</script>
                                            <a>
                                                <img src="<?= base_url('media/photos/' . esc($item['gallery'][0])); ?>" class="d-block w-100" alt="<?= esc($item['name']); ?>" onclick="focusObject(`<?= esc($item['id']); ?>`);">
                                            </a>
                                            <div class="carousel-caption d-none d-md-block">
                                                <?php $i++; ?>
                                                <h5><?= esc($item['name']); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
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
                            <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusNearby" name="inputRadius" onchange="updateRadius('Nearby');">
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

