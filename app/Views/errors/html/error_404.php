<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Desa Wisata Kampuang Minang Nagari Sumpu</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/error.css'); ?>">
    <link rel="shortcut icon" href="<?= base_url('media/icon/favicon.svg'); ?>" type="image/x-icon">
</head>
<body>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="<?= base_url('assets/images/samples/error-404.svg'); ?>" alt="Not Found">
                    <h1 class="error-title">NOT FOUND</h1>
                    <p class="fs-5 text-gray-600">
                        <?php if (! empty($message) && $message !== '(null)') : ?>
                            <?= nl2br(esc($message)) ?>
                        <?php else : ?>
                            Sorry! Cannot seem to find the page you were looking for.
                        <?php endif ?>
                    </p>
                    <a href="<?= previous_url(); ?>" class="btn btn-lg btn-outline-primary mt-3">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
