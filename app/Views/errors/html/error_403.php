<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forbidden Access - Desa Wisata Kampuang Minang Nagari Sumpu</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/error.css'); ?>">
    <link rel="shortcut icon" href="<?= base_url('media/icon/favicon.svg'); ?>" type="image/x-icon">
</head>

<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="<?= base_url('assets/images/samples/error-403.svg'); ?>" alt="Not Found">
                    <h1 class="error-title">Forbidden</h1>
                    <p class="fs-5 text-gray-600"><?= lang('Auth.notEnoughPrivilege'); ?></p>
                    <a href="<?= previous_url(); ?>" class="btn btn-lg btn-primary mt-3">Back</a>
                    <a href="<?= base_url('web'); ?>" class="btn btn-lg btn-outline-primary mt-3">Home</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
