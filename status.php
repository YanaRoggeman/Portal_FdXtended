<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/hsm/include/initialize.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/hsm/status_execute.php");

/* The page on which logged in users will land if enabled
 * Layout > Portal page > [edit portal] > Post Authentication > enable/disable status page
 */

// If no active user a redirect should be set to go to login.php
if(!$_SESSION['PORTAL']['user'] && !isset($sessionid)) {
    header('Location:index.php');
}

/* ! WARNING:
 * ! This link should be equal to te link found at [NETWORK > DNS > DNS entries]
 * ! for the logout domain!
 */ $logoutLink = "http://logout.com";

/* ! WARNING:
 * ! This link should be equal to the link found at [NETWORK > DNS > DNS entries]
 * ! for the upgrade domain!
 */ $upgradeLink = "http://upgrade.com";

$publicIP = $_SESSION['PORTAL']['subscriber_ip'];
$time_left = active_time_left($_SESSION['PORTAL']['upgrade_user']);

//if isset $_SESSION['PORTAL']['FIAS_RN'] -/ pms account
if($_SESSION['PORTAL']['pms'] === true) {
    $roomNumber = $GUEST->room;
    $lastName = $GUEST->guest_name;
    $firstName = $GUEST->firstname;

    /*Values that can be used when PMS is enabled:

         * $GUEST->room                * $GUEST->reservation
         * $GUEST->floor               * $GUEST->title
         * $GUEST->checked_in          * $GUEST->firstname
         * $GUEST->guest_nr            * $GUEST->group
         * $GUEST->guest_name          * $GUEST->definable1 - ... - $GUEST->definable10
         * $GUEST->vip                 * $GUEST->lang
         * $GUEST->arrival             * $GUEST->nopost
         * $GUEST->departure            */


/* If you want to know if the current account is a PMS account
 */ $userIsPMS = ($roomNumber != "");

}
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php include("inc/header.php"); ?>

    <script type='text/javascript' src='js/status.js'></script>
    <script type='text/javascript'>
        //Used to show the graph & Update the sessions & the bandwidth
        function Load(sessionId){

            /* Set the divs for the status data and retrieve Status data */
            loadError = "<?= $arr_portal_lang['loading_failed']; ?>";
            divsUserData.loading =            document.getElementById("loading");

            divsUserData.status =             document.getElementById("status");

            divsUserData.plan_name =          document.getElementById("plan_name");
            divsUserData.plan_description =   document.getElementById("plan_description");
            divsUserData.plan_price =         document.getElementById("plan_price");

            divsUserData.totalTime_sec =      document.getElementById("total_time_sec");
            divsUserData.timeLeft_sec =       document.getElementById("timeleft");
            divsUserData.timeLeftText =       document.getElementById("timeleft_text");

            divsUserData.totalVolumeDown =    document.getElementById("total_volume_down");
            divsUserData.volumeDownLeft =     document.getElementById("volume_down_left");
            divsUserData.volumeDownText =     document.getElementById("volume_down_left_text");
            divsUserData.percentVolumeDown =  document.getElementById("percent_volume_up");

            divsUserData.totalVolumeUp =      document.getElementById("total_volume_up");
            divsUserData.volumeUpLeft =       document.getElementById("volume_up_left");
            divsUserData.volumeUpText =       document.getElementById("volume_up_left_text");
            divsUserData.percentVolumeUp =    document.getElementById("percent_volume_down");


            divsUserData.startTime =          document.getElementById("start_time");
            divsUserData.endTime=             document.getElementById("end_time");
            divsUserData.pms_user =           document.getElementById("pms_user");

            RefreshStatusData(sessionId);

            /* Draw the graph for the usage
             * For use enable:
             */
            SetBandwidthCanvas("bandwidth_graph");
            RefreshBandwidth(sessionId);

            SetSessionDivs("sessions");
            RefreshSessions(sessionId);
        }
    </script>

</head>
<body onload="Load('<?=($_GET["sessionid"]!=""?$_GET["sessionid"]:"")?>');" >
<div id="container">
    <div id="content" class="statusPage">
        <h2><?= ($lastName == "") ? $username : $firstName." ".$lastName ?>,</h2>
        <fieldset>
        <div class="divFloatLeft">
            <div id="error"></div>
            <h4 class="italic"><?= $publicIP ?></h4>
            <?php
            if($userIsPMS){
                echo "room: ".$roomNumber;
            }
            ?>
            <p id="status"></p>
            <p id="loading"></p>

            <p>
                <span id="plan_name"></span> - <span id="plan_price"></span><br/>
                <span id="plan_description" class="italic"> </span>
            </p>

            <p>
                <span id="start_time"></span> <br/>
                to
                <span id="end_time"></span>
            </p>
            <p>used
            <span id="timeleft" ></span> of <span id="total_time_sec" ></span> <br/>
            <span id="timeleft_text" ></span><br/>
            </p>
            <p id="total_volume_down" >     </p>
            <p id="volume_down_left">       </p>
            <p id="volume_down_left_text">  </p>
            <p id="percent_volume_down" >   </p>

            <p id="total_volume_up">    </p>
            <p id="volume_up_left">     </p>
            <p id="volume_up_left_text"></p>
            <p id="percent_volume_up" > </p>
            <p id="pms_user" hidden>    </p>

        </div>

        <div class="divFloatRight">

            <input type="button" value="<?= $arr_portal_lang["upgrade_billing_plan"]; ?>" onclick="window.location.href ='<?= $upgradeLink?>'">

            <?php
            if($change_pass_portal && !$userIsPMS) {   // If the user is not PMS and can change the password
                ?>
                <input type="button" value="<?= $arr_portal_lang["change_password"]; ?>" onclick="window.location.href = 'password.php'">
                <?php
            }
            ?>

            <input type="button" value="<?= $arr_portal_lang["logout"]; ?>" onclick="window.location.href = '<?= $logoutLink?>'">
        </div>
        </fieldset>

        <div id="bandwidthCanvas">
            <canvas id='bandwidth_graph'>
                <?=$arr_portal_lang["html5_not_supported"]?>
            </canvas>
        </div>

        <div id="sessions">
            <!-- Gets data from Js function refresh_sessions() -->
        </div>

        <br/>

    </div>
    <?php include('inc/footer.php') ?>
</div>
</body>
</html>