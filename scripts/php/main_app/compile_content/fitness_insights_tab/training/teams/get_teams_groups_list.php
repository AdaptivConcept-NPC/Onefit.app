<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// declaring variables
if (isset($_GET['get_privacy'])) $get_privacy = sanitizeMySQL($dbconn, $_GET['get_privacy']);
else die("Privacy request is not set");

$current_user_username = sanitizeMySQL($dbconn, $_SESSION['currentUserUsername']);
$compileList = <<<_END
<option value="noselection" selected>🏅 Switch Teams.</option>
_END;
$group_ref_code
    = $group_name
    = $group_category
    = $ucFirstStr = null;

try {
    // select query string based on group privacy that has been requested
    // should get groups that the user is subscribed to only, and those in which the curent user is an admin
    switch ($get_privacy) {
        case 'teams':
            # sql query to get private sports team groups only 
            $query = "SELECT DISTINCT grps.group_ref_code, grps.group_name, grps.group_category FROM groups grps 
            LEFT JOIN teams_group_members tgm ON tgm.groups_group_ref_code = grps.group_ref_code
            LEFT JOIN administrators admn ON admn.username = grps.administrators_username
            WHERE (grps.group_category = 'teams' OR grps.group_privacy = 'private') AND grps.administrators_username = '$current_user_username' ORDER BY grps.group_name DESC";
            break;
        case 'pro':
            # sql query to get private premium/pro groups only
            // get all groups for pro's and they should be the private ones
            $query = "SELECT DISTINCT grps.group_ref_code, grps.group_name, grps.group_category FROM groups grps 
            LEFT JOIN teams_group_members tgm ON tgm.groups_group_ref_code = grps.group_ref_code
            LEFT JOIN administrators admn ON admn.username = grps.administrators_username
            WHERE (grps.group_category = 'pro' OR grps.group_privacy = 'private') AND grps.administrators_username = '$current_user_username' ORDER BY grps.group_name DESC";
            break;
        case 'indi':
            # sql query to get community indi groups only
            // use OR to get all indi groups or public groups
            $query = "SELECT DISTINCT grps.group_ref_code, grps.group_name, grps.group_category FROM groups grps 
            LEFT JOIN teams_group_members tgm ON tgm.groups_group_ref_code = grps.group_ref_code
            LEFT JOIN administrators admn ON admn.username = grps.administrators_username
            WHERE (grps.group_category = 'indi' OR grps.group_privacy = 'public') AND grps.administrators_username = '$current_user_username' ORDER BY grps.group_name DESC";
            break;

        default:
            # die
            die("Group requested is not supported - ($get_privacy)");
            break;
    }

    $result = $dbconn->query($query);

    if (!$result) die("An error occurred while trying to compile the requested data. [output - " . $dbconn->error . "]");

    $rows = $result->num_rows;

    if ($rows == 0) {
        //there is no result echo the label
        $ucFirstStr = ucfirst($get_privacy);
        $compileList = <<<_END
        <option value="error" selected>No $ucFirstStr groups found.</option>
        _END;
    } else {
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $group_ref_code = $row["group_ref_code"];
            $group_name = $row["group_name"];
            $group_category = $row["group_category"];

            $compileList .= <<<_END
            <option value="$group_ref_code" grp-category="$group_category"> $group_name </option>
            _END;
        }
    }

    echo $compileList;

    // close connection
    // $result = null;
    $result = null;
    $dbconn->close();
} catch (\Throwable $th) {
    throw "Exception Error: " . $th;
}
