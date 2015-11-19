<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
?>

<html>
<head>
    <?php include("inc/header.php"); ?>
</head>
<body>
<div id="container">
    <div id="content">
        <h2><?= $arr_portal_lang['credit_card_payment_failed'];?></h2>
        <p class="error">
           <?= $arr_portal_lang['try_again'];?>
        </p>

        <input type="button" onclick="window.location.href = 'index.php<?=$sessionurl2?>'" value="<?= $arr_portal_lang['button_return'];?>" />
    </div>
    <?php include("inc/footer.php"); ?>
</div>
</body>
</html>