<?= $this->extend('web/layouts/visitor_app'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>currentUrl = '<?= current_url(); ?>';</script>
        <!-- Object Detail Information -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Event Information</h4>
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
                        <div class="col table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td class="fw-bold">Name</td>
                                    <td><?= esc($data['name']); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Category</td>
                                    <td><?= esc($data['category']); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Start</td>
                                    <td><?= date('d F Y', strtotime(esc($data['date_start']))); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">End</td>
                                    <td><?= date('d F Y', strtotime(esc($data['date_end']))); ?></td>
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
                            <p class="fw-bold">Description</p>
                            <p><?= esc($data['description']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Object Rating and Review -->
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Rating and Review</h4>
                    <p class="card-text">Please login to give rating and review</p>
                    <form class="form form-vertical">
                        <div class="form-body">
                            <div class="star-containter mb-3">
                                <i class="fa-solid fa-star fs-4" id="star-1" onclick="setStar('star-1');"></i>
                                <i class="fa-solid fa-star fs-4" id="star-2" onclick="setStar('star-2');"></i>
                                <i class="fa-solid fa-star fs-4" id="star-3" onclick="setStar('star-3');"></i>
                                <i class="fa-solid fa-star fs-4" id="star-4" onclick="setStar('star-4');"></i>
                                <i class="fa-solid fa-star fs-4" id="star-5" onclick="setStar('star-5');"></i>
                                <input type="hidden" id="star-rating" value="0">
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here"
                                      id="floatingTextarea" style="height: 150px;"></textarea>
                                    <label for="floatingTextarea">Comments</label>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end mb-3">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            </div>
                        </div>
                    </form>
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
        
        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Google Maps</h5>
                </div>
                <?= $this->include('web/layouts/main-map'); ?>
                <script>initMap(<?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>)</script>
                <script>objectMarker("<?= esc($data['id']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>);</script>
            </div>
            <!-- Object Media -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#gallery">
                            <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">image</span> Open Gallery
                        </button>
                        <button type="button" class="btn-play btn btn-outline-primary" data-bs-toggle="modal" data-src="<?= base_url('media/videos/'. esc($data['video_url'])); ?>" data-bs-target="#videoModal">
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
                                                        <img src="<?= base_url('media/photos/'. esc($gallery)); ?>" class="d-block w-100" alt="<?= esc($data['name']); ?>">
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
                                            <video
                                                    src=""
                                                    class="embed-responsive-item"
                                                    id="video"
                                                    controls
                                            >Sorry, your browser doesn't support embedded videos</video>
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
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    const myModal = document.getElementById('videoModal');
    const videoSrc = document.getElementById('video-play').getAttribute('data-src');

    myModal.addEventListener('shown.bs.modal', () => {
        console.log(videoSrc);
        document.getElementById('video').setAttribute('src', videoSrc);
    });
    myModal.addEventListener('hide.bs.modal', () => {
        document.getElementById('video').setAttribute('src', '');
    });
</script>
<?= $this->endSection() ?>