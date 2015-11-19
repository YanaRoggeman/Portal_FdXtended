<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/password_execute.php");

/*
 * Lets the active user changes his password
 * Best use is to put a link on the status.php page
 * If you do not use a status page enable the checkbox on login.php
 */

// ! For proper use > Redirect if the user is not allowed to change his password
// ! Service > Password Policy > Create or edit > 'Change password on portal'
if(!$change_pass_portal) {
    if($_SESSION['PORTAL']['user']) {
        header('Location:status.php');
    }else{
        header('Location:index.php');
    }
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
        <h2><?= $arr_portal_lang['title_password'] ?></h2>
            <p class="error"?><?= $error; ?></p>

            <p>
            <?php
            if($password_changed)
               echo $arr_lang_portal["success_changed_password"];
            ?>
            </p>

        <form name="passwordForm" method="post" onsubmit="this.submitbutton.disabled = true">
            <input type="hidden" value="true" name="submit">
            <fieldset>

                <label><?= $arr_portal_lang["username"]; ?>:</label>
                <input type="text" name="username" disabled value="<?=$_SESSION['PORTAL']['user']?>" readonly><br/>

                <label><?= $arr_portal_lang["new_password"]; ?>:</label>
                <input type="password" name="password"><br/>

                <label><?= $arr_portal_lang["re_new_password"]; ?>:</label>
                <input type="password" name="re_password"><br/>

                <div class="rightColumnDiv">
                    <input type="submit" name="submitbutton" <?=($isPortalPreview ? "disabled":"")?> value="Change"><br/>
                </div>

            </fieldset>
        </form>

        <input type="button" value="<?= $arr_portal_lang["button_return"]; ?>" onclick="window.location.href = 'status.php<?=$sessionurl2?>'">
    </div>
    <?php include('inc/footer.php'); ?>
</div>
</body>
</html>