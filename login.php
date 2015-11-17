<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/login_execute.php");

/* All login types can be set on the portal
 * LAYOUT > PORTAL PAGE > OVERVIEW > Portalname > edit your portal > Login settings
 *
 * To set AUTOLOGIN for a user if he already logged in once, set MAC Authentication
 * If a status page is available it will redirect directly to it
 *  Layout > Portal Page > Edit portal page > Enable MAC based authentication
 */

/* Login with voucher is enabled
 * Subscribers > Create || Guest printing > (first create a package at Packages) > Create vouchers
 */$voucherLoginEnabled = $mail_setting->enable_voucher==1;

/* 'username/password' OR 'voucher code only' (username == password)
 * Layout > settings > Voucher code only
 */$voucherCodeOnly = $mail_setting->code_only == 1;

/* Guests can use their check-in information to log in
 * Periphery > PMS settings > PMS > Enable PMS module
 * To add a guest manually: Service > Rooms > Add +
 */$guestLoginEnabled =  $mail_setting->in_house_guest==1;

/*  Spg - Loyality membership
 *  if this is enabled show field for this
 */ $spgEnabled = $_SESSION['PORTAL']['spg'];

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
        <h2><?=$arr_portal_lang['title_login']?></h2>
        <p class="error"><?= $error.$error_guest ?> </p>

        <?php
        if($voucherLoginEnabled) {
            ?>

            <form name="loginForm" method="Post" onSubmit="this.loginbtn.disabled=true;">
                <fieldset>
                <input type="hidden" name="login" value="true">
                <?php

                if ($voucherCodeOnly) {
                    ?>
                    <label><?=$arr_portal_lang['voucher_code']?></label><br/>
                    <input type="text" name="username" value="<?= $username ?>"
                           onkeyup="document.loginForm.password.value = document.loginForm.username.value"><br/>
                    <input type="hidden" name="password">

                <?php
                } else {
                    ?>
                    <label><?=$arr_portal_lang['username']?>:</label>
                    <input type="text" name="username" value="<?= $user ?>"><br/>
                    <label><?=$arr_portal_lang['password']?>:</label>
                    <input type="password" name="password"> <br/>
                    <?php

                    // If allowed the user can change his password after login
                    // So if checked it will redirect immediately to password.php
                    // This is best set on the status page if enabled!
                    /*if ($change_pass_portal) {
                        <input type="checkbox" name="change_pass">
                        <label><?=$arr_portal_lang['update_profile']?></label> <br/>

                    }*/
                }

                ?>
                    <div class="rightColumnDiv">
                    <?php

                // Cookie based authentication
                // Layout > Portal page > edit your page > Cookie/MAC based authentication
                if ($cookie) {
                    ?>
                    <input type="checkbox" name="autologin" id="autologin">
                    <label for="autologin" ><?= $cookie_label ?></label> <br/>
                <?php
                }
                ?>
                   <input name="loginbtn" type="submit" <?= ($isPortalPreview ? "disabled" : "") ?> value="<?=$arr_portal_lang['login']?>"><br/>
                </div>
                </fieldset>
            </form>
            <?php
            }

        // Preregistered guest && payment type is 'fias'
        if($pmsfields->show)
        {
            ?>
            <form name="guestloginForm" method="post" onsubmit="this.guestlogin.disabled=true">
                <fieldset><legend><?=$arr_portal_lang['guest_login']?></legend>
               <input type="hidden" name="guestLogin" value="true">
                <?php
                    if($pmsfields->room)
                        echo '<label>'.$arr_portal_lang["room"].':</label> <input type="text" name="pms_room" value="' . $pmsfields->room_value . '"> <br/>';
                    if($pmsfields->room_readonly)
                        echo '<label>'.$arr_portal_lang["room"].':</label> <input type="text" name="pms_room" readonly value="'.$pmsfields->room_value.'"><br/>';

                    if($pmsfields->firstname)
                        echo '<label>'.$arr_portal_lang["first_name"].':</label> <input type="text" name="pms_firstname" value="' . $pmsfields->firstname_value . '"><br/>';

                    if($pmsfields->lastname)
                        echo '<label>'.$arr_portal_lang["last_name"].':</label>  <input type="text" name="pms_lastname" value="'.$pmsfields->lastname_value.'"><br/>';

                    if($pmsfields->vip)
                        echo '<label>'.$arr_portal_lang["vip"].':</label> <br/>  <input type="text" name="pms_vip" value="'.$pmsfields->vip_value.'"><br/>';

                    if($pmsfields->arrival)
                        echo '<label> '.$arr_portal_lang["arrival"].':</label> <input type="text" name="pms_arrival" value="'.$pmsfields->arrival_value.'"> <span class="example">ex: 29/08/05</span><br/>';

                    if($pmsfields->departure)
                        echo '<label>'.$arr_portal_lang["departure"].':</label> <input type="text" name="pms_departure" value="'.$pmsfields->departure_value.'"> <span class="example">ex: 29/08/05</span><br/>';

                    if($pmsfields->reservation)
                        echo '<label>'.$arr_portal_lang["reservation"].':</label>  <input type="text" name="pms_reservation" value="'. $pmsfields->reservation_value.'"><br/>';

                    if($pmsfields->def1) echo '<label>' .$fias_settings->field_definable1. ':</label> <input type="text" name="pms_def1" value="' .$pmsfields->def1_value. '"><br/>';
                    if($pmsfields->def2) echo '<label>' .$fias_settings->field_definable2. ':</label> <input type="text" name="pms_def2" value="' .$pmsfields->def2_value. '"><br/>';
                    if($pmsfields->def3) echo '<label>' .$fias_settings->field_definable3. ':</label> <input type="text" name="pms_def3" value="' .$pmsfields->def3_value. '"><br/>';
                    if($pmsfields->def4) echo '<label>' .$fias_settings->field_definable4. ':</label> <input type="text" name="pms_def4" value="' .$pmsfields->def4_value. '"><br/>';
                    if($pmsfields->def5) echo '<label>' .$fias_settings->field_definable5. ':</label> <input type="text" name="pms_def5" value="' .$pmsfields->def5_value. '"><br/>';
                    if($pmsfields->def6) echo '<label>' .$fias_settings->field_definable6. ':</label> <input type="text" name="pms_def6" value="' .$pmsfields->def6_value. '"><br/>';
                    if($pmsfields->def7) echo '<label>' .$fias_settings->field_definable7. ':</label> <input type="text" name="pms_def7" value="' .$pmsfields->def7_value. '"><br/>';
                    if($pmsfields->def8) echo '<label>' .$fias_settings->field_definable8. ':</label> <input type="text" name="pms_def8" value="' .$pmsfields->def8_value. '"><br/>';
                    if($pmsfields->def9) echo '<label>' .$fias_settings->field_definable9. ':</label> <input type="text" name="pms_def9" value="' .$pmsfields->def9_value. '"><br/>';
                    if($pmsfields->def10)echo '<label>' .$fias_settings->field_definable10.':</label> <input type="text" name="pms_def10"value="' .$pmsfields->def10_value.'"><br/>';

                ?>
                <div class="rightColumnDiv">
                <?php
                    if($cookie)    //User can enable cookies
                        echo '<input type="checkbox" name="autologin" id="autologin"><label for="autologin">'.$cookie_label.'</label><br/>';
                        ?>

                    <input type="submit" name="guestlogin" <?=($isPortalPreview ?"disabled":"")?> value="<?= $arr_portal_lang["login"]; ?>">
                </div>
                </fieldset>
            </form>
        <?php
        }

        if($spg){
            ?>
            <form method="POST" name="spgForm" onsubmit="this.spglogin.disabled = true">
                <fieldset>
                    <legend><?= $arr_portal_lang['spg_title']; ?></legend>
                <!-- <input type="hidden" value="spg">-->
                    <label><?= $arr_portal_lang['spg_label']; ?>:</label>
                    <input type="text" name="spg"><br/>

                    <div class="rightColumnDiv">
                        <input type="submit" name="spglogin" <?=($isPortalPreview ?"disabled":"")?>  value="<?= $arr_portal_lang["login"]; ?>">
                    </div>
                </fieldset>
            </form>
            <?php
        }

        // If a new account may be created provide a link to the subscriber page
        if(($paypal || $ccs || $reload_card)&& !$voucherCodeOnly) {
            ?>
              <input type="button" onclick="window.location.href = 'newuser.php'" value="<?= $arr_portal_lang["new_account"]; ?>"> <br/>
        <?php
        }
        ?>

    </div>
   <?php include("inc/footer.php") ?>
</div>
</body>
</html>