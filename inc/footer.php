<?php
/* FAVICON -----------------------
 * Replace the $path to your logo
 */$path = 'img/Logo.png';
$data = file_get_contents($path, PATHINFO_EXTENSION);
$base64 = base64_encode($data);
?>

<div id="footer">
    <img src="data:image/png;base64,<?= $base64;?>">
</div>