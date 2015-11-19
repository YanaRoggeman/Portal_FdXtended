<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/hsm/include/initialize.php");
    require($_SERVER['DOCUMENT_ROOT']."/hsm/invoice_execute.php");

/*
 * Page to fill out info for an invoice
 * Variables displayed here are all required
 * but you can also add custom fields, from 1 to 10 -> example: name="custom1"
 */

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
            <h2><?= $arr_portal_lang["invoice"]; ?></h2>
            <p class="error"> <?=$error?> </p>
            <form name="invoiceForm" method="post" onsubmit="this.invoicebtn.disabled = true">
                <fieldset>
                <input type="hidden" name="submitbutton" value="true">
                <label><?= $arr_portal_lang["first_name"]; ?>: </label>
                <input type="text" name="firstname" maxlength="50" value="<?=$firstname?>"> <br/>

                <label><?= $arr_portal_lang["last_name"]; ?>: </label>
                <input type="text" name="lastname" maxlength="50" value="<?=$lastname?>"> <br/>

                <label><?= $arr_portal_lang["e_mail"]; ?>: </label>
                <input type="text" name="mail" maxlength="50" value="<?=$mail?>"> <br/>

                <label><?= $arr_portal_lang["company"]; ?>: </label>
                <input type="text" name="company" maxlength="50" value="<?=$company?>"> <br/>

                <label><?= $arr_portal_lang["address"]; ?>: </label>
                <input type="text" name="address" maxlength="50" value="<?=$address?>"> <br/>

                <label><?= $arr_portal_lang["city"]; ?>: </label>
                <input type="text" name="city" maxlength="50" value="<?=$city?>"> <br/>

                <label><?= $arr_portal_lang["country"]; ?>: </label>
                <select name="country">
                    <option value=""></option>
                    <option value="AF" <?=($country=="AF"?"selected":"")?>>Afghanistan</option>
                    <option value="AL" <?=($country=="AL"?"selected":"")?>>Albania</option>
                    <option value="DZ" <?=($country=="DZ"?"selected":"")?>>Algeria</option>
                    <option value="AS" <?=($country=="AS"?"selected":"")?>>American Samoa</option>
                    <option value="AD" <?=($country=="AD"?"selected":"")?>>Andorra</option>
                    <option value="AO" <?=($country=="AO"?"selected":"")?>>Angola</option>
                    <option value="AI" <?=($country=="AI"?"selected":"")?>>Anguilla</option>
                    <option value="AQ" <?=($country=="AQ"?"selected":"")?>>Antarctica</option>
                    <option value="AG" <?=($country=="AG"?"selected":"")?>>Antigua and Barbuda</option>
                    <option value="AR" <?=($country=="AR"?"selected":"")?>>Argentina</option>
                    <option value="AM" <?=($country=="AM"?"selected":"")?>>Armenia</option>
                    <option value="AW" <?=($country=="AW"?"selected":"")?>>Aruba</option>
                    <option value="AU" <?=($country=="AU"?"selected":"")?>>Australia</option>
                    <option value="AT" <?=($country=="AT"?"selected":"")?>>Austria</option>
                    <option value="AZ" <?=($country=="AZ"?"selected":"")?>>Azerbaijan</option>
                    <option value="BS" <?=($country=="BS"?"selected":"")?>>Bahamas</option>
                    <option value="BH" <?=($country=="BH"?"selected":"")?>>Bahrain</option>
                    <option value="BD" <?=($country=="BD"?"selected":"")?>>Bangladesh</option>
                    <option value="BB" <?=($country=="BB"?"selected":"")?>>Barbados</option>
                    <option value="BY" <?=($country=="BY"?"selected":"")?>>Belarus</option>
                    <option value="BE" <?=($country=="BE"?"selected":"")?>>Belgium</option>
                    <option value="BZ" <?=($country=="BZ"?"selected":"")?>>Belize</option>
                    <option value="BJ" <?=($country=="BJ"?"selected":"")?>>Benin</option>
                    <option value="BM" <?=($country=="BM"?"selected":"")?>>Bermuda</option>
                    <option value="BT" <?=($country=="BT"?"selected":"")?>>Bhutan</option>
                    <option value="BO" <?=($country=="BO"?"selected":"")?>>Bolivia</option>
                    <option value="BA" <?=($country=="BA"?"selected":"")?>>Bosnia and Herzegovina</option>
                    <option value="BW" <?=($country=="BW"?"selected":"")?>>Botswana</option>
                    <option value="BV" <?=($country=="BV"?"selected":"")?>>Bouvet Island</option>
                    <option value="BR" <?=($country=="BR"?"selected":"")?>>Brazil</option>
                    <option value="IO" <?=($country=="IO"?"selected":"")?>>British Indian Ocean Territory</option>
                    <option value="BN" <?=($country=="BN"?"selected":"")?>>Brunei</option>
                    <option value="BG" <?=($country=="BG"?"selected":"")?>>Bulgaria</option>
                    <option value="BF" <?=($country=="BF"?"selected":"")?>>Burkina Faso</option>
                    <option value="BI" <?=($country=="BI"?"selected":"")?>>Burundi</option>
                    <option value="KH" <?=($country=="KH"?"selected":"")?>>Cambodia</option>
                    <option value="CM" <?=($country=="CM"?"selected":"")?>>Cameroon</option>
                    <option value="CA" <?=($country=="CA"?"selected":"")?>>Canada</option>
                    <option value="CV" <?=($country=="CV"?"selected":"")?>>Cape Verde</option>
                    <option value="KY" <?=($country=="KY"?"selected":"")?>>Cayman Islands</option>
                    <option value="CF" <?=($country=="CF"?"selected":"")?>>Central African Republic</option>
                    <option value="TD" <?=($country=="TD"?"selected":"")?>>Chad</option>
                    <option value="CL" <?=($country=="CL"?"selected":"")?>>Chile</option>
                    <option value="CN" <?=($country=="CN"?"selected":"")?>>China</option>
                    <option value="CX" <?=($country=="CX"?"selected":"")?>>Christmas Island</option>
                    <option value="CC" <?=($country=="CC"?"selected":"")?>>Cocos &#40;Keeling&#41; Islands</option>
                    <option value="CO" <?=($country=="CO"?"selected":"")?>>Colombia</option>
                    <option value="KM" <?=($country=="KM"?"selected":"")?>>Comoros</option>
                    <option value="CG" <?=($country=="CG"?"selected":"")?>>Congo</option>
                    <option value="CK" <?=($country=="CK"?"selected":"")?>>Cook Islands</option>
                    <option value="CR" <?=($country=="CR"?"selected":"")?>>Costa Rica</option>
                    <option value="CI" <?=($country=="CI"?"selected":"")?>>Côte d&#39;Ivoire</option>
                    <option value="HR" <?=($country=="HR"?"selected":"")?>>Croatia &#40;Hrvatska&#41;</option>
                    <option value="CU" <?=($country=="CU"?"selected":"")?>>Cuba</option>
                    <option value="CY" <?=($country=="CY"?"selected":"")?>>Cyprus</option>
                    <option value="CZ" <?=($country=="CZ"?"selected":"")?>>Czech Republic</option>
                    <option value="CD" <?=($country=="CD"?"selected":"")?>>Congo &#40;DRC&#41;</option>
                    <option value="DK" <?=($country=="DK"?"selected":"")?>>Denmark</option>
                    <option value="DJ" <?=($country=="DJ"?"selected":"")?>>Djibouti</option>
                    <option value="DM" <?=($country=="DM"?"selected":"")?>>Dominica</option>
                    <option value="DO" <?=($country=="DO"?"selected":"")?>>Dominican Republic</option>
                    <option value="TP" <?=($country=="TP"?"selected":"")?>>East Timor</option>
                    <option value="EC" <?=($country=="EC"?"selected":"")?>>Ecuador</option>
                    <option value="EG" <?=($country=="EG"?"selected":"")?>>Egypt</option>
                    <option value="SV" <?=($country=="SV"?"selected":"")?>>El Salvador</option>
                    <option value="GQ" <?=($country=="GQ"?"selected":"")?>>Equatorial Guinea</option>
                    <option value="ER" <?=($country=="ER"?"selected":"")?>>Eritrea</option>
                    <option value="EE" <?=($country=="EE"?"selected":"")?>>Estonia</option>
                    <option value="ET" <?=($country=="ET"?"selected":"")?>>Ethiopia</option>
                    <option value="FK" <?=($country=="FK"?"selected":"")?>>Falkland Islands &#40;Islas Malvinas&#41;</option>
                    <option value="FO" <?=($country=="FO"?"selected":"")?>>Faroe Islands</option>
                    <option value="FJ" <?=($country=="FJ"?"selected":"")?>>Fiji Islands</option>
                    <option value="FI" <?=($country=="FI"?"selected":"")?>>Finland</option>
                    <option value="FR" <?=($country=="FR"?"selected":"")?>>France</option>
                    <option value="GF" <?=($country=="GF"?"selected":"")?>>French Guiana</option>
                    <option value="PF" <?=($country=="PF"?"selected":"")?>>French Polynesia</option>
                    <option value="TF" <?=($country=="TF"?"selected":"")?>>French Southern and Antarctic Lands</option>
                    <option value="GA" <?=($country=="GA"?"selected":"")?>>Gabon</option>
                    <option value="GM" <?=($country=="GM"?"selected":"")?>>Gambia</option>
                    <option value="GE" <?=($country=="GE"?"selected":"")?>>Georgia</option>
                    <option value="DE" <?=($country=="DE"?"selected":"")?>>Germany</option>
                    <option value="GH" <?=($country=="GH"?"selected":"")?>>Ghana</option>
                    <option value="GI" <?=($country=="GI"?"selected":"")?>>Gibraltar</option>
                    <option value="GR" <?=($country=="GR"?"selected":"")?>>Greece</option>
                    <option value="GL" <?=($country=="GL"?"selected":"")?>>Greenland</option>
                    <option value="GD" <?=($country=="GD"?"selected":"")?>>Grenada</option>
                    <option value="GP" <?=($country=="GP"?"selected":"")?>>Guadeloupe</option>
                    <option value="GU" <?=($country=="GU"?"selected":"")?>>Guam</option>
                    <option value="GT" <?=($country=="GT"?"selected":"")?>>Guatemala</option>
                    <option value="GN" <?=($country=="GN"?"selected":"")?>>Guinea</option>
                    <option value="GW" <?=($country=="GW"?"selected":"")?>>Guinea-Bissau</option>
                    <option value="GY" <?=($country=="GY"?"selected":"")?>>Guyana</option>
                    <option value="HT" <?=($country=="HT"?"selected":"")?>>Haiti</option>
                    <option value="HM" <?=($country=="HM"?"selected":"")?>>Heard Island and McDonald Islands</option>
                    <option value="HN" <?=($country=="HN"?"selected":"")?>>Honduras</option>
                    <option value="HK" <?=($country=="HK"?"selected":"")?>>Hong Kong SAR</option>
                    <option value="HU" <?=($country=="HU"?"selected":"")?>>Hungary</option>
                    <option value="IS" <?=($country=="IS"?"selected":"")?>>Iceland</option>
                    <option value="IN" <?=($country=="IN"?"selected":"")?>>India</option>
                    <option value="ID" <?=($country=="ID"?"selected":"")?>>Indonesia</option>
                    <option value="IR" <?=($country=="IR"?"selected":"")?>>Iran</option>
                    <option value="IQ" <?=($country=="IQ"?"selected":"")?>>Iraq</option>
                    <option value="IE" <?=($country=="IE"?"selected":"")?>>Ireland</option>
                    <option value="IL" <?=($country=="IL"?"selected":"")?>>Israel</option>
                    <option value="IT" <?=($country=="IT"?"selected":"")?>>Italy</option>
                    <option value="JM" <?=($country=="JM"?"selected":"")?>>Jamaica</option>
                    <option value="JP" <?=($country=="JP"?"selected":"")?>>Japan</option>
                    <option value="JO" <?=($country=="JO"?"selected":"")?>>Jordan</option>
                    <option value="KZ" <?=($country=="KZ"?"selected":"")?>>Kazakhstan</option>
                    <option value="KE" <?=($country=="KE"?"selected":"")?>>Kenya</option>
                    <option value="KI" <?=($country=="KI"?"selected":"")?>>Kiribati</option>
                    <option value="KR" <?=($country=="KR"?"selected":"")?>>Korea</option>
                    <option value="KW" <?=($country=="KW"?"selected":"")?>>Kuwait</option>
                    <option value="KG" <?=($country=="KG"?"selected":"")?>>Kyrgyzstan</option>
                    <option value="LA" <?=($country=="LA"?"selected":"")?>>Laos</option>
                    <option value="LV" <?=($country=="LV"?"selected":"")?>>Latvia</option>
                    <option value="LB" <?=($country=="LB"?"selected":"")?>>Lebanon</option>
                    <option value="LS" <?=($country=="LS"?"selected":"")?>>Lesotho</option>
                    <option value="LR" <?=($country=="LR"?"selected":"")?>>Liberia</option>
                    <option value="LY" <?=($country=="LY"?"selected":"")?>>Libya</option>
                    <option value="LI" <?=($country=="LI"?"selected":"")?>>Liechtenstein</option>
                    <option value="LT" <?=($country=="LT"?"selected":"")?>>Lithuania</option>
                    <option value="LU" <?=($country=="LU"?"selected":"")?>>Luxembourg</option>
                    <option value="MO" <?=($country=="MO"?"selected":"")?>>Macao SAR</option>
                    <option value="MK" <?=($country=="MK"?"selected":"")?>>Macedonia, Former Yugoslav Republic of</option>
                    <option value="MG" <?=($country=="MG"?"selected":"")?>>Madagascar</option>
                    <option value="MW" <?=($country=="MW"?"selected":"")?>>Malawi</option>
                    <option value="MY" <?=($country=="MY"?"selected":"")?>>Malaysia</option>
                    <option value="MV" <?=($country=="MV"?"selected":"")?>>Maldives</option>
                    <option value="ML" <?=($country=="ML"?"selected":"")?>>Mali</option>
                    <option value="MT" <?=($country=="MT"?"selected":"")?>>Malta</option>
                    <option value="MH" <?=($country=="MH"?"selected":"")?>>Marshall Islands</option>
                    <option value="MQ" <?=($country=="MQ"?"selected":"")?>>Martinique</option>
                    <option value="MR" <?=($country=="MR"?"selected":"")?>>Mauritania</option>
                    <option value="MU" <?=($country=="MU"?"selected":"")?>>Mauritius</option>
                    <option value="YT" <?=($country=="YT"?"selected":"")?>>Mayotte</option>
                    <option value="MX" <?=($country=="MX"?"selected":"")?>>Mexico</option>
                    <option value="FM" <?=($country=="FM"?"selected":"")?>>Micronesia</option>
                    <option value="MD" <?=($country=="MD"?"selected":"")?>>Moldova</option>
                    <option value="MC" <?=($country=="MC"?"selected":"")?>>Monaco</option>
                    <option value="MN" <?=($country=="MN"?"selected":"")?>>Mongolia</option>
                    <option value="MS" <?=($country=="MS"?"selected":"")?>>Montserrat</option>
                    <option value="MA" <?=($country=="MA"?"selected":"")?>>Morocco</option>
                    <option value="MZ" <?=($country=="MZ"?"selected":"")?>>Mozambique</option>
                    <option value="MM" <?=($country=="MM"?"selected":"")?>>Myanmar</option>
                    <option value="NA" <?=($country=="NA"?"selected":"")?>>Namibia</option>
                    <option value="NR" <?=($country=="NR"?"selected":"")?>>Nauru</option>
                    <option value="NP" <?=($country=="NP"?"selected":"")?>>Nepal</option>
                    <option value="NL" <?=($country=="NL"?"selected":"")?>>Netherlands</option>
                    <option value="AN" <?=($country=="AN"?"selected":"")?>>Netherlands Antilles</option>
                    <option value="NC" <?=($country=="NC"?"selected":"")?>>New Caledonia</option>
                    <option value="NZ" <?=($country=="NZ"?"selected":"")?>>New Zealand</option>
                    <option value="NI" <?=($country=="NI"?"selected":"")?>>Nicaragua</option>
                    <option value="NE" <?=($country=="NE"?"selected":"")?>>Niger</option>
                    <option value="NG" <?=($country=="NG"?"selected":"")?>>Nigeria</option>
                    <option value="NU" <?=($country=="NU"?"selected":"")?>>Niue</option>
                    <option value="NF" <?=($country=="NF"?"selected":"")?>>Norfolk Island</option>
                    <option value="KP" <?=($country=="KP"?"selected":"")?>>North Korea</option>
                    <option value="MP" <?=($country=="MP"?"selected":"")?>>Northern Mariana Islands</option>
                    <option value="NO" <?=($country=="NO"?"selected":"")?>>Norway</option>
                    <option value="OM" <?=($country=="OM"?"selected":"")?>>Oman</option>
                    <option value="PK" <?=($country=="PK"?"selected":"")?>>Pakistan</option>
                    <option value="PW" <?=($country=="PW"?"selected":"")?>>Palau</option>
                    <option value="PA" <?=($country=="PA"?"selected":"")?>>Panama</option>
                    <option value="PG" <?=($country=="PG"?"selected":"")?>>Papua New Guinea</option>
                    <option value="PY" <?=($country=="PY"?"selected":"")?>>Paraguay</option>
                    <option value="PE" <?=($country=="PE"?"selected":"")?>>Peru</option>
                    <option value="PH" <?=($country=="PH"?"selected":"")?>>Philippines</option>
                    <option value="PN" <?=($country=="PN"?"selected":"")?>>Pitcairn Islands</option>
                    <option value="PL" <?=($country=="PL"?"selected":"")?>>Poland</option>
                    <option value="PT" <?=($country=="PT"?"selected":"")?>>Portugal</option>
                    <option value="PR" <?=($country=="PR"?"selected":"")?>>Puerto Rico</option>
                    <option value="QA" <?=($country=="QA"?"selected":"")?>>Qatar</option>
                    <option value="RE" <?=($country=="RE"?"selected":"")?>>Reunion</option>
                    <option value="RO" <?=($country=="RO"?"selected":"")?>>Romania</option>
                    <option value="RU" <?=($country=="RU"?"selected":"")?>>Russia</option>
                    <option value="RW" <?=($country=="RW"?"selected":"")?>>Rwanda</option>
                    <option value="WS" <?=($country=="WS"?"selected":"")?>>Samoa</option>
                    <option value="SM" <?=($country=="SM"?"selected":"")?>>San Marino</option>
                    <option value="ST" <?=($country=="ST"?"selected":"")?>>São Tomé and Príncipe</option>
                    <option value="SA" <?=($country=="SA"?"selected":"")?>>Saudi Arabia</option>
                    <option value="SN" <?=($country=="SN"?"selected":"")?>>Senegal</option>
                    <option value="YU" <?=($country=="YU"?"selected":"")?>>Serbia and Montenegro</option>
                    <option value="SC" <?=($country=="SC"?"selected":"")?>>Seychelles</option>
                    <option value="SL" <?=($country=="SL"?"selected":"")?>>Sierra Leone</option>
                    <option value="SG" <?=($country=="SG"?"selected":"")?>>Singapore</option>
                    <option value="SK" <?=($country=="SK"?"selected":"")?>>Slovakia</option>
                    <option value="SI" <?=($country=="SI"?"selected":"")?>>Slovenia</option>
                    <option value="SB" <?=($country=="SB"?"selected":"")?>>Solomon Islands</option>
                    <option value="SO" <?=($country=="SO"?"selected":"")?>>Somalia</option>
                    <option value="ZA" <?=($country=="ZA"?"selected":"")?>>South Africa</option>
                    <option value="GS" <?=($country=="GS"?"selected":"")?>>South Georgia and the South Sandwich Islands</option>
                    <option value="ES" <?=($country=="ES"?"selected":"")?>>Spain</option>
                    <option value="LK" <?=($country=="LK"?"selected":"")?>>Sri Lanka</option>
                    <option value="SH" <?=($country=="SH"?"selected":"")?>>St. Helena</option>
                    <option value="KN" <?=($country=="KN"?"selected":"")?>>St. Kitts and Nevis</option>
                    <option value="LC" <?=($country=="LC"?"selected":"")?>>St. Lucia</option>
                    <option value="PM" <?=($country=="PM"?"selected":"")?>>St. Pierre and Miquelon</option>
                    <option value="VC" <?=($country=="VC"?"selected":"")?>>St. Vincent and the Grenadines</option>
                    <option value="SD" <?=($country=="SD"?"selected":"")?>>Sudan</option>
                    <option value="SR" <?=($country=="SR"?"selected":"")?>>Suriname</option>
                    <option value="SJ" <?=($country=="SJ"?"selected":"")?>>Svalbard and Jan Mayen</option>
                    <option value="SZ" <?=($country=="SZ"?"selected":"")?>>Swaziland</option>
                    <option value="SE" <?=($country=="SE"?"selected":"")?>>Sweden</option>
                    <option value="CH" <?=($country=="CH"?"selected":"")?>>Switzerland</option>
                    <option value="SY" <?=($country=="SY"?"selected":"")?>>Syria</option>
                    <option value="TW" <?=($country=="TW"?"selected":"")?>>Taiwan</option>
                    <option value="TJ" <?=($country=="TJ"?"selected":"")?>>Tajikistan</option>
                    <option value="TZ" <?=($country=="TZ"?"selected":"")?>>Tanzania</option>
                    <option value="TH" <?=($country=="TH"?"selected":"")?>>Thailand</option>
                    <option value="TG" <?=($country=="TG"?"selected":"")?>>Togo</option>
                    <option value="TK" <?=($country=="TK"?"selected":"")?>>Tokelau</option>
                    <option value="TO" <?=($country=="TO"?"selected":"")?>>Tonga</option>
                    <option value="TT" <?=($country=="TT"?"selected":"")?>>Trinidad and Tobago</option>
                    <option value="TN" <?=($country=="TN"?"selected":"")?>>Tunisia</option>
                    <option value="TR" <?=($country=="TR"?"selected":"")?>>Turkey</option>
                    <option value="TM" <?=($country=="TM"?"selected":"")?>>Turkmenistan</option>
                    <option value="TC" <?=($country=="TC"?"selected":"")?>>Turks and Caicos Islands</option>
                    <option value="TV" <?=($country=="TV"?"selected":"")?>>Tuvalu</option>
                    <option value="UG" <?=($country=="UG"?"selected":"")?>>Uganda</option>
                    <option value="UA" <?=($country=="UA"?"selected":"")?>>Ukraine</option>
                    <option value="AE" <?=($country=="AE"?"selected":"")?>>United Arab Emirates</option>
                    <option value="UK" <?=($country=="UK"?"selected":"")?>>United Kingdom</option>
                    <option value="US" <?=($country=="US"?"selected":"")?>>United States</option>
                    <option value="UM" <?=($country=="UM"?"selected":"")?>>United States Minor Outlying Islands</option>
                    <option value="UY" <?=($country=="UY"?"selected":"")?>>Uruguay</option>
                    <option value="UZ" <?=($country=="UZ"?"selected":"")?>>Uzbekistan</option>
                    <option value="VU" <?=($country=="VU"?"selected":"")?>>Vanuatu</option>
                    <option value="VA" <?=($country=="VA"?"selected":"")?>>Vatican City</option>
                    <option value="VE" <?=($country=="VE"?"selected":"")?>>Venezuela</option>
                    <option value="VN" <?=($country=="VN"?"selected":"")?>>Viet Nam</option>
                    <option value="VG" <?=($country=="VG"?"selected":"")?>>Virgin Islands &#40;British&#41;</option>
                    <option value="VI" <?=($country=="VI"?"selected":"")?>>Virgin Islands</option>
                    <option value="WF" <?=($country=="WF"?"selected":"")?>>Wallis and Futuna</option>
                    <option value="YE" <?=($country=="YE"?"selected":"")?>>Yemen</option>
                    <option value="ZM" <?=($country=="ZM"?"selected":"")?>>Zambia</option>
                    <option value="ZW" <?=($country=="ZW"?"selected":"")?>>Zimbabwe</option>
                </select> <br/>
                <div class="rightColumnDiv">
                    <input name="invoicebtn" type="submit" value="<?= $arr_portal_lang["invoice_button"]; ?>" <?= ($isPortalPreview) ? "disabled":""?>>
                </div>
                </fieldset>
            </form>
        </div>
        <?php include('inc/footer.php'); ?>
    </div>

</body>
</html>