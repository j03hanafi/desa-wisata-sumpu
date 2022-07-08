<?= $this->extend('web/layouts/visitor_app'); ?>

<?= $this->section('content') ?>
    
    <section class="section"">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Visit History</h4>
        </div>
        <div class="card-body">
            <form class="form form-vertical">
                <div class="form-body">
                    <div class="row gx-md-5">
                        <div class="col-md-8 col-12 order-md-first order-last">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="object" class="mb-2">Category</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="category" onchange="getObjectByCategory();">
                                                <option value="None">---</option>
                                                <option value="RG">Rumah Gadang</option>
                                                <option value="EV">Event</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="object" class="mb-2">Object</label>
                                        <fieldset class="form-group">
                                            <select class="form-select" id="object">
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="date" class="mb-2">Date</label>
                                        <div class="input-group date" id="datepickerVH">
                                            <input type="text" class="form-control" id="date">
                                            <div class="input-group-addon ms-2">
                                                <i class="fa-solid fa-calendar-days" style="font-size: 1.5rem; vertical-align: bottom"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mb-3">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Add</button>
                                    <button type="reset"
                                            class="btn btn-light-secondary me-1 mb-1">Reset</button>
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