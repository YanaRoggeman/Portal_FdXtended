<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT'] . "/hsm/creditcard_execute.php");

// Testing variable, are we in preview mode?
   $isPortalPreview = isset($_SESSION['PORTAL']['preview']);

$outputMonths = "";
for($i = 1; $i <= 12; $i++){
    $number = (strlen($i) == 1 ? "0".$i : $i);
    $selected = ($edm == $number ? "selected" : "");
    $outputMonths .= "<option value='".$number."' $selected>$number</option>";
}

// Change these values to change te range of Years
   $startYear = 2015;
   $endYear = 2032;

$outputYears = "";
for($i = $startYear; $i <= $endYear; $i++){
    $nr = substr($i,2,2);
    $selected = ($edy==$nr?'selected':'');
    $outputYears .= "<option value='".$nr."' $selected >$i</option>";
}

($edy=='".substr($i,2,2)."'?'selected':'')
?>
<html>
<head>
    <?php include("inc/header.php"); ?>
</head>
<body>
<div id="container">
    <div id="content">
        <h2><?= $arr_portal_lang["title_creditcard_details"]; ?></h2>
        <p id="error"><?=$error?></p>
        <form method="post" action="creditcard.php<?=$sessionurl2?>" onsubmit="this.submitbutton.disabled=true">
           <fieldset>
            <input type="hidden" name="submit_form" value="true">

            <label><?= $arr_portal_lang["price"]; ?>: </label>
            <input type="text" disabled value="<?=$price?>" name="price">
            <br/>
            <label><?= $arr_portal_lang["description"]; ?>: </label>
            <input type="text" disabled value="<?=$description?>" name="desc">
            <br/>
            <label><?= $arr_portal_lang["card_number"]; ?>: </label>
            <input type="text"  value="<?=$cardno?>" name="cardno">
            <br/>
            <label><?= $arr_portal_lang["expiry_date"]; ?><span class="italic">(mm/yyyy)</span>: </label>
               <div class="rightColumnDiv">
            <select name="edm" class="selectDate">
                <?=$outputMonths?>
            </select> /
            <select name="edy" class="selectDate">
                <?=$outputYears?>
            </select>
               </div>
            <br/>

            <label><?= $arr_portal_lang["card_holder_name"]; ?>:</label>
            <input type="text" name="cn" value="<?= $cn ?>" > <br/>

            <label><?= $arr_portal_lang["cvc_code"]; ?>: </label>
            <input type="text" name="cvc" value="<?=$cvc ?>">

           <div class="rightColumnDiv">
            <input name="submitbutton" type="submit" <?=($isPortalPreview ? "disabled" : "")?> value="Submit">
           </div>
           </fieldset>
        </form>
    </div>
    <?php include('inc/footer.php'); ?>
</div>
</body>
</html>