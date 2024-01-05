<?php
session_start();
require("../../../config.php");
require("../../../functions.php");

// connection test==============================================>
if ($dbconn->connect_error) die("Fatal Error");
// ./ Connection test============================================>

// declaring variables
$communitySubsGroupsList = $app_err_msg = $output = null;

if (isset($_SESSION["currentUserAuth"])) {
  if ($_SESSION["currentUserAuth"] == true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn, $_SESSION["currentUserUsername"]);

    echo getUserCommunityGroupSubs();
  }
} else {
  die("Fatal Error: current user not authenticated.");
}

function getUserCommunityGroupSubs()
{
  // declaring variables
  global $dbconn;
  global $currentUser_Usrnm, $communitySubsGroupsList, $app_err_msg, $output;

  $grps_groupid =
    $grps_refcode =
    $grps_name =
    $grps_description =
    $grps_category =
    $grps_privacy =
    $grps_createdby =
    $grps_createdate = null;

  $grps_trainer_name = null;

  try {
    //groups
    $sql = "SELECT cgm.group_mem_id, cgm.group_role, cgm.group_join_date, cgm.groups_group_ref_code,
    grps.*
    FROM community_group_members cgm
    INNER JOIN groups grps ON grps.group_ref_code = cgm.groups_group_ref_code 
    WHERE cgm.users_username = '$currentUser_Usrnm' AND cgm.active = 1 AND grps.group_category = 'indi'";
    // grps.group_id, grps.group_name, grps.group_description, grps.group_category, grps.group_privacy, grps.administrators_username 

    $result = $dbconn->query($sql);
    if (!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");

    // function to get name and surname of user using $grps_createdby
    function getTrainerName($grps_createdby)
    {
      global $dbconn;
      $sql = "SELECT `user_name`, `user_surname` FROM users WHERE username = '$grps_createdby'";
      $result = $dbconn->query($sql);
      if (!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $name = $row["user_name"];
      $surname = $row["user_surname"];
      return $name . " " . $surname;
    }

    $rows = $result->num_rows;

    if ($rows == 0) {
      //there is no result 
      $output = <<<_END
      <div class="p-4 text-center">
        <span class="text-muted fs-5">No groups available.</span>
      </div>
      _END;
    } else {
      for ($j = 0; $j < $rows; ++$j) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        //`group_id`, `group_ref_code`, `group_name`, `group_description`, `group_category`, `group_privacy`, `administrators_username`, `creation_date`

        $grps_groupid = $row["group_id"];
        $grps_refcode = $row["group_ref_code"];
        $grps_name = $row["group_name"];
        $grps_description = $row["group_description"];
        $grps_category = $row["group_category"];
        $grps_privacy = $row["group_privacy"];
        $grps_createdby = $row["administrators_username"];
        $grps_createdate = $row["creation_date"];

        $formatCreateDate = date("d M Y h:i A", strtotime($grps_createdate));

        // assign getTrainerName() to variable
        $grps_trainer_name = getTrainerName($grps_createdby);

        $communitySubsGroupsList .= <<<_END
        <div class="grid-tile p-2 content-panel-border-style mb-4" id="group-card-$grps_groupid-$grps_refcode">
          <div class="row align-items-center px-4">
            <div class="col-md-4 text-center p-0 pt-4 px-2">
              <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid p-2" style="border-radius: 15px; max-width: 50vw !important; filter: invert(0);" alt="prof thumbnail">
            </div>
            <div class="col-md-8 px-0 py-2 align-text-left-md">
              <h3 class="text-truncate fs-5">$grps_name  <span style="font-size: 30px !important" class="material-icons material-icons-round align-middle"> $grps_privacy </span></h3>
              <p class="m-0"><span style="color: var(--primary-color)"> $grps_description </span></p>
              <small class="m-0">$grps_category Training</small>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-md p-4 pt-0 d-grid justify-content-center">
              <button class="onefit-buttons-style-light p-3 shadow" onclick="openGroup('$grps_refcode')"><i class="fas fa-chevron-circle-right" aria-hidden="true"></i> Open group</button>
              <div class="d-flex gap-1 justify-content-center mt-2">
                <span class="material-icons material-icons-round align-middle" style="font-size: 12px !important;color: var(--primary-color)"> perm_identity </span>
                <span class="fw-bold text-right align-middle" style="font-size: 8px;">Trainer: $grps_trainer_name</span>
                <span class="text-right align-middle d-none" style="font-size: 8px;">Created on $formatCreateDate </span>
              </div>
            </div>
          </div>
        </div>
        _END;
      }
      $output = $communitySubsGroupsList;
    }
  } catch (\Throwable $th) {
    //throw $th;
    $output_msg = "System Error:. [get_user_community_subs (user group subs) - " . $th->getMessage() . "]"; //mysqli_error($dbconn)
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

    $output = $app_err_msg;
  }

  return $output;
}
