<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/subscribe_execute.php");

/* Page after paying type has been set (redirect from: newuser.php)
 * The user is able to create an account (and if needed insert his reload card code)
 */

// Determine which paytype is used
   $PayTypeIsFias = $_SESSION['PORTAL']['pay_type'] == 'fias';
   $PayTypeIsPMS = $_session['PORTAL']['pay_type'] == "pms";
   $PayTypeIsReloadCard = $_SESSION['PORTAL']['pay_type'] == 'reload_card';
   $PayTypeIsCreditCard = $_SESSION['PORTAL']['pay_type']=="cc";

// If paytype is empty redirect so a payment type can be chosen
    if($_SESSION['PORTAL']['pay_type'] == "")
        header('Location: newuser.php');

// A user is active or not
   $ActiveUserSession = isset($_SESSION['PORTAL']['user']);

// Subscriber can retrieve an invoice (When payment method Creditcard is enabled)
// Periphery > credit card settings > Enable invoice for credit card
   $GetInvoice = $gener->ccs_invoice=="1";

// Testing variable, are we in preview mode?
   $isPortalPreview = isset($_SESSION['PORTAL']['preview']);
?>
<html>

<head>
    <?php include("inc/header.php"); ?>

</head>
<body>
<div id="container">
    <div id="content">

        <h2><?= $arr_portal_lang["title_subscribe"]; ?></h2>

        <p class="error"><?= $error ?> </p>

        <form name="subscribeForm" method="post" onsubmit="this.btnAccount.disabled = true">
           <fieldset>
           <input type="hidden" name="formsubmitted" value="true">
            <?php
            if(!$ActiveUserSession) {
                ?>
                <label><?= $arr_portal_lang["username"]; ?>:</label>
                <input type="text" name="user" value="<?=$_POST['user']?>"> <br/>

                <label><?= $arr_portal_lang["password"]; ?>:</label>
                <input type="password" name="pass1" value="<?= $_POST['pass1']?>"> <br/>

                <label><?= $arr_portal_lang["re_enter_password"]; ?>:</label>
                <input type="password" name="pass2" value="<?=$_POST['pass2']?>"> <br/>
            <?php
            }
            ?>

            <input type="hidden" name="firstname" maxlength="50" value="<?= $firstname ?>">

            <?php
            if ($GetInvoice && $PayTypeIsCreditCard) {   //Invoice should only be possible on creditcard payment
                ?>

                <input type="hidden" name="lastname" maxlength="50" value="novalue">
                <label for="cbInvoice" class="checkboxLabel"><?= $arr_portal_lang["invoice"]; ?>:</label>
                <div class="rightColumnDiv">
                    <input type="checkbox" id="cbInvoice" name="invoice" value="<?= $invoice ?>">
                </div>
                <br/>
            <?php
            }

            if($PayTypeIsReloadCard){?>
                <label><?= $arr_portal_lang["voucher_code"]; ?>:</label>
                <input type="text" name="voucher_code" value="<?=$voucher_code?>"><br/>

            <?php
            }
            ?>
            <br/>
            <div class="rightColumnDiv">
            <?php
            if($cookie){?>
                <input type="checkbox" name="autologin" id="autologin"><label for="autologin"><?=$cookie_label?></label> <br/>

            <?php
            }
            ?>
                <input type="submit" name="btnAccount" value="<?= $arr_portal_lang["create_account"]; ?>" <?=($isPortalPreview ?"disabled":"")?>>
                </div>
            </fieldset>
        </form>
    </div>
    <?php include("inc/footer.php") ?>
</div>
</body>
</html>