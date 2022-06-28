<?= $this->extend('web/layouts/visitor_app'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        
        <!-- Object Detail Information -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Rumah Gadang Information</h4>
                    <div class="text-center">
                        <?php for ($i = 0; $i < (int)esc($data['avg_rating']); $i++) { ?>
                            <span class="material-symbols-outlined rating-color">star</span>
                        <?php } ?>
                        <?php for ($i = 0; $i < (5 - (int)esc($data['avg_rating'])); $i++) { ?>
                            <span class="material-symbols-outlined">star</span>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Description</p>
                            <p><?= esc($data['description']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Address</td>
                                        <td><?= esc($data['address']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Open</td>
                                        <td><?= date('H:i', strtotime(esc($data['open']))) . ' WIB'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Close</td>
                                        <td><?= date('H:i', strtotime(esc($data['close']))) . ' WIB'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Ticket Price</td>
                                        <td><?= 'Rp ' . number_format(esc($data['ticket_price']), 0, ',','.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Contact Person</td>
                                        <td><?= esc($data['contact_person']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Facilities</p>
                            <?php $i = 1; ?>
                            <?php foreach ($data['facilities'] as $facility) : ?>
                                <p><?= esc($i) . '. ' . esc($facility); ?></p>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Google Maps</h5>
                </div>
                <div class="card-body">
                    <div class="maps-detail" id="googlemaps"></div>
                </div>
            </div>
            <!-- Object Media -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#gallery">
                            <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">image</span> Open Gallery
                        </button>
                        <button type="button" class="btn-play btn btn-outline-primary" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/PlpqhZiumDM" data-bs-target="#videoModal">
                            <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">play_circle</span> Play Video
                        </button>

                        <div class="modal fade text-left" id="gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel17">Gallery</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <?php $i = 0; ?>
                                                <?php foreach ($data['gallery'] as $gallery) : ?>
                                                    <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= esc($i); ?>" class="<?= ($i == 0) ? 'active' : ''; ?>"></li>
                                                    <?php $i++; ?>
                                                <?php endforeach ; ?>
                                            </ol>
                                            <div class="carousel-inner">
                                                <?php $i = 0; ?>
                                                <?php foreach ($data['gallery'] as $gallery) : ?>
                                                <div class="carousel-item<?= ($i == 0) ? ' active' : ''; ?>">
                                                    <img src="<?= base_url('assets/images/samples/banana.jpg'); ?>" class="d-block w-100" alt="...">
                                                </div>
                                                <?php $i++; ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade text-left" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel17">Video</h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="ratio ratio-16x9">
                                            <iframe
                                                    class="embed-responsive-item"
                                                    src=""
                                                    id="video"
                                                    allowfullscreen
                                                    allowscriptaccess="always"
                                                    allow="autoplay"
                                            ></iframe>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Object Rating and Review -->
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Rating and Review</h4>
                    <p class="card-text">Please login to give rating and review</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <tbody>
                            <?php foreach ($data['reviews'] as $review):  ?>
                                <tr>
                                    <td>
                                        <p class="mb-0">
                                            <?php for ($i = 0; $i < (int)$review['rating']; $i++) { ?>
                                                <span class="material-symbols-outlined rating-color">star</span>
                                            <?php } ?>
                                            <?php for ($i = 0; $i < (5 - (int)$review['rating']); $i++) { ?>
                                                <span class="material-symbols-outlined">star</span>
                                            <?php } ?>
                                        </p>
                                        <p class="mb-0"><?= "{$review['first_name']} {$review['last_name']}"; ?></p>
                                        <p class="fw-light"><?= date('Y-m-d', strtotime($review['created_at'])); ?></p>
                                        <?php if (!empty($review['comment'])) { ?>
                                        <p class="fw-bold"><?= $review['comment']; ?></p>
                                        <?php } ?>
                                    </td>
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY&callback=initMap">
</script>
<script>
    (function ($) {
        // Modal Video
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);
        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })
        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    })(jQuery);
</script>
<?= $this->endSection() ?>

