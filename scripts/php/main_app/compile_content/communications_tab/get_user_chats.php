<?php
session_start();
require("../../../config.php");
require("../../../functions.php");

//Connection Test==============================================>
// Check connection
/*if ($dbconn->connect_error) {
      die("Connection failed: " . $dbconn->connect_error);
  }
  echo "Connected successfully";*/
if ($dbconn->connect_error) die("Fatal Error");
//end of Connection Test============================================>

//Declaring variables
$app_err_msg = "";
$communicationUserMessages = "";
$output = "";

if (isset($_SESSION["currentUserAuth"])) {
    if ($_SESSION["currentUserAuth"] == true) {
        $currentUser_Usrnm = sanitizeMySQL($dbconn, $_SESSION["currentUserAuth"]);
    } else {
        die('error: access denied');
    }

    if (isset($_GET['cref'])) {
        $conversation_ref = sanitizeMySQL($dbconn, $_GET['cref']);
    } else {
        die('error: conversation reference not set');
    }

    echo getUserChats($conversation_ref);
} else {
    die('error: session not authorized');
}

function getUserChats($conversation_ref)
{
    global $dbconn;

    // $conversation_ref = "CNV_73HJD8690S"; // default conversation reference if null
    //echo "CRef: $conversation_ref <br>";
    $currentUser_Usrnm = sanitizeMySQL($dbconn, $_SESSION["currentUserUsername"]);
    $profile_pic = "../media/profiles/0_default/default_profile_pic.svg";

    $sql = "SELECT ucm.message_id, ucm.users_username, ucm.send_message_to, ucm.message, ucm.send_date, ucm.message_read, ucm.message_deleted, 
    usrs.user_name, usrs.user_surname, 
    uc.conversations_reference, ucu.users_username AS user_viewing_chat_username 
    FROM user_conversation_messages ucm 
    LEFT JOIN user_conversation_users ucu ON ucu.user_conversations_conversation_id = ucm.user_conversations_conversation_id 
    LEFT JOIN user_conversations uc ON uc.conversation_id = ucu.user_conversations_conversation_id 
    LEFT JOIN users usrs ON usrs.username = ucm.users_username 
    WHERE uc.conversations_reference = '$conversation_ref' AND ucu.users_username = '$currentUser_Usrnm' 
    ORDER BY ucm.message_id ASC;";

    //echo $sql;

    if ($result = mysqli_query($dbconn, $sql)) {
        $communicationUserMessages =
            $message_id =  $users_username =  $send_message_to =  $message =  $send_date =  $message_read =  $message_deleted =
            $user_name =  $user_surname =
            $conversations_reference =  $user_viewing_chat_username = null;

        while ($row = mysqli_fetch_assoc($result)) {
            //ucm: `message_id`, `conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`
            //uc: `conversation_id`, `primary_user`, `secondary_user`, `conversation_start_date`
            //$msg_id = $row["message_id"];

            $message_id =                 $row["message_id"];
            $users_username =             $row["users_username"];
            $send_message_to =            $row["send_message_to"];
            $message =                    $row["message"];
            $send_date =                  $row["send_date"];
            $message_read =               $row["message_read"];
            $message_deleted =            $row["message_deleted"];
            $user_name =                  $row["user_name"];
            $user_surname =               $row["user_surname"];
            $conversations_reference =    $row["conversations_reference"];
            $user_viewing_chat_username = $row["user_viewing_chat_username"];

            if ($message_read == 0) {
                $msg_read_indicator_display_state = "d-none";
            } else {
                $msg_read_indicator_display_state = "d-block";
            }

            if ($users_username == $currentUser_Usrnm) {
                // if true the add message content into the right sided chat bubble
                $communicationUserMessages .= <<<_END
                <div id="chat-message-$message_id" class="row align-items-center">
                    <div class="col-sm-3 border-5z border-bottomz"></div>
                    <div class="col-sm text-end w3-animate-right p-0 pe-4 d-grid justify-content-end">
                        <div class="d-flex gap-2">
                            <div class="talk-bubble shadow tri-right shadow right-top border border-5" style="border-radius: 25px 0 25px 25px !important;border-color: var(--secondary-color)!important;">
                                <div class="talktext">
                                    <small class="text-white text-end d-flex gap-3 align-items-center justify-content-between mb-3">
                                        <button class="onefit-buttons-style-dark py-2 px-4 border-0" style="margin-left:-20px;">
                                            <span class="material-icons material-icons-rounded text-mutedz" style="font-size:20px!important;">
                                                more_horiz
                                            </span>
                                        </button>
                                        <div class="d-flex gap-2 align-items-center">
                                            <span class="text-end"> $user_name $user_surname </span>
                                            <img src="$profile_pic" class="rounded-circle p-1 shadow bg-white" style="height: 50px; width: 50px; filter: invert(0);" alt="$user_name $user_surname's profile pic">
                                        </div>
                                    </small>
                                    <p class="mb-3">
                                        $message
                                    </p>
                                    <div class="d-flex gap-2 justify-content-start align-items-center chat-bubble-footer">
                                        <span class="material-icons material-icons-round align-middle $msg_read_indicator_display_state" style="font-size:20px!important;color: var(--primary-color);">
                                            mark_chat_read
                                        </span>
                                        <p class="text-muted text-end align-middle" style="color:var(--white)!important;font-size:12px;" data-msg-datetime="$send_date">
                                            Sent ? minutes ago.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end d-none">
                                <img src="$profile_pic" class="rounded-5 shadow" style="height: 100px; width: 100px; filter: invert(0);" alt="$user_name $user_surname's profile pic">
                            </div>
                        </div>
                    </div>
                </div>
                _END;
            } else {
                // else add message content into the left sided chat bubble
                $communicationUserMessages .= <<<_END
                <div class="row align-items-center">
                    <div class="col-sm text-start w3-animate-left p-0 ps-4 d-grid justify-content-start">
                        <div class="d-flex gap-2">
                            <div class="text-start d-none">
                                <img src="$profile_pic" class="rounded-5 shadow" style="height: 100px;width: 100px;filter: invert(0);z-index:2;position: relative;" alt="$user_name $user_surname's profile pic">
                            </div>
                            <div class="talk-bubble shadow tri-right shadow left-top border border-5" style="border-radius: 0 25px 25px 25px !important;border-color: var(--secondary-color)!important;">
                                <div class="talktext">
                                    <small class="text-white text-end d-flex gap-3 align-items-center justify-content-between mb-3">
                                        <div class="d-flex gap-2 align-items-center">
                                            <img src="$profile_pic" class="rounded-circle p-1 shadow bg-white" style="height: 50px; width: 50px; filter: invert(0);" alt="$user_name $user_surname's profile pic">
                                            <span class="text-start"> $user_name $user_surname </span>
                                        </div>
                                        <button class="onefit-buttons-style-dark py-2 px-4 border-0" style="margin-right:-20px;">
                                            <span class="material-icons material-icons-rounded text-mutedz" style="font-size:20px!important;">
                                                more_horiz
                                            </span>
                                        </button>
                                    </small>
                                    <p class="mb-3">
                                        $message
                                    </p>
                                    <div class="d-flex gap-2 justify-content-start align-items-center chat-bubble-footer">
                                        <span class="material-icons material-icons-round align-middle $msg_read_indicator_display_state" style="font-size:20px!important;color: var(--primary-color);">
                                            mark_chat_read
                                        </span>
                                        <p class="text-muted text-end align-middle" style="color:var(--white)!important;font-size:12px;" data-msg-datetime="$send_date">
                                            Sent ? minute ago.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 text-start border-5z border-bottomz"></div>
                </div>
                _END;
            }
        }

        $output = $communicationUserMessages;

        return $output;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User chat messages) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
        return $output;
    }
}
