<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// declaring variables
if (isset($_GET['grc'])) $grc_code = sanitizeMySQL($dbconn, $_GET['grc']);
else die("grc_code is not set");

if (isset($_GET['memtype'])) $memberType = sanitizeMySQL($dbconn, $_GET['memtype']);
else die("Group member type request is not set");

if (isset($_GET['returntype'])) $returnType = sanitizeMySQL($dbconn, $_GET['returntype']);
else $returnType = "default";

$compileTableItems = null;
// `team_mem_id`, `group_sport`, `group_role`, `field_position`, `group_join_date`, `active`, `status`, `groups_group_ref_code`, `users_username`
$team_mem_id
    = $group_sport
    = $group_role
    = $field_position
    = $group_join_date
    = $active
    = $status
    = $groups_group_ref_code
    = $users_username = null;
$user_name
    = $user_surname
    = $user_gender = null;

$json_compile = null;

if ($returnType === "json") {
    # compile requested data and return it as json string
    try {
        $query = "SELECT tgm.*, usr.user_name, usr.user_surname, usr.user_gender FROM teams_group_members tgm
        INNER JOIN users usr ON tgm.users_username = usr.username
        WHERE tgm.group_role = 'starting' AND tgm.groups_group_ref_code = '$grc_code' ORDER BY team_mem_id ASC";

        // execute query 
        $result = $dbconn->query($query);
        if (!$result) die("Fatal error occured while executing query.");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result die and return with the response
            die("No players found in starting lineup.");
        } else {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            // echo json_encode($row, JSON_PRETTY_PRINT);
            for ($j = 0; $j < $rows; ++$j) {
                //     $row = $result->fetch_array(MYSQLI_ASSOC);

                //     $team_mem_id = $row["team_mem_id"];
                //     $group_sport = $row["group_sport"];
                //     $group_role = $row["group_role"];
                $field_position = $row["field_position"];
                //     $group_join_date = $row["group_join_date"];
                //     $active = $row["active"];
                //     $status = $row["status"];
                //     $groups_group_ref_code = $row["groups_group_ref_code"];
                //     $users_username = $row["users_username"];

                $user_name = $row["user_name"];
                $user_surname = $row["user_surname"];
                //     $user_gender = $row["user_gender"];
            }

            // {"name": "$user_name $user_surname", "position": "$field_position", "img": "../media/profiles/0_default/soccer-player.png"},

            $json_compile .= <<<_JSON
            {name: '$user_name $user_surname', position: '$field_position', img: '../media/profiles/0_default/soccer-player.png'},
            _JSON;
        }

        header('Content-Type: application/json');
        // echo json_encode($row, JSON_PRETTY_PRINT);
        echo json_encode($json_compile, JSON_PRETTY_PRINT);
    } catch (\Throwable $th) {
        throw "Exception Error: " . $th;
    }
} else {
    # compile requested data and return it as default table list html data
    try {
        switch ($memberType) {
            case "starting":
                $query = "SELECT tgm.*, usr.user_name, usr.user_surname, usr.user_gender FROM teams_group_members tgm
                INNER JOIN users usr ON tgm.users_username = usr.username
                WHERE group_role = 'starting' AND groups_group_ref_code = '$grc_code' ORDER BY team_mem_id ASC";
                break;
            case "benched":
                $query = "SELECT tgm.*, usr.user_name, usr.user_surname, usr.user_gender FROM teams_group_members tgm
                INNER JOIN users usr ON tgm.users_username = usr.username
                WHERE group_role = 'bench' AND groups_group_ref_code = '$grc_code' ORDER BY team_mem_id ASC";
                break;
            case "reserve":
                $query = "SELECT tgm.*, usr.user_name, usr.user_surname, usr.user_gender FROM teams_group_members tgm
                INNER JOIN users usr ON tgm.users_username = usr.username
                WHERE group_role = 'reserve' AND groups_group_ref_code = '$grc_code' ORDER BY team_mem_id ASC";
                break;
            case "technical":
                $query = "SELECT tgm.*, usr.user_name, usr.user_surname, usr.user_gender FROM teams_group_members tgm
                INNER JOIN users usr ON tgm.users_username = usr.username
                WHERE group_role = 'technical' AND groups_group_ref_code = '$grc_code' ORDER BY team_mem_id ASC";
                break;

            default:
                die("Unknown member type");
                break;
        }

        // execute query 
        $result = $dbconn->query($query);
        if (!$result) die("Fatal error occured while executing query.");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result echo the label
            // $ucFirstStr = ucfirst($get_privacy);
            $compileTableItems = <<<_END
            <tr>
                <td class="text-center p-4" colspan="5">
                    No players found.
                </td>
            </tr>
            _END;
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $team_mem_id = $row["team_mem_id"];
                $group_sport = $row["group_sport"];
                $group_role = $row["group_role"];
                $field_position = $row["field_position"];
                $group_join_date = $row["group_join_date"];
                $active = $row["active"];
                $status = $row["status"];
                $groups_group_ref_code = $row["groups_group_ref_code"];
                $users_username = $row["users_username"];

                $user_name = $row["user_name"];
                $user_surname = $row["user_surname"];
                $user_gender = $row["user_gender"];

                $compileTableItems .= <<<_END
                <tr>
                    <th scope="row">$team_mem_id</th>
                    <td>
                        Pin here
                    </td>
                    <td>$user_name $user_surname</td>
                    <td>$field_position</td>
                    <td class="d-grid dropdown-center">
                        <button class="onefit-buttons-style-light p-3 dropdown-toggle shadow" style="transform: scale(1)!important;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-icons material-icons-outlined align-middle">
                                expand_circle_down
                            </span>
                        </button>
                        <ul class="dropdown-menu bg-light gap-2 mt-1 p-2 shadow">
                            <li>
                                <button class="dropdown-item fw-bold" type="button" onclick="tacticalPlanModification('open-profile','$users_username')">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">
                                        account_circle
                                    </span>
                                    <span class="align-middle">
                                        View Profile
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item fw-bold" type="button" onclick="tacticalPlanModification('bench-player','$users_username')">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">
                                        arrow_back
                                    </span>
                                    <span class="align-middle">
                                        Bench Player
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item fw-bold" type="button" onclick="tacticalPlanModification('reserve-player','$users_username')">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">
                                        close
                                    </span>
                                    <span class="align-middle">
                                        Researve Player
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item fw-bold" type="button" onclick="modifyFormationPlayerRecord('postion','$users_username')">
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 20px!important;">
                                        control_camera
                                    </span>
                                    <span class="align-middle">
                                        Change Position
                                    </span>
                                    <span class="material-icons material-icons-round align-middle" style="font-size: 15px!important;">chevron_right</span>
                                </button>
                            </li>
                        </ul>
                    </td>
                </tr>
                _END;
            }
        }

        echo $compileTableItems;

        // $result = null;
        $result = null;
        $dbconn->close();
    } catch (\Throwable $th) {
        throw "Exception Error: " . $th;
    }
}
