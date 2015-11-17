<?php
require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
require($_SERVER['DOCUMENT_ROOT']."/hsm/login_execute.php");

/*Loop through each enabled registration form and print its fields
* These forms are created at Layout > Registration forms
* To enable them for this portal page > Edit the portal page > Registration form
*/

// Get the amount of enabled forms
   $totalForms = count($register_forms);

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

        <h2><?= $arr_portal_lang["title_register"]; ?></h2>

        <p class="error"> <!-- Can also be a message on success -->
            <?php
            if(is_array($error))
                print_r($error);
            else
                echo $error;
            ?>
        </p>
            <?php
            for($i = 1; $i <= $totalForms; ++$i){
                ?>
                <form name="registerForm" method="post">
                    <input type="hidden" name="id" value="<?= $i ?>">
                    <fieldset>
                        <?php
                        foreach($register_forms[$i]->fields as $field=>$config)
                        {
                            if($config->show==1)
                            {
                                ?>
                                <label for="<?=$field?>"><?=$arr_portal_lang[strtolower($field)]?><?=$config->validate>0 ? "*" : " "; ?>:</label>
                                <input id="<?=$field?>" name="<?=$field?>" <?=$config->html5==1 && $config->validate==2?"pattern='".$config->regex."'":""?><?=$config->html5==1 && $config->validate>0?"required":""?> type="<?=$config->input_type?>" value="<?=$_POST[$field]?>" placeholder="<?=$config->placeholder?>"/>
                                <br/>
                            <?php
                            }
                        }
                        ?>
                        <div class="rightColumnDiv">
                            <input type="submit" value="<?= $arr_portal_lang["register_button"]; ?>" name="register"  <?=($isPortalPreview ? "disabled":"")?>>
                        </div>
                    </fieldset>
                </form>
            <?php
            }
            ?>
    </div>
    <?php include('inc/footer.php'); ?>
</div>
</body>
</html>