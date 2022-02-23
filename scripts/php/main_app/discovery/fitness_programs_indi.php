
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
$discoverProgramsList = "";
$output = "";

if(isset($_SESSION["currentUserAuth"])) {
  if($_SESSION["currentUserAuth"]==true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn,$_SESSION["currentUserAuth"]);

    echo getFitProgramsIndi();
  }
}

function getFitProgramsIndi() {
  //Programs
  //$sql = "SELECT * FROM training_programs tp INNER JOIN program_activities pa ON tp.program_ref_code = pa.program_ref_code;";
  $sql = "SELECT * FROM training_programs;";

  if($result = mysqli_query($dbconn,$sql)){
    while($row = mysqli_fetch_assoc($result)){
      //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `created_by`, `creation_date`, `active` 
      //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
      $programs_progid = $row["program_id"];
      $programs_refcode = $row["program_ref_code"];
      $programs_title = $row["program_title"];
      $programs_description = $row["program_description"];
      $programs_duration = $row["program_duration"];
      $programs_category = $row["program_category"];
      $programs_privacy = $row["program_privacy"];
      $programs_creator = $row["created_by"];
      $programs_active = $row["active"];

      /*$programs_activityid = $row["prog_activity_id"];
      $programs_activitytitle = $row["activity_title"];
      $programs_activityduration = $row["activity_duration"];*/

      $discoverProgramsList .= '
      <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-'.$programs_progid.'-'.$programs_refcode.'">
        <div class="card bg-transparent">
          <div class="card-body">
            <h3 class="card-title">'.$programs_title.' <span style="font-size: 10px">('.$programs_privacy.')</span></h3>
            <p class="card-subtitle ">Trainer: @'.$programs_creator.'</p>
            <p class="card-text">'.$programs_description.'</p>
            <div class="text-center">
              <button class="null-btn m-4 shadow" onclick="openProgram('."'".$programs_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> View program</button>
            </div>
          </div>
        </div>
      </div>';
    }

    $output = $discoverProgramsList;
  }else{
    $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
    //exit();

    $output = $app_err_msg;
  }
  
  return $output;
}
?>