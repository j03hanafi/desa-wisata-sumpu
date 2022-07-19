<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/pages/form-element-select.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>currentUrl = '<?= current_url(); ?>';</script>
        
        <!-- Object Detail Information -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">New Rumah Gadang</h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="<?= base_url('dashboard/rumahGadang'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group mb-4">
                                <label for="geo-json" class="mb-2">GeoJSON</label>
                                <input type="text" id="geo-json" class="form-control"
                                       name="geo-json" placeholder="GeoJSON" readonly="readonly" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="name" class="mb-2">Rumah Gadang Name</label>
                                <input type="text" id="name" class="form-control"
                                       name="name" placeholder="Rumah Gadang Name" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="address" class="mb-2">Address</label>
                                <input type="text" id="address" class="form-control"
                                       name="address" placeholder="Address">
                            </div>
                            <div class="form-group mb-4">
                                <label for="open" class="mb-2">Opening Hours</label>
                                <div class="input-group">
                                    <input type="time" id="open" class="form-control"
                                           name="open" placeholder="Opening Hours" aria-label="Opening Hours" aria-describedby="open" required>
                                    <span class="input-group-text">WIB</span>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="close" class="mb-2">Closing Hours</label>
                                <div class="input-group">
                                    <input type="time" id="close" class="form-control"
                                           name="close" placeholder="Closing Hours" aria-label="Closing Hours" aria-describedby="close" required>
                                    <span class="input-group-text">WIB</span>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="ticket_price" class="mb-2">Ticket Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp </span>
                                    <input type="number" id="ticket_price" class="form-control"
                                           name="ticket_price" placeholder="Ticket Price" aria-label="Ticket Price" aria-describedby="ticket-price">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="contact_person" class="mb-2">Contact Person</label>
                                <input type="tel" id="contact_person" class="form-control"
                                       name="contact_person" placeholder="Contact Person">
                            </div>
                            <fieldset class="form-group mb-4">
                                <label for="status" class="mb-2">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Homestay">Homestay</option>
                                    <option value="Tidak Homestay" selected>Tidak Homestay</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group mb-4">
                                <script>getListUsers();</script>
                                <label for="ownerSelect" class="mb-2">Owner</label>
                                <select class="form-select" id="ownerSelect" name="owner" required>
                                </select>
                            </fieldset>
                            <div class="form-group mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="facilities" class="mb-2">Facilities</label>
                                <select class="choices form-select multiple-remove" multiple="multiple" id="facilities" name="facilities[]">
                                    <?php foreach ($facilities as $facility): ?>
                                    <option value="<?= esc($facility['id']); ?>"><?= esc($facility['facility']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="gallery" class="form-label">Gallery</label>
                                <input class="form-control" type="file" name="gallery[]" id="gallery" multiple>
                            </div>
                            <div class="form-group mb-4">
                                <label for="video" class="form-label">Video</label>
                                <input class="form-control" type="file" name="video" id="video">
                            </div>
                            
                            <button type="submit" class="btn btn-primary me-1 mb-1" onclick="checkRequired();">Submit</button>
                            <button type="reset"
                                    class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h5 class="card-title">Google Maps</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="eg. -0.52435750">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="eg. 100.49234850">
                            </div>
                        </div>
                        <div class="col-auto mx-1">
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search" class="btn icon btn-outline-primary" onclick="findCoords('RG');">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                        </div>
                        <div class="col-auto mx-1">
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clear" class="btn icon btn-outline-danger" id="clear-drawing">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <?= $this->include('web/layouts/map-body'); ?>
                <script>initDrawingManager();</script>;
            </div>
            <!-- Object Media -->
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>
<script>getFacility();</script>
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
    
    function checkRequired() {
        if (!$('#geo-json').val()) {
            Swal.fire('Please select location for the New Rumah Gadang');
        }
    }
</script>
<?= $this->endSection() ?>

