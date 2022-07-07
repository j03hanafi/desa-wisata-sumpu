<!doctype html>
<?php $uri = service('uri')->getSegments(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?> - Desa Wisata Kampuang Minang Nagari Sumpu</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/main/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main/map.css'); ?>">

    <?= $this->renderSection('styles') ?>
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo/favicon.svg'); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared/iconly.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,200,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url('assets/js/extensions/sweetalert2.js'); ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY"></script>
    <script src="<?= base_url('assets/js/map.js'); ?>"></script>
    <script src="https://kit.fontawesome.com/de7d18ea4d.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app">
        
        <!-- Sidebar -->
        <?php if (array_key_exists('id', $data)): ?>
            <?= $this->include('web/layouts/visitor_detail_sidebar'); ?>
        <?php else: ?>
            <?= $this->include('web/layouts/visitor_sidebar'); ?>
        <?php endif; ?>
        <!-- End Sidebar -->
        
        <!-- Main -->
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Tourism Village</h3>
                            <p class="text-subtitle text-muted">Desa Wisata Kampuang Minang Nagari Sumpu</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <a href="#" class="btn btn-primary float-end">Login</a>
                        </div>
                    </div>
                </div>
            </div>
            <script>setBaseUrl("<?= base_url(); ?>");</script>
            <!-- Content -->
            <?= $this->renderSection('content') ?>
            <!-- End Content -->

            <!-- Footer -->
            <?= $this->include('web/layouts/visitor_footer') ?>
            <!-- End Footer -->
        </div>
        <!-- End Main -->
    
    </div>

    <?= $this->renderSection('javascript') ?>
    <script src="<?= base_url('assets/js/app.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }, false);

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        });
    </script>
</body>
</html>