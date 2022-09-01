<?= $this->extend('maps/main'); ?>

<?= $this->section('content') ?>

<?php

// infoWindow


?>

<?= $this->include('maps/map-body'); ?>
<script>currentUrl = "mobile";</script>
<?php

if (isset($data)):
    foreach ($data as $item):
        $now = new DateTimeImmutable('now'); ?>
        <script>currentUrl = currentUrl + "<?= esc($item['id']); ?>"</script>
        <script>objectMarker("<?= esc($item['id']); ?>", <?= esc($item['lat']); ?>, <?= esc($item['lng']); ?>);</script>
    <?php
    endforeach;?>
    <script>boundToObject();</script>
<?php
endif;

?>

<?= $this->endSection() ?>
