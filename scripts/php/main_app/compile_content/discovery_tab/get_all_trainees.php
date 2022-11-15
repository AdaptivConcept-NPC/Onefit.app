<?php
session_start();
require("../../config.php");

//Connection Test==============================================>
  // Check connection
  /*if ($dbconn->connect_error) {
      die("Connection failed: " . $dbconn->connect_error);
  }
  echo "Connected successfully";*/
  if($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

//Declaring variables
$app_err_msg = "";
$activitiesTraineesList = "";
$discoverPeopleList = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getAllTrainees();
  }
}

function getAllTrainees() {
  //loading: Discover (load max of 50 records)
  //People
  $sql = "SELECT * FROM users u INNER JOIN user_profiles up ON u.username = up.username;";

  if($result = mysqli_query($dbconn,$sql)){
    
    while($row = mysqli_fetch_assoc($result)){
      
      $usrs_userid = $row["user_id"];

      $usrs_username = $row["username"];
      $usrs_name = $row["user_name"];
      $usrs_surname = $row["user_surname"];
      $usrs_idnumber = $row["id_number"];
      $usrs_email = $row["user_email"];
      $usrs_contact = $row["contact_number"];
      $usrs_dob = $row["date_of_birth"];
      $usrs_gender = $row["user_gender"];
      $usrs_race = $row["user_race"];
      $usrs_nationality = $row["user_nationality"];
      $usrs_acc_active = $row["account_active"];

      $usrs_prof_acctype = $row["profile_type"];

      /*$discoverPeopleList .= '
      <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-'.$usrs_userid.'-'.$usrs_username.'">
        <div class="card bg-transparent align-items-center">
          <div class="text-center">
            <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
          </div>
          <div class="card-body">
            <h3>'.$usrs_name.' '.$usrs_surname.'</h3>
            <p>@<span style="color: #ffa500">'.$usrs_username.'</span></p>
            <div class="text-center">
              <button class="null-btn m-4 shadow" onclick="openProfiler('."'".$usrs_username."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
            </div>
          </div>
        </div>
      </div>';*/

      //compile list of trainers
      if($usrs_prof_acctype == "trainee") {
        $activitiesTraineesList .= '
        <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-'.$usrs_userid.'-'.$usrs_username.'">
          <div class="card bg-transparent align-items-center">
            <div class="text-center">
              <img src="../media/assets/One-Symbol-Logo-White.png" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
            </div>
            <div class="card-body">
              <h3>'.$usrs_name.' '.$usrs_surname.'</h3>
              <p>@<span style="color: #ffa500">'.$usrs_username.'</span></p>
              <div class="text-center">
                <button class="null-btn m-4 shadow" onclick="openProfiler('."'".$usrs_username."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
              </div>
            </div>
          </div>
        </div>';
      }
    }
    //echo $discoverPeopleList;
    //die();

    $output = $activitiesTraineesList;
  }else{
    $output_msg = "|[System Error]|:. [Discover load (All People) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }
  
  return $output;
}
?>