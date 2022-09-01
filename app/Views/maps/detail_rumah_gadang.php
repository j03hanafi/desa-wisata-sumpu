<?= $this->extend('maps/main'); ?>

<?= $this->section('content') ?>

    <section class="section">
        <div class="row">
            <script>currentUrl = '<?= current_url(); ?>';</script>

            <!-- Object Detail Information -->
            <div class="col-12">
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
                                <p class="fw-bold">Description</p>
                                <p><?= esc($data['description']); ?></p>
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

                <!-- Object Media -->
                <?= $this->include('web/layouts/gallery_video'); ?>

                <!--Rating and Review Section-->
                <?= $this->include('web/layouts/review'); ?>
            </div>
        </div>
    </section>

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