<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>currentUrl = '<?= current_url(); ?>';</script>
        
        <!-- Object Detail Information -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
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
                        <div class="col-auto">
                            <a href="<?= base_url('dashboard/event/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                        </div>
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
                                    <td class="fw-bold">Event Date</td>
                                    <td><?= date('d F Y', strtotime(esc($data['date_next']))); ?></td>
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
                            <p class="fw-bold">Calendar</p>
                            <div class="table-responsive">
                                <table class="table table-hover dt-head-center" id="table-manage">
                                    <thead>
                                    <tr>
                                        <th>Event Date</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    <?php if (isset($data['calendar'])): ?>
                                        <?php foreach ($data['calendar'] as $item) : ?>
                                            <tr>
                                                <td><?= date('d F Y', strtotime(esc($item))); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
                
                <?= $this->include('web/layouts/map-body'); ?>
                <script>initMap(<?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>)</script>
                <script>objectMarker("<?= esc($data['id']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>);</script>
            </div>

            <!-- Object Media -->
            <?= $this->include('web/layouts/gallery_video'); ?>
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
    $(document).ready( function () {
        $('#table-manage').DataTable({
            order: [],
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