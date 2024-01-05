<?php
require("../../../config.php");
require("../../../functions.php");

//Connection Test==============================================>
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

$currentUser_Usrnm = $groupsList = $app_err_msg = $output = null;
$grps_groupid =
    $grps_refcode =
    $grps_name =
    $grps_description =
    $grps_category =
    $grps_privacy =
    $grps_createdby =
    $grps_createdate = null;

try {
    //groups
    $sql = "SELECT * FROM groups WHERE group_category = 'pro' ORDER BY group_id DESC";

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

            $groupsList .= <<<_END
            <li id="group-item-$grps_groupid-$grps_refcode" class="list-group-item list-group-item-action d-flex gap-4 justify-content-between align-items-center left-right-grad-white-mineshaft" style="border-radius:25px;">
                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid shadow" style="border-radius:15px;height:100px;" alt="group image." />
                <div class="ms-2 me-auto d-grid">
                    <div class="fs-5 fw-bold mb-4">$grps_name.</div>
                    <span>$grps_description</span>
                    <span>$grps_createdby</span>
                </div>
                <div class="d-grid gap-2">
                    <span class="badge rounded-pill fw-bold" style="background-color: var(--secondary-color)!important;">
                        <span class="material-icons material-icons-round align-middle" style="font-size:12px!important;">
                            notifications_active
                        </span> ?
                        <span class="visually-hidden">Activities</span>
                    </span>
                    <button class="onefit-buttons-style-dark p-4" type="button" onclick="viewGroup('$grps_refcode','pro')">
                        <span class="material-icons material-icons-round align-middle" style="color: #fff;">arrow_forward_ios</span>
                    </button>
                </div>
            </li>
            _END;
        }

        $output = <<<_END
        <!-- PRO groups container -->
        <div class="row" style="min-height: 50vh;max-height:100vh;">
            <div class="col-md-4 light-scroller" style="max-height:100vh;overflow-y:auto;">
                <!-- group selection list -->
                <ul class="list-group list-group-flush">
                    $groupsList
                </ul>
                <!-- ./ group selection list -->
            </div>
            <div class="col-md-8 light-scroller" style="max-height:100vh;overflow-y:auto;">
                <!-- group preview container -->
                <div class="h-100 w-100 d-grid align-items-center justify-content-center">
                    <h5 class="text-center d-grid gap-2">
                        <span class="material-icons material-icons-outlined align-middle text-muted" style="font-size:100px!important;">verified_user</span>
                        <span class="text-muted"> Select a group... </span>
                    </h5>
                </div>
                <!-- ./ group preview container -->
            </div>
        </div>
        <!-- ./ PRO groups container -->
        _END;
    }

    // $result = null;
    $result = null;
} catch (\Throwable $th) {
    //throw $th;
    $output_msg = "System Error:. [get_user_community_subs (user group subs) - " . $th->getMessage() . "]"; //mysqli_error($dbconn)

    $app_err_msg = <<<_END
    <div class="application-error-msg shadow">
        <h3 style="color: red">An error has occured</h3>
        <p>
            It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('$currentUser_Usrnm','$output_msg')">support</a>
        </p>
        <div class="application-error-msg-output" style="font-size: 10px"> $output_msg </div>
    </div>;
    _END;
    $output = $app_err_msg;
}

$dbconn->close();
echo $output;

// echo "premium/pro content<br/>";
/* echo <<<_END
<div class="row" style="min-height: 50vh;max-height:100vh;">
    <div class="col-md-4" style="max-height:100vh;overflow-y:auto;">
        <!-- group selection list -->
        <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-action d-flex gap-4 justify-content-between align-items-center left-right-grad-white-mineshaft" style="border-radius:25px;">
                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid shadow" style="border-radius:15px;height:100px;" alt="group image." />
                <div class="ms-2 me-auto d-grid">
                    <div class="fs-5 fw-bold mb-4">Group name.</div>
                    <span>Information</span>
                    <span>Trainer</span>
                </div>
                <div class="d-grid gap-2">
                    <span class="badge rounded-pill fw-bold" style="background-color: var(--secondary-color)!important;">
                        <span class="material-icons material-icons-round align-middle" style="font-size:12px!important;">
                            notifications_active
                        </span> 14
                        <span class="visually-hidden">Activities</span>
                    </span>
                    <button class="onefit-buttons-style-dark p-4">
                        <span class="material-icons material-icons-round align-middle" style="color: #fff;">arrow_forward_ios</span>
                    </button>
                </div>
            </li>
            <!-- ./ group selection list -->
        </ul>
    </div>
    <div class="col-md-8" style="max-height:100vh;overflow-y:auto;">
        <!-- group preview container -->
        <div class="h-100 w-100 d-grid align-items-center justify-content-center">
            <h5 class="text-center d-grid gap-2">
                <span class="material-icons material-icons-outlined align-middle text-muted" style="font-size:100px!important;">verified_user</span>
                <span class="text-muted"> Select a group... </span>
            </h5>
        </div>
        <!-- ./ group preview container -->
    </div>
    
</div>
_END; */
