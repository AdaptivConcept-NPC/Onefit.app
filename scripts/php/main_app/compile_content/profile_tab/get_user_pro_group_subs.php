<?php
session_start();
require("../../../config.php");
require("../../../functions.php");

// connection test ==============================================>
if ($dbconn->connect_error) die("Fatal Error");
// ./ Connection test ============================================>

// declaring variables
$proGroupsList = $app_err_msg = $output = null;

if (isset($_SESSION["currentUserAuth"])) {
  if ($_SESSION["currentUserAuth"] == true) {
    $currentUser_Usrnm = mysqli_real_escape_string($dbconn, $_SESSION["currentUserUsername"]);

    echo getUserProGroupSubs();
  }
} else {
  die("Fatal Error: current user not authenticated.");
}

function getUserProGroupSubs()
{
  // declaring variables
  global $dbconn;
  global $currentUser_Usrnm, $proGroupsList, $app_err_msg, $output;

  try {
    //groups
    $sql = "SELECT pgm.group_mem_id, pgm.group_role, pgm.group_join_date, pgm.groups_group_ref_code,
    grps.* 
    FROM premium_group_members pgm
    INNER JOIN groups grps ON grps.group_ref_code = pgm.groups_group_ref_code 
    WHERE pgm.users_username = '$currentUser_Usrnm' AND pgm.active = 1 AND grps.group_category = 'pro'";
    // grps.group_id, grps.group_name, grps.group_description, grps.group_category, grps.group_privacy, grps.administrators_username 

    $result = $dbconn->query($sql);
    if (!$result) die("A Fatal Error has occured. Please try again and if the problem persists, please contact the system administrator.");

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

        $proGroupsList .= <<<_END
          <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="group-card-$grps_groupid-$grps_refcode">
            <div class="row align-items-center">
              <div class="col-md -4 text-center">
                <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
              </div>
              <div class="col-md -8">
                <h3>$grps_name<span style="font-size: 10px">$grps_privacy</span></h3>
                <p><span style="color: #ffa500">$grps_description</span></p>
                <p>$grps_category</p>
                <button class="onefit-buttons-style-light shadow mt-4" onclick="openGroup('$grps_refcode')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
                <p class="text-right" style="font-size: 8px">$grps_createdby</p>
                <p class="text-right" style="font-size: 8px">$grps_createdate</p>
              </div>
            </div>
          </div>
          _END;
      }
      $output = $proGroupsList;
    }
  } catch (\Throwable $th) {
    //throw $th;
    $output_msg = "|[System Error]|:. [get_user_community_subs (user group subs) - " . $th->getMessage() . "]"; //mysqli_error($dbconn)
    $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

    $output = $app_err_msg;
  }

  return $output;
}
