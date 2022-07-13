<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>
    
    <section class="section"">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Visit History</h4>
        </div>
        <div class="card-body">
            <form class="form form-vertical" action="<?= base_url('web/visitHistory'); ?>" method="post" onsubmit="checkForm(event);">
                <div class="form-body">
                    <div class="row gx-md-5">
                        <div class="col-md-8 col-12 order-md-first order-last">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="object" class="mb-2">Category</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" name="category" id="category" onchange="getObjectByCategory();">
                                                <option value="None">---</option>
                                                <option value="1">Rumah Gadang</option>
                                                <option value="2">Event</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="object" class="mb-2">Object</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="object" name="object_id">
                                                <option value="None">Select Category First</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="date" class="mb-2">Date</label>
                                        <div class="input-group date" id="datepickerVH">
                                            <input type="text" class="form-control" id="date" value="<?= date('Y-m-d'); ?>" name="date_visit">
                                            <div class="input-group-addon ms-2">
                                                <i class="fa-solid fa-calendar-days" style="font-size: 1.5rem; vertical-align: bottom"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mb-3">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </section>

<?= $this->endSection() ?>
