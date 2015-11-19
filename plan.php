<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/plan_execute.php");

/* Subscribers will land on this page if no default billing plan was configured.
 * Configure a default billing plan:
 *      Layout > Portal Page > rules > edit the rule you want > Enable Default billing plan
 * For reload cards:
 *      On creation choose a billing plan:
 *      Subscribers > Reload cards > add
 */

$userLoggedIn = $_SESSION['PORTAL']['user '] && isset($sessionid);

// Fetch the available billing plans
$plan=hsm_fetch_object($plans);
$outputPlans = '<input type="radio" checked name="plan" value="'.$plan->id.'" id="'.$plan->id.'"><label for="'.$plan->id.'" class="labelPlan">'.$plan->name.'</label>';
$outputPlans.= '<p class="planDescription">€'.$plan->price." - ".$plan->description.'</p><br/>';
while(@$plan=hsm_fetch_object($plans))
{
    $outputPlans .= '<input type="radio" name="plan" value="'.$plan->id.'" id="'.$plan->id.'"><label for="'.$plan->id.'" class="labelPlan">'.$plan->name.'</label>';
    $outputPlans .= '<p class="planDescription">€'.$plan->price." - ".$plan->description.'</p><br/>';
}

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

            <h2><?= $arr_portal_lang["title_select_plan"]; ?></h2>

            <p class="error"><?=$error.$error_guest?></p>

            <form name="selectPlan" class="formFloatLeft" action="<?=$form_action?>" method="post" onsubmit="this.selectPlan.disabled = true">
              <fieldset>
                <input type="hidden" name="login" value="true">
                <input type="hidden" name="username" value="<?=$_SESSION['PORTAL']['user']?>">
                <input type="hidden" name="password" value="<?=$_SESSION['PORTAL']['pass']?>">
                <?=$outputPlans?>
                <input type="submit" name="selectPlan" value="<?= $arr_portal_lang["plan_button"]; ?>" <?=($isPortalPreview ? "disabled":"")?>>
              </fieldset>
            </form>

            <form name="skipPlan" method="post" >
                <input type="hidden" name="continue" value="true">
                <input type="hidden" name="username" value="<?=$_SESSION['PORTAL']['user']?>">
                <input type="hidden" name="password" value="<?=$_SESSION['PORTAL']['pass']?>">
                <input type="submit" name="skipPlan" value="<?= $arr_portal_lang["btn_keep_plan"]; ?>" <?= ($isPortalPreview ? "disabled" : "") ?>>
            </form>

        </div>
        <?php include('inc/footer.php') ?>
    </div>
</body>
</html>