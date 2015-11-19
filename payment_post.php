<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
include($_SERVER['DOCUMENT_ROOT']."/hsm/include/paypal_ok_execute");
?>
<html>
<head>
    <?php include("inc/header.php"); ?>
    <script language="javascript">

        function time_go(seconds )
        {
            if ( seconds == 0 )
            {
                document.waitform.submit();
            }
            else
            {
                document.getElementById("sec").innerHTML=seconds;
                var func = 'time_go(' + (seconds - 1) + ');';
                setTimeout( func, 1000 );
            }
        }
    </script>
</head>
<body>
<div id="container">
    <div id="content">
        <h2>Success</h2>
        <p>
        <?php
            if($confirmed){
                ?>
                <p>
                    Thank you puchasing internet access!<br>
                    Your account (<i><?=$form_username?></i>) has been created.<br>
                </p>
            <form name="loginForm" method="post" action="login.php<?=$sessionurl2?>" onSubmit="this.submitbutton.disabled=true;">
                <input type="hidden" name="login" value="true">
                <input type="hidden" name="username" value="<?=$form_username?>">
                <input type="hidden" name="password" value="<?=$form_password?>">
                <input type="hidden" name="email" value="<?=$email?>">
                <?php
                if($_SESSION['PORTAL']['autologin']=="on")
                {
                    ?>
                    <input type="hidden" name="autologin" value="$cookie">
                <?php
                }
                ?>
                <input name="submitbutton" type="submit" value="Connect to the internet">
            </form>
        <?php
            }else{ ?>
            <p>
                Thank you purchasing internet access!<br>
                We are waiting for confirmation to generate your account "<i><?=$_SESSION['PORTAL']['user']?></i>".<br>&nbsp;<br>
                Checking in <span id="sec"></span>&nbsp;seconds.
            </p>
            <form name="waitform" method="get" action="payment_post.php">
            <input type="hidden" name="sessionid" value="<?=$sessionid?>">
            <input type="hidden" name="orderID" value="<?=$_SESSION['PORTAL']['orderID']?>">
            <input type="submit" value="check now!">
            </form>
            <script language="javascript">
                time_go(5);
            </script>
       <?php }
        ?>
        </p>
   </div>
    <?php include("inc/footer.php"); ?>
</div>
</body>
</html>