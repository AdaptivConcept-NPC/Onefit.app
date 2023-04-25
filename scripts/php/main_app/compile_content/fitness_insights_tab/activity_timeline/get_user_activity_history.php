<?php
session_start();
require("../../../../config.php");
require_once("../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['usernm'])) {
    $username = sanitizeMySQL($dbconn, $_GET['usernm']);
    $user_activity_id
        = $action_title
        = $action_description
        = $affected_table
        = $record_id
        = $action_date
        = $users_username
        = $timeline = null;

    $cardDirection = "left";

    try {
        //get the users activity timeline/history
        $query = "SELECT * FROM `user_activity` WHERE `users_username` = '$username' ORDER BY `action_date` DESC";
        $result = $dbconn->query($query);

        if (!$result) die("An error occurred while trying to compile the requested data. [output - " . $dbconn->error . "]");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result echo the label
            echo <<<_END
            <div class="text-center p-4">
                <h1 class="fs-5">
                    <span class="p-4" style="background-color:var(--tahitigold);color:var(--mineshaft);border-radius:15px;">No history to display.</span>
                </h1>
            </div>
            _END;
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $user_activity_id = $row["user_activity_id"];
                $action_title = $row["action_title"];
                $action_description = $row["action_description"];
                $affected_table = $row["affected_table"];
                $record_id = $row["record_id"];
                $action_date = $row["action_date"];
                $users_username = $row["users_username"];

                switch ($cardDirection) {
                    case 'left':
                        # change value to right
                        $cardDirection = 'right';
                        break;
                    case 'right':
                        # change value to left
                        $cardDirection = 'left';
                        break;
                    default:
                        # by default should be left
                        $cardDirection = 'left';
                        break;
                }

                $timeline .= <<<_END
                <div class="timeline-container $cardDirection">
                    <div class="date comfortaa-font">$action_date</div><!-- format: 15 Dec 2022 -->
                    <span class="icon">
                        <span class="material-icons material-icons-round" style="font-size: 18px !important;">
                            task_alt
                        </span>
                    </span>
                    <div class="content">
                        <h2 class="comfortaa-font">$action_title</h2>
                        <p class="mb-4">
                            Lorem ipsum dolor sit amet elit. Aliquam odio dolor, id luctus erat sagittis non. Ut blandit
                            semper pretium.
                        </p>
                        <p class="mt-4" style="color: #ffa500;">
                            <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important;">
                                schedule
                            </span>
                            <span class="align-middle">10h00</span>
                        </p>
                    </div>
                </div>
                _END;
            }

            // output the timeline information and close connections
            echo $timeline;
            $result = null;
            $dbconn->close();
        }
    } catch (\Throwable $th) {
        throw "Exception error: $th";
    }
}
