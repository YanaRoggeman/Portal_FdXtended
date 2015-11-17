<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/upgrade_execute.php");

$isPortalPreview = isset($_SESSION['PORTAL']['preview']);

$plan=hsm_fetch_object($plans);
$outputPlans = '<input type="radio" checked name="plan" value="'.$plan->id.'" id="'.$plan->id.'"><label for="'.$plan->id.'" class="labelPlan">'.$plan->name.'</label>';
$outputPlans.= '<p class="planDescription">€'.$plan->price." - ".$plan->description.'</p><br/>';
while(@$plan=hsm_fetch_object($plans))
{
    $outputPlans .= '<input type="radio" name="plan" value="'.$plan->id.'" id="'.$plan->id.'"><label for="'.$plan->id.'" class="labelPlan">'.$plan->name.'</label>';
    $outputPlans .= '<p class="planDescription">€'.$plan->price." - ".$plan->description.'</p><br/>';
}
?>
<html>
<head>
    <?php include("inc/header.php"); ?>

</head>
<body>
    <div id="container">
        <div id="content">
            <h2><?= $arr_portal_lang["title_upgrade_profile"]; ?></h2>
            <p> <?= $arr_portal_lang["username"]; ?>: <?=$_SESSION['PORTAL']['upgrade_user']?> <br/>
                <?= $arr_portal_lang["current_billing_plan"]; ?>:  <?=$current_plan->name?> <br/>
                <?= $arr_portal_lang["timeleft"]; ?>: <?=calculateTimeUser_3(active_time_left($_SESSION['PORTAL']['upgrade_user']))?>
            </p>
            <p class="error"><?= $error;?></p>
                <?php if($_SESSION['upgrade'] != "successful"){ ?>
                  <!-- <legend><?= $arr_portal_lang["update_my_account"]; ?>:</legend> -->
                    <form name="loginForm" class="formFloatLeft" method="post" action="upgrade.php">
                        <fieldset>

                            <h3><?= $arr_portal_lang["update_my_account"]; ?>:</h3>

                            <?= $outputPlans ?>

                            <input type="submit" name="buy_plan" value="<?= $arr_portal_lang["button_upgrade"]; ?>" <?= $isPortalPreview ? "disabled" : ""; ?>><br/>

                        </fieldset>
                    </form>
                <?php
                }else {
                    ?>
                    <fieldset>
                        <p><?= $arr_portal_lang["account_has_been_updated"]; ?>.</p>
                    </fieldset>
                <?php
                    unset($_SESSION['upgrade']);
                }
                ?>

            <input type="button" value="<?= $arr_portal_lang["button_return"]; ?>" onclick="window.location.href = 'status.php'">
        </div>
        <?php include('inc/footer.php'); ?>
    </div>
</body>
</html>