<?php
session_start();
include("../../scripts/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //locally assign values to variables
  $reg_name = mysqli_real_escape_string($db, $_POST['reg-name']);
  $reg_surname = mysqli_real_escape_string($db, $_POST['reg-surname']);
  $reg_email = mysqli_real_escape_string($db, $_POST['reg-email']);
  $reg_contact = mysqli_real_escape_string($db, $_POST['reg-contact']);
  $reg_idnum = mysqli_real_escape_string($db, $_POST['reg-idnum']);
  $reg_dob_str = mysqli_real_escape_string($db, $_POST['reg-dob']);
  $reg_dob = date_create($reg_dob_str);
  $reg_dob = date_format($reg_dob, "Y-m-d"); //date_format($date,"Y/m/d H:i:s");
  $reg_gender = mysqli_real_escape_string($db, $_POST['reg-gender']);
  $reg_race = mysqli_real_escape_string($db, $_POST['reg-race']);
  $reg_nationality = mysqli_real_escape_string($db, $_POST['reg-nationality']);
  $reg_username = mysqli_real_escape_string($db, $_POST['reg-username']);
  $reg_password = mysqli_real_escape_string($db, $_POST['reg-confirmpassword']);

  //profile details - default
  $usr_about = "Tell us about yourself";
  $usr_profiletype = "general";
  $usr_profilepicurl = "default";
  $usr_verification = "unverif";

  $sql = "INSERT INTO `users`
        (`username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`) 
        VALUES 
        ('$reg_username','$reg_password','$reg_name','$reg_surname','$reg_idnum','$reg_email','$reg_contact','$reg_dob','$reg_gender','$reg_race','$reg_nationality', 0)";

  if (mysqli_query($db, $sql)) {
    //save profile details
    $sql2 = "INSERT INTO `user_profiles`
            (`username`, `about`, `profile_type`, `profile_url`, `verification`) 
            VALUES ('$reg_username','$usr_about','$usr_profiletype','$usr_profilepicurl','$usr_verification')";
    if (mysqli_query($db, $sql2)) {
      //create the users dedicated account folder
      if (mkdir("../media/profiles/$reg_username")) {
        //redirect user to reg-status page
        header("Location: ./reg-status.html?status=success&pfld_create=true");
      } else {
        //redirect user to reg-status page
        header("Location: ./reg-status.html?status=success&pfld_create=false");
      }

      die();
    } else {
      $output .= "|[System Error]|:. [Client Reg - " . mysqli_error($db) . "]";
      echo $output;
    }
  } else {
    $output = "|[System Error]|:. [Client Reg - " . mysqli_error($db) . "]";
    echo $output;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
  <!--fontawesome-->
  <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

  <link rel="stylesheet" href="../styles_depracated.css" />

  <title>Client Registration | onefit&trade; &copy; 2021 AdaptivConcept</title>
</head>

<body class="fitness-bg">
  <!--navigation modal-->
  <!-- Modal -->
  <div class="modal fade" id="navigationModal" tabindex="-1" aria-labelledby="navigationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content content-panel-border-style fitness-bg" style="border-radius: 25px !important;">
        <div class="modal-header border-0">
          <h5 class="modal-title text-center" id="navigationModalLabel" style="color: #ffa500">Navigation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body pt-0">
          <hr class="m-0 bg-white">

          <ul class="list-group">
            <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-home" style="cursor: pointer">Home</li>
            <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-about" style="cursor: pointer">About Us</li>
            <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-services" style="cursor: pointer">Services and Programs</li>
            <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-contact" style="cursor: pointer">Contact Us</li>
            <li class="list-group-item bg-transparent border-0 navigation-item" id="nav-to-forgotpwd" style="cursor: pointer">Forgot password?</li>
          </ul>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="onefit-buttons-style p-4" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center fixed-bottom p-4" style="background: #ffa500; color: #333" hidden>
    <p>Crafted by Adaptiv Concept (Media) &copy; 2021</p>
  </div>
  <nav class="navbar text-white sticky-top m-0" style="background: #333">
    <a class="navbar-brand align-items-center" href="../../index.html">
      <img src="../../media/assets/One-Symbol-Logo-Two-Tone.svg" class="d-inline-block align-top" alt="onefit logo" style="height: 50px; width: auto" />
    </a>
    <h1 class="light-h-text">one<span style="color: #ffa500 !important">fit</span><span style="font-size: 10px">&trade;</span></h1>
    <button class="menu-toggle" type="button" data-toggle="modal" data-target="#navigationModal">
      <i class="fas fa-fingerprint m-4"></i>
    </button>
  </nav>

  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-xl py-4">
        <div class="content-panel-border-style p-4 tunnel-bg text-center" style="border-radius: 25px">
          <img src="../../media/assets/One-Logo-Vertical.svg" class="img-fluid my-4" alt="one fitness" style="max-height: 50vh" />
          <p class="my-4 text-center" style="color: #fff; font-size: 10px">Crafted by Adaptiv Concept (Media) &copy; 2021</p>
        </div>
      </div>
      <div class="col-xl py-4 text-center" style="max-height: 90vh; overflow-y: auto; overflow-x: hidden">
        <div class="content-panel-border-style registration-form tunnel-bg mb-4 shadow" style="width: 100%">
          <h2 class="text-center pt-4" style="color: #ffa500"><i class="fas fa-file-signature"></i> Sign up for an account, it's free</h2>
          <hr class="mx-4 bg-white" />

          <form class="text-center px-4 pb-4 pt-0" method="post">
            <div class="output-container my-2" id="output-container" <?php if ($output != "") {
                                                                        echo `style="display: block"`;
                                                                      } ?>><?php echo $output; ?></div>

            <div class="form-group my-4">
              <input type="text" name="reg-name" id="reg-name" placeholder="Name" required />
            </div>

            <div class="form-group">
              <input type="text" name="reg-surname" id="reg-surname" placeholder="Surname" required />
            </div>
            <div class="form-group my-4">
              <input type="email" name="reg-email" id="reg-email" placeholder="Email address" required />
            </div>

            <div class="form-group">
              <input type="phone" name="reg-contact" id="reg-contact" placeholder="Phone number" required />
            </div>
            <div class="form-group my-4">
              <input type="text" name="reg-idnum" id="reg-idnum" placeholder="ID/Passport number" required />
            </div>

            <div class="form-group">
              <input type="date" name="reg-dob" id="reg-dob" placeholder="Date of birth" required />
            </div>
            <div class="form-group my-4">
              <select class="custom-select" name="reg-gender" id="reg-gender" placeholder="Gender" required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
              </select>
            </div>

            <div class="form-group">
              <select class="custom-select" name="reg-race" id="reg-race" placeholder="Race" required>
                <option value="black">Black/African</option>
                <option value="white">White/Caucasian</option>
                <option value="coloured">Coloured/Mixed Race</option>
                <option value="asian">Asian</option>
              </select>
            </div>
            <div class="form-group my-4">
              <select class="custom-select" name="reg-nationality" id="reg-nationality" placeholder="Nationality" required>
                <option value='South Africa'>South Africa</option>
                <option value='Afghanistan'>Afghanistan</option>
                <option value='Akrotiri'>Akrotiri</option>
                <option value='Albania'>Albania</option>
                <option value='Algeria'>Algeria</option>
                <option value='American Samoa'>American Samoa</option>
                <option value='Andorra'>Andorra</option>
                <option value='Angola'>Angola</option>
                <option value='Anguilla'>Anguilla</option>
                <option value='Antarctica'>Antarctica</option>
                <option value='Antigua and Barbuda'>Antigua and Barbuda</option>
                <option value='Argentina'>Argentina</option>
                <option value='Armenia'>Armenia</option>
                <option value='Aruba'>Aruba</option>
                <option value='Ashmore and Cartier Islands'>Ashmore and Cartier Islands</option>
                <option value='Australia'>Australia</option>
                <option value='Austria'>Austria</option>
                <option value='Azerbaijan'>Azerbaijan</option>
                <option value='Bahamas, The'>Bahamas, The</option>
                <option value='Bahrain'>Bahrain</option>
                <option value='Bangladesh'>Bangladesh</option>
                <option value='Barbados'>Barbados</option>
                <option value='Bassas da India'>Bassas da India</option>
                <option value='Belarus'>Belarus</option>
                <option value='Belgium'>Belgium</option>
                <option value='Belize'>Belize</option>
                <option value='Benin'>Benin</option>
                <option value='Bermuda'>Bermuda</option>
                <option value='Bhutan'>Bhutan</option>
                <option value='Bolivia'>Bolivia</option>
                <option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option>
                <option value='Botswana'>Botswana</option>
                <option value='Bouvet Island'>Bouvet Island</option>
                <option value='Brazil'>Brazil</option>
                <option value='British Indian Ocean Territory'>British Indian Ocean Territory</option>
                <option value='British Virgin Islands'>British Virgin Islands</option>
                <option value='Brunei'>Brunei</option>
                <option value='Bulgaria'>Bulgaria</option>
                <option value='Burkina Faso'>Burkina Faso</option>
                <option value='Burma'>Burma</option>
                <option value='Burundi'>Burundi</option>
                <option value='Cambodia'>Cambodia</option>
                <option value='Cameroon'>Cameroon</option>
                <option value='Canada'>Canada</option>
                <option value='Cape Verde'>Cape Verde</option>
                <option value='Cayman Islands'>Cayman Islands</option>
                <option value='Central African Republic'>Central African Republic</option>
                <option value='Chad'>Chad</option>
                <option value='Chile'>Chile</option>
                <option value='China'>China</option>
                <option value='Christmas Island'>Christmas Island</option>
                <option value='Clipperton Island'>Clipperton Island</option>
                <option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option>
                <option value='Colombia'>Colombia</option>
                <option value='Comoros'>Comoros</option>
                <option value='Congo, Democratic Republic of the'>Congo, Democratic Republic of the</option>
                <option value='Congo, Republic of the'>Congo, Republic of the</option>
                <option value='Cook Islands'>Cook Islands</option>
                <option value='Coral Sea Islands'>Coral Sea Islands</option>
                <option value='Costa Rica'>Costa Rica</option>
                <option value='Cote d' Ivoire'>Cote d'Ivoire</option>
                <option value='Croatia'>Croatia</option>
                <option value='Cuba'>Cuba</option>
                <option value='Cyprus'>Cyprus</option>
                <option value='Czech Republic'>Czech Republic</option>
                <option value='Denmark'>Denmark</option>
                <option value='Dhekelia'>Dhekelia</option>
                <option value='Djibouti'>Djibouti</option>
                <option value='Dominica'>Dominica</option>
                <option value='Dominican Republic'>Dominican Republic</option>
                <option value='Ecuador'>Ecuador</option>
                <option value='Egypt'>Egypt</option>
                <option value='El Salvador'>El Salvador</option>
                <option value='Equatorial Guinea'>Equatorial Guinea</option>
                <option value='Eritrea'>Eritrea</option>
                <option value='Estonia'>Estonia</option>
                <option value='Ethiopia'>Ethiopia</option>
                <option value='Europa Island'>Europa Island</option>
                <option value='Falkland Islands (Islas Malvinas)'>Falkland Islands (Islas Malvinas)</option>
                <option value='Faroe Islands'>Faroe Islands</option>
                <option value='Fiji'>Fiji</option>
                <option value='Finland'>Finland</option>
                <option value='France'>France</option>
                <option value='French Guiana'>French Guiana</option>
                <option value='French Polynesia'>French Polynesia</option>
                <option value='French Southern and Antarctic Lands'>French Southern and Antarctic Lands</option>
                <option value='Gabon'>Gabon</option>
                <option value='Gambia, The'>Gambia, The</option>
                <option value='Gaza Strip'>Gaza Strip</option>
                <option value='Georgia'>Georgia</option>
                <option value='Germany'>Germany</option>
                <option value='Ghana'>Ghana</option>
                <option value='Gibraltar'>Gibraltar</option>
                <option value='Glorioso Islands'>Glorioso Islands</option>
                <option value='Greece'>Greece</option>
                <option value='Greenland'>Greenland</option>
                <option value='Grenada'>Grenada</option>
                <option value='Guadeloupe'>Guadeloupe</option>
                <option value='Guam'>Guam</option>
                <option value='Guatemala'>Guatemala</option>
                <option value='Guernsey'>Guernsey</option>
                <option value='Guinea'>Guinea</option>
                <option value='Guinea-Bissau'>Guinea-Bissau</option>
                <option value='Guyana'>Guyana</option>
                <option value='Haiti'>Haiti</option>
                <option value='Heard Island and McDonald Islands'>Heard Island and McDonald Islands</option>
                <option value='Holy See (Vatican City)'>Holy See (Vatican City)</option>
                <option value='Honduras'>Honduras</option>
                <option value='Hong Kong'>Hong Kong</option>
                <option value='Hungary'>Hungary</option>
                <option value='Iceland'>Iceland</option>
                <option value='India'>India</option>
                <option value='Indonesia'>Indonesia</option>
                <option value='Iran'>Iran</option>
                <option value='Iraq'>Iraq</option>
                <option value='Ireland'>Ireland</option>
                <option value='Isle of Man'>Isle of Man</option>
                <option value='Israel'>Israel</option>
                <option value='Italy'>Italy</option>
                <option value='Jamaica'>Jamaica</option>
                <option value='Jan Mayen'>Jan Mayen</option>
                <option value='Japan'>Japan</option>
                <option value='Jersey'>Jersey</option>
                <option value='Jordan'>Jordan</option>
                <option value='Juan de Nova Island'>Juan de Nova Island</option>
                <option value='Kazakhstan'>Kazakhstan</option>
                <option value='Kenya'>Kenya</option>
                <option value='Kiribati'>Kiribati</option>
                <option value='Korea, North'>Korea, North</option>
                <option value='Korea, South'>Korea, South</option>
                <option value='Kuwait'>Kuwait</option>
                <option value='Kyrgyzstan'>Kyrgyzstan</option>
                <option value='Laos'>Laos</option>
                <option value='Latvia'>Latvia</option>
                <option value='Lebanon'>Lebanon</option>
                <option value='Lesotho'>Lesotho</option>
                <option value='Liberia'>Liberia</option>
                <option value='Libya'>Libya</option>
                <option value='Liechtenstein'>Liechtenstein</option>
                <option value='Lithuania'>Lithuania</option>
                <option value='Luxembourg'>Luxembourg</option>
                <option value='Macau'>Macau</option>
                <option value='Macedonia'>Macedonia</option>
                <option value='Madagascar'>Madagascar</option>
                <option value='Malawi'>Malawi</option>
                <option value='Malaysia'>Malaysia</option>
                <option value='Maldives'>Maldives</option>
                <option value='Mali'>Mali</option>
                <option value='Malta'>Malta</option>
                <option value='Marshall Islands'>Marshall Islands</option>
                <option value='Martinique'>Martinique</option>
                <option value='Mauritania'>Mauritania</option>
                <option value='Mauritius'>Mauritius</option>
                <option value='Mayotte'>Mayotte</option>
                <option value='Mexico'>Mexico</option>
                <option value='Micronesia, Federated States of'>Micronesia, Federated States of</option>
                <option value='Moldova'>Moldova</option>
                <option value='Monaco'>Monaco</option>
                <option value='Mongolia'>Mongolia</option>
                <option value='Montserrat'>Montserrat</option>
                <option value='Morocco'>Morocco</option>
                <option value='Mozambique'>Mozambique</option>
                <option value='Namibia'>Namibia</option>
                <option value='Nauru'>Nauru</option>
                <option value='Navassa Island'>Navassa Island</option>
                <option value='Nepal'>Nepal</option>
                <option value='Netherlands'>Netherlands</option>
                <option value='Netherlands Antilles'>Netherlands Antilles</option>
                <option value='New Caledonia'>New Caledonia</option>
                <option value='New Zealand'>New Zealand</option>
                <option value='Nicaragua'>Nicaragua</option>
                <option value='Niger'>Niger</option>
                <option value='Nigeria'>Nigeria</option>
                <option value='Niue'>Niue</option>
                <option value='Norfolk Island'>Norfolk Island</option>
                <option value='Northern Mariana Islands'>Northern Mariana Islands</option>
                <option value='Norway'>Norway</option>
                <option value='Oman'>Oman</option>
                <option value='Pakistan'>Pakistan</option>
                <option value='Palau'>Palau</option>
                <option value='Panama'>Panama</option>
                <option value='Papua New Guinea'>Papua New Guinea</option>
                <option value='Paracel Islands'>Paracel Islands</option>
                <option value='Paraguay'>Paraguay</option>
                <option value='Peru'>Peru</option>
                <option value='Philippines'>Philippines</option>
                <option value='Pitcairn Islands'>Pitcairn Islands</option>
                <option value='Poland'>Poland</option>
                <option value='Portugal'>Portugal</option>
                <option value='Puerto Rico'>Puerto Rico</option>
                <option value='Qatar'>Qatar</option>
                <option value='Reunion'>Reunion</option>
                <option value='Romania'>Romania</option>
                <option value='Russia'>Russia</option>
                <option value='Rwanda'>Rwanda</option>
                <option value='Saint Helena'>Saint Helena</option>
                <option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option>
                <option value='Saint Lucia'>Saint Lucia</option>
                <option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option>
                <option value='Saint Vincent and the Grenadines'>Saint Vincent and the Grenadines</option>
                <option value='Samoa'>Samoa</option>
                <option value='San Marino'>San Marino</option>
                <option value='Sao Tome and Principe'>Sao Tome and Principe</option>
                <option value='Saudi Arabia'>Saudi Arabia</option>
                <option value='Senegal'>Senegal</option>
                <option value='Serbia and Montenegro'>Serbia and Montenegro</option>
                <option value='Seychelles'>Seychelles</option>
                <option value='Sierra Leone'>Sierra Leone</option>
                <option value='Singapore'>Singapore</option>
                <option value='Slovakia'>Slovakia</option>
                <option value='Slovenia'>Slovenia</option>
                <option value='Solomon Islands'>Solomon Islands</option>
                <option value='Somalia'>Somalia</option>
                <option value='South Georgia and the South Sandwich Islands'>South Georgia and the South Sandwich Islands</option>
                <option value='Spain'>Spain</option>
                <option value='Spratly Islands'>Spratly Islands</option>
                <option value='Sri Lanka'>Sri Lanka</option>
                <option value='Sudan'>Sudan</option>
                <option value='Suriname'>Suriname</option>
                <option value='Svalbard'>Svalbard</option>
                <option value='Swaziland'>Swaziland</option>
                <option value='Sweden'>Sweden</option>
                <option value='Switzerland'>Switzerland</option>
                <option value='Syria'>Syria</option>
                <option value='Taiwan'>Taiwan</option>
                <option value='Tajikistan'>Tajikistan</option>
                <option value='Tanzania'>Tanzania</option>
                <option value='Thailand'>Thailand</option>
                <option value='Timor-Leste'>Timor-Leste</option>
                <option value='Togo'>Togo</option>
                <option value='Tokelau'>Tokelau</option>
                <option value='Tonga'>Tonga</option>
                <option value='Trinidad and Tobago'>Trinidad and Tobago</option>
                <option value='Tromelin Island'>Tromelin Island</option>
                <option value='Tunisia'>Tunisia</option>
                <option value='Turkey'>Turkey</option>
                <option value='Turkmenistan'>Turkmenistan</option>
                <option value='Turks and Caicos Islands'>Turks and Caicos Islands</option>
                <option value='Tuvalu'>Tuvalu</option>
                <option value='Uganda'>Uganda</option>
                <option value='Ukraine'>Ukraine</option>
                <option value='United Arab Emirates'>United Arab Emirates</option>
                <option value='United Kingdom'>United Kingdom</option>
                <option value='United States'>United States</option>
                <option value='Uruguay'>Uruguay</option>
                <option value='Uzbekistan'>Uzbekistan</option>
                <option value='Vanuatu'>Vanuatu</option>
                <option value='Venezuela'>Venezuela</option>
                <option value='Vietnam'>Vietnam</option>
                <option value='Virgin Islands'>Virgin Islands</option>
                <option value='Wake Island'>Wake Island</option>
                <option value='Wallis and Futuna'>Wallis and Futuna</option>
                <option value='West Bank'>West Bank</option>
                <option value='Western Sahara'>Western Sahara</option>
                <option value='Yemen'>Yemen</option>
                <option value='Zambia'>Zambia</option>
                <option value='Zimbabwe'>Zimbabwe</option>
              </select>
            </div>

            <div class="form-group">
              <input type="text" name="reg-username" id="reg-username" placeholder="Username" required />
            </div>
            <div class="form-group my-4">
              <input type="password" name="reg-password" id="reg-password" placeholder="Password" required />
            </div>

            <div class="form-group">
              <input type="password" name="reg-confirmpassword" id="reg-confirmpassword" placeholder="Confirm password" required />
            </div>
            <div class="text-center">
              <button type="submit" class="mb-4" id="signup-btn"><i class="fas fa-sign-in-alt" style="color: #ffa500"></i> Sign Up</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <script>
    var signinbtn = document.getElementById("signup-btn");
    //signupbtn.addEventListener("click", signin);

    document.getElementById("output-container").addEventListener("click", function() {
      document.getElementById("output-container").style.display = "none";
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>

</html>