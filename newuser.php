<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/newuser_execute.php");

/* If only one payment method is available, this page will autoredirect to the correct link
 * Layout > Portal page > rules > [edit] > Select payment methods
 */

// Testing variable, are we in preview mode?
   $GuestLoginEnabled = $mail_setting->in_house_guest == 1;
?>
<html>
<head>
    <?php include("inc/header.php"); ?>

</head>
<body>
<div id="container">
    <div id="content">
        <h2><?= $arr_portal_lang["title_select_payment"]; ?></h2>
        <p class="error"><?= $error?></p>
        <?php

        if($ccs){
            ?>
            <input type="button" onclick="window.location='<?=$linkcc?>'" value="<?= $arr_portal_lang["pay_by_credit_card"]; ?>"><br/>
        <?php
        }

        if($reload_card){                  // Default
            ?>
            <input type="button" onclick="window.location='<?=$linkreload_card?>'" value="<?= $arr_portal_lang["pay_by_reload_card"]; ?>"><br/>
        <?php
        }

        if($paypal){                       // Periphery > Credit card settings > Paypal settings
            ?>
            <input type="button" onclick="window.location='<?=$linkpaypal?>'" value="<?= $arr_portal_lang["pay_by_paypal"]; ?>">
        <?php
        }

        ?>
    </div>
    <?php include("inc/footer.php") ?>
</div>
</body>
</html>