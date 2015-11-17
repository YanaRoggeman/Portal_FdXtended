<link rel="stylesheet" type="text/css" href="css/style.css">
<meta name="viewport" content="width=device-width; initial-scale=1, minimum-scale=1;">
<meta name="format-detection" content="telephone=no" />
<title>HSMX sample portal</title>

<?php
/* FAVICON -----------------------
 * Replace the $path to your icon
 */$path = 'img/icon.ico';

$data = file_get_contents($path, PATHINFO_EXTENSION);
$base64 = base64_encode($data);
$link = '<link rel="icon" type="image/'.$path.'" href="data:image/png;base64,'.$base64.' " />';
echo $link;