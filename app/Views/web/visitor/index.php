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

        <!--popular-->
        <div class="col-md-5 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">Recommendation</h5>
                </div>
                <div class="card-body">
                <?php $i = 0; ?>
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
                                <a href="<?= base_url('/web/rumahGadang/'.esc($item['id'])); ?>">
                                    <img src="<?= base_url('assets/images/samples/1.png'); ?>" class="d-block w-100" alt="...">
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
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY&callback=initMap">
</script>
<?= $this->endSection() ?>

