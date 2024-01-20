<?php

// namespace App;

// use DateTime;
// use DateTimeZone;

// // sample class for testing
// class global_functions
// {
//     public function __construct()
//     {
//         # code...
//     }
// }


//String Sanitization
function sanitizeString($var)
{
    //if(get_magic_quotes_gpc())
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = str_replace("'", '`', $var);
    return $var;
}
function sanitizeMySQL($connection, $var)
{
    $var = $connection->real_escape_string($var);
    $var = sanitizeString($var);
    return $var;
}
/* function mysql_fix_string($dbconn, $string) {
            if(get_magic_quotes_gpc()) $string = stripslashes($string);
            return $dbconn->real_escape_string($string);
        } */
function generateAlphaNumericRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateUpperCapsAlphaNumericRandomString($length)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateNumericRandomString($length)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generatePasswordRandomString($length)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// cryptographically accurate
function generateRandomBytes($length)
{
    try {
        //check if #length is an integer, if true then return the formated uuid string, else return false flag.
        if (is_int($length)) {
            $bytes = random_bytes($length);
            return format_uuidv4($bytes);
        } else {
            return false;
        }
    } catch (\Throwable $th) {
        throw "Exception Error [generateRandomBytes]: \n $th";
    }
}
// source: https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function format_uuidv4($data)
{
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// check if directory exists / is initialized with propper sub-folders, if true create sub-media folder (media)
function checkDirectoryInit($username)
{
    $requiredFolders = array("shared_media", "private_media", "video_media", "audio_media");
    $dirStructure = "";

    foreach ($requiredFolders as $subFldr) {
        $dirStructure = "../../media/profiles/$username/$subFldr";
        if (!is_dir($dirStructure)) {
            //create the $dirStructure
            if (!mkdir($dirStructure, 0777, true)) {
                die('Failed to create directories...');
            }
        }
    }
}

// Replace all characters that aren't letters and numbers with a hyphen - source: https://stackoverflow.com/questions/14114411/replace-all-characters-that-arent-letters-and-numbers-with-a-hyphen
function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

// function to check if username is an admin username or not
function verifyAdminUsername($verif_username)
{
    global $dbconn;
    $admin_exists = false;
    // should return true if username is an admin username, false otherwise
    try {
        // check if $verif_username is an admin username
        $sql = "SELECT username FROM administrators WHERE username ='$verif_username' AND account_active = 1";
        if ($result = mysqli_query($dbconn, $sql)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $admin_exists = true;
            }
        } else {
            $admin_exists = false;
        }
        // $result = null;
        // $dbconn->close();

        return $admin_exists;
    } catch (\Throwable $th) {
        throw "Exception error: $th";

        return false;
    }
}

// function to get string between two characters/markers
// source: http://stackoverflow.com/questions/5696412/ddg#9826656
function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

// function to get luminosity contract for bg color and text color
// source: https://stackoverflow.com/questions/1331591/given-a-background-color-black-or-white-text
function getContrastColor($hexColor)
{
    // hexColor RGB
    $R1 = hexdec(substr($hexColor, 1, 2));
    $G1 = hexdec(substr($hexColor, 3, 2));
    $B1 = hexdec(substr($hexColor, 5, 2));

    // Black RGB
    $blackColor = "#000000";
    $R2BlackColor = hexdec(substr($blackColor, 1, 2));
    $G2BlackColor = hexdec(substr($blackColor, 3, 2));
    $B2BlackColor = hexdec(substr($blackColor, 5, 2));

    // Calc contrast ratio
    $L1 = 0.2126 * pow($R1 / 255, 2.2) +
        0.7152 * pow($G1 / 255, 2.2) +
        0.0722 * pow($B1 / 255, 2.2);

    $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
        0.7152 * pow($G2BlackColor / 255, 2.2) +
        0.0722 * pow($B2BlackColor / 255, 2.2);

    $contrastRatio = 0;
    if ($L1 > $L2) {
        $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
    } else {
        $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
    }

    // If contrast is more than 5, return black color
    if ($contrastRatio > 5) {
        return '#000000';
    } else {
        // if not, return white color.
        return '#FFFFFF';
    }
}

// Will return '#FFFFFF'
//echo getContrastColor('#FF0000');

// converts an html color name to a hex color value
// if the input is not a color name, the original value is returned
// http://wpCodeSnippets.info
// source: https://stackoverflow.com/questions/2553566/how-to-convert-a-string-color-to-its-hex-code-or-rgb-value

function color_name_to_hex($color_name)
{
    // standard 147 HTML color names
    $colors  =  array(
        'aliceblue' => 'F0F8FF',
        'antiquewhite' => 'FAEBD7',
        'aqua' => '00FFFF',
        'aquamarine' => '7FFFD4',
        'azure' => 'F0FFFF',
        'beige' => 'F5F5DC',
        'bisque' => 'FFE4C4',
        'black' => '000000',
        'blanchedalmond ' => 'FFEBCD',
        'blue' => '0000FF',
        'blueviolet' => '8A2BE2',
        'brown' => 'A52A2A',
        'burlywood' => 'DEB887',
        'cadetblue' => '5F9EA0',
        'chartreuse' => '7FFF00',
        'chocolate' => 'D2691E',
        'coral' => 'FF7F50',
        'cornflowerblue' => '6495ED',
        'cornsilk' => 'FFF8DC',
        'crimson' => 'DC143C',
        'cyan' => '00FFFF',
        'darkblue' => '00008B',
        'darkcyan' => '008B8B',
        'darkgoldenrod' => 'B8860B',
        'darkgray' => 'A9A9A9',
        'darkgreen' => '006400',
        'darkgrey' => 'A9A9A9',
        'darkkhaki' => 'BDB76B',
        'darkmagenta' => '8B008B',
        'darkolivegreen' => '556B2F',
        'darkorange' => 'FF8C00',
        'darkorchid' => '9932CC',
        'darkred' => '8B0000',
        'darksalmon' => 'E9967A',
        'darkseagreen' => '8FBC8F',
        'darkslateblue' => '483D8B',
        'darkslategray' => '2F4F4F',
        'darkslategrey' => '2F4F4F',
        'darkturquoise' => '00CED1',
        'darkviolet' => '9400D3',
        'deeppink' => 'FF1493',
        'deepskyblue' => '00BFFF',
        'dimgray' => '696969',
        'dimgrey' => '696969',
        'dodgerblue' => '1E90FF',
        'firebrick' => 'B22222',
        'floralwhite' => 'FFFAF0',
        'forestgreen' => '228B22',
        'fuchsia' => 'FF00FF',
        'gainsboro' => 'DCDCDC',
        'ghostwhite' => 'F8F8FF',
        'gold' => 'FFD700',
        'goldenrod' => 'DAA520',
        'gray' => '808080',
        'green' => '008000',
        'greenyellow' => 'ADFF2F',
        'grey' => '808080',
        'honeydew' => 'F0FFF0',
        'hotpink' => 'FF69B4',
        'indianred' => 'CD5C5C',
        'indigo' => '4B0082',
        'ivory' => 'FFFFF0',
        'khaki' => 'F0E68C',
        'lavender' => 'E6E6FA',
        'lavenderblush' => 'FFF0F5',
        'lawngreen' => '7CFC00',
        'lemonchiffon' => 'FFFACD',
        'lightblue' => 'ADD8E6',
        'lightcoral' => 'F08080',
        'lightcyan' => 'E0FFFF',
        'lightgoldenrodyellow' => 'FAFAD2',
        'lightgray' => 'D3D3D3',
        'lightgreen' => '90EE90',
        'lightgrey' => 'D3D3D3',
        'lightpink' => 'FFB6C1',
        'lightsalmon' => 'FFA07A',
        'lightseagreen' => '20B2AA',
        'lightskyblue' => '87CEFA',
        'lightslategray' => '778899',
        'lightslategrey' => '778899',
        'lightsteelblue' => 'B0C4DE',
        'lightyellow' => 'FFFFE0',
        'lime' => '00FF00',
        'limegreen' => '32CD32',
        'linen' => 'FAF0E6',
        'magenta' => 'FF00FF',
        'maroon' => '800000',
        'mediumaquamarine' => '66CDAA',
        'mediumblue' => '0000CD',
        'mediumorchid' => 'BA55D3',
        'mediumpurple' => '9370D0',
        'mediumseagreen' => '3CB371',
        'mediumslateblue' => '7B68EE',
        'mediumspringgreen' => '00FA9A',
        'mediumturquoise' => '48D1CC',
        'mediumvioletred' => 'C71585',
        'midnightblue' => '191970',
        'mintcream' => 'F5FFFA',
        'mistyrose' => 'FFE4E1',
        'moccasin' => 'FFE4B5',
        'navajowhite' => 'FFDEAD',
        'navy' => '000080',
        'oldlace' => 'FDF5E6',
        'olive' => '808000',
        'olivedrab' => '6B8E23',
        'orange' => 'FFA500',
        'orangered' => 'FF4500',
        'orchid' => 'DA70D6',
        'palegoldenrod' => 'EEE8AA',
        'palegreen' => '98FB98',
        'paleturquoise' => 'AFEEEE',
        'palevioletred' => 'DB7093',
        'papayawhip' => 'FFEFD5',
        'peachpuff' => 'FFDAB9',
        'peru' => 'CD853F',
        'pink' => 'FFC0CB',
        'plum' => 'DDA0DD',
        'powderblue' => 'B0E0E6',
        'purple' => '800080',
        'red' => 'FF0000',
        'rosybrown' => 'BC8F8F',
        'royalblue' => '4169E1',
        'saddlebrown' => '8B4513',
        'salmon' => 'FA8072',
        'sandybrown' => 'F4A460',
        'seagreen' => '2E8B57',
        'seashell' => 'FFF5EE',
        'sienna' => 'A0522D',
        'silver' => 'C0C0C0',
        'skyblue' => '87CEEB',
        'slateblue' => '6A5ACD',
        'slategray' => '708090',
        'slategrey' => '708090',
        'snow' => 'FFFAFA',
        'springgreen' => '00FF7F',
        'steelblue' => '4682B4',
        'tan' => 'D2B48C',
        'teal' => '008080',
        'thistle' => 'D8BFD8',
        'tomato' => 'FF6347',
        'turquoise' => '40E0D0',
        'violet' => 'EE82EE',
        'wheat' => 'F5DEB3',
        'white' => 'FFFFFF',
        'whitesmoke' => 'F5F5F5',
        'yellow' => 'FFFF00',
        'yellowgreen' => '9ACD32'
    );

    $color_name = strtolower($color_name);
    if (isset($colors[$color_name])) {
        return ('#' . $colors[$color_name]);
    } else {
        return ($color_name);
    }
}

// function to create a new record in the exercises db table for Teams training schedule
function newExercise($exercisetitle, $exercisedescription, $exerciseguidelines, $exerciseSets, $exerciseReps, $exerciseRests, $xp_points, $trainingPhase)
{
    global $dbconn;

    try {
        # insert 
        $query = "INSERT INTO `exercises`
        (`exercise_id`, `exercise_name`, `instructions`, `guidelines`, `sets`, `reps`, `rests`, `xp_points`, `training_phase`) 
        VALUES 
        (null,'$exercisetitle','$exercisedescription','$exerciseguidelines',$exerciseSets,$exerciseReps,$exerciseRests,$xp_points,'$trainingPhase')";

        $result = $dbconn->query($query);
        // $result = mysqli_query($dbconn, $query);
        if (!$result) die("Fatal error: " . $dbconn->error);
        else return true;
    } catch (\Throwable $th) {
        throw $th;
    }
}

// function to compile select list (dropdown list items) for exercises and/or linked workouts
function compileSelectInputExerciseList()
{
    global $dbconn;
    $exercise_id = $xp_points = 0;
    $exercise_name = $workout_name = "";
    $compile_workout_activities_list = "";

    // $sql = "SELECT ex.exercise_id, ex.exercise_name, ex.xp_points, wk.workout_name, wk.workout_category FROM exercises ex
    // INNER JOIN workout_training wt ON wt.exercises_exercise_id = ex.exercise_id
    // INNER JOIN workouts wk ON w.workout_id = wt.workouts_workout_id
    // ORDER BY ex.exercise_name ASC";

    $sql = "SELECT `exercise_id`, `exercise_name`, `xp_points` FROM `exercises` ORDER BY `exercise_name` ASC";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $exercise_id = $row["exercise_id"];
            $exercise_name = $row["exercise_name"];
            $xp_points = $row["xp_points"];

            // echo <<<_END
            // <div class="alert alert-success p-3">upid: $exercise_id | exercise name: $exercise_name | xp: $xp_points</div>
            // _END;

            $compile_workout_activities_list .= <<<_END
            <option value="$exercise_id"> $exercise_name ($xp_points<sub style="color: var(--primary-color);">xp</sub>)</option>
            _END;
        }
    } else {
        // echo <<<_END
        //     <div class="alert alert-danger p-3">No exercise items found.</div>
        //     _END;
        $compile_workout_activities_list = '<option value="error">No exercise items found.</option>';
    }

    // $result = null;
    $result = null;
    $dbconn->close();

    return $compile_workout_activities_list;
}

// function to get Scheduled Training Activities list for Teams
function getScheduledTrainingDayActivities($Year, $Month, $Day, $grcode)
{
    global $dbconn;

    $badgeColor =
        $groupGRC =
        $groupName = null;
    $colorTagString = "white";
    $grcode = $grcode || "tst_grp_0001";
    $result_array = array();
    try {
        //code...
        $query = "SELECT DISTINCT(twa.activity_title), 
        twa.teams_activity_id AS twa_id, 
        twa.activity_description,
        twa.activity_icon,
        twa.teams_weekly_schedules_teams_weekly_schedule_id,
        twa.exercises_exercise_id,
        tws.teams_weekly_schedule_id AS tws_id, tws.schedule_title, 
        tws.schedule_rpe, tws.schedule_day, tws.schedule_date, tws.color_code, tws.groups_group_ref_code, grps.*
        FROM teams_weekly_schedules tws 
        LEFT JOIN team_weekly_activities twa ON twa.teams_weekly_schedules_teams_weekly_schedule_id = tws.teams_weekly_schedule_id 
        LEFT JOIN groups grps ON tws.groups_group_ref_code = grps.group_ref_code
        WHERE tws.schedule_date = '$Year-$Month-$Day'";
        // AND grps.group_ref_code = '$grcode'
        $result = $dbconn->query($query);
        // $result = mysqli_query($dbconn, $query);
        if (!$result) die("Fatal error [2]: " . $dbconn->error);

        $rows = $result->num_rows;

        if ($rows > 0) {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $result_array[] = $row;

                // $colorTagString = $row["color_code"];
                // $groupGRC = $row["groups_group_ref_code"];
                // $groupName = $row["group_name"];

                // // extract color name/code
                // $badgeColor = get_string_between($colorTagString, "[", "]");
            }
        }

        return json_encode($result_array);
    } catch (\Throwable $th) {
        throw "error: " . $th;
    }
}

// function to calculate the date difference between two dates (output is in sec).
function dateDifference($start_date, $end_date)
{
    // calulating the difference in timestamps 
    $diff = strtotime($start_date) - strtotime($end_date);

    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds
    return ceil(abs($diff / 86400));
}

// ******** FUNCTIONS FOR COMPILING APP DATA ********** 
// ******** VARIABLES DECLARATION ****************
// user profile demographic details
$usr_userid = $usrprof_username = $usrprof_name = $usrprof_surname = $usrprof_idnumber = $usrprof_email = $usrprof_contact = $usrprof_dob = $usrprof_gender = $usrprof_race = $usrprof_nationality = $usrprof_acc_active = $usr_profileid = $usr_about = $usr_profiletype = $usr_profilepicurl = $usr_verification = NULL;

// storing the other profile details
$socialItems = $profileUserSubsGroupsList = $profileUsersPostsList = $profileUsersResourcesList = $profileUsersProgramsList = $profileUserFriendsList = $profileUsersFavesList = $profileUserMediaList = $profileUserNotifications = $profileUserChats = $profileUserPref = $profileUserChallenges = $currentUserAccountProdImg = NULL;

// storing the community content
$outputCommunityGroups = $outputCommunityNews = $outputCommunityResources = $outputCommunityUpdates = NULL;

// storing the discovery content
$discoveryAllUsersList = $discoveryFitProgsIndi = $discoveryFitProgsTeams = $discoveryAllTrainees = $discoveryAllTrainers = $discoverygroups = NULL;

//getUserChats
$convo_conversationid = $convo_secondaryuser = $secondaryuser_name = $secondaryuser_surname = $communicationUserMessages = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserFriends
$friendid = $friendUsername = $friendName = $friendSurname = $profileUserFriendsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $profileUserSubsGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserMedia
$fileList = $profileUserMediaList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserNotifications
$notif_id = $notif_title = $notif_message = $notif_date = $communicationUserNotifications =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserPref

//getUserProgSubs
$programs_progid = $programs_refcode = $programs_title = $programs_description = $programs_duration = $programs_category = $programs_privacy = $programs_creator = $programs_active = $profileUsersProgramsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserResources
$usrresources_resourceid = $usrresources_title = $usrresources_description = $usrresources_type = $usrresources_link = $usrresources_sharedate = $usrresources_sharename = $usrresources_sharesurname = $profileUsersResourcesList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserSaves
$fave_id = $fave_ref = $fave_date = $post_id = $post_date = $post_msg = $mod_date = $poster_name = $poster_surname = $poster_username = $profileUsersFavesList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserSocials
$usr_socialnet = $usr_socialhandle = $usr_sociallink = $socialNetworkIcon = $socialItems = $userSocialItemsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getUserUpdates
$usrposts_postid = $usrposts_postdate = $usrposts_message = $usrposts_user = $usrposts_faveref  = $usrposts_name = $usrposts_surname = $profileUsersPostsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getCommunityGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $discoverGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getCommunityNews
$news_id = $news_title = $news_content = $news_createdby = $news_date = $news_poster_name = $news_poster_surname = $communicationNews = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getCommunityResources
$resourceid = $resource_title = $resource_descr = $resource_type = $resource_link = $sharedbyUsername = $sharedate = $openlinkbtn = $outputCommunityResources = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

$commpost_postid = $commpost_postdate = $commpost_message = $commpost_user = $commpost_faveref = $commpost_usr_name = $commpost_usr_surname = $communityPosts = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getAllUsers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $usrs_prof_acctype = $discoverPeopleList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getFitProgramsIndi
$indi_programs_progid = $indi_programs_refcode = $indi_programs_title = $indi_programs_description = $indi_programs_duration = $indi_programs_category = $indi_programs_privacy = $indi_programs_creator = $indi_programs_active = $discoverIndiProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getFitProgramsTeams
$team_programs_progid = $team_programs_refcode = $team_programs_title = $team_programs_description = $team_programs_duration = $team_programs_category = $team_programs_privacy = $team_programs_creator = $team_programs_active = $discoverteamProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getAllTrainees
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTraineesList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

//getAllTrainers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTrainersList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = NULL;

// exercise dropdown list
$workout_activities_list = $user_profile_id = $exercise_name = $xp_points = null;

// misc
$currentuser_img_url = $otheruser_img_url = $verifIcon = $otherUserverifIcon = $output_msg = $app_err_msg = $output = NULL;
$uctDateTime = new DateTime(date('Y-m-d H:i:s'));
$uctDateTime->setTimezone(new DateTimeZone("UTC"));

// ******** get users data functions ********
//Content Load Functions - User Profile
function getUserChallenges()
{
    $output = "Loading...";

    return $output;
}
function getUserChatConversations()
{
    global $convo_conversationid, $convo_secondaryuser, $secondaryuser_name, $secondaryuser_surname, $communicationUserMessages, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    $currentUser_Usrnm = sanitizeString($_SESSION["currentUserUsername"]);
    $default_image_url = "../media/profiles/0_default/default_profile_pic.svg";

    $sql = "SELECT DISTINCT(uc.conversations_reference), uc.conversation_id, ucm.message_id, ucm.send_message_to, ucm.message, ucm.message_read, ucm.send_date, usrs.user_name, usrs.user_surname 
    FROM user_conversation_messages ucm 
    LEFT JOIN user_conversations uc ON uc.conversation_id = ucm.user_conversations_conversation_id 
    LEFT JOIN user_conversation_users ucu ON ucu.user_conversations_conversation_id = uc.conversation_id 
    LEFT JOIN users usrs ON usrs.username = ucm.send_message_to 
    WHERE ucm.users_username = '$currentUser_Usrnm' AND ucm.message_deleted = 0 
    ORDER BY ucm.send_date DESC
    LIMIT 1";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $unread_alert_display_state = ""; // initialize alert display state

            $convo_conversationid =     $row["conversation_id"];
            $convo_conversationref =    $row["conversations_reference"];
            $convo_lastmsg =            $row["message"];
            $convo_secondaryuser =      $row["send_message_to"];
            $convo_lastmsgdate =        $row["send_date"];
            $convo_msgread =            $row["message_read"];

            $secondaryuser_name =       $row["user_name"];
            $secondaryuser_surname =    $row["user_surname"];

            if ($convo_msgread) {
                $unread_alert_display_state = "d-none";
            }

            $communicationUserMessages .= <<<_END
            <li class="list-group-item bg-transparent text-white border-5 border-bottom" id="conversation-$convo_conversationid" style="cursor:pointer;border-radius:25px;border-color: var(--primary-color)!important;" onclick="$.loadChatConversation('$convo_conversationid', '$currentUser_Usrnm', '$convo_conversationref');$('#toggle-chats-list-btn').click();">
                <div class="row align-items-center" style="min-height: 100px;">
                    <div class="col-sm-3 text-md-center">
                        <img src="$default_image_url" class="rounded-circle shadow bg-white p-1" style="height: 50px; width: 50px; filter: invert(0);" alt="placeholder profile pic">
                    </div>
                    <div class="col-sm text-center text-truncate gap-2">
                        <p class="fs-5 fw-bold my-0 text-start"> $secondaryuser_name $secondaryuser_surname </p>
                        <p class="fs-5z my-0 text-truncate text-break text-start w-100" style="min-height:30px;color: var(--primary-color);"> $convo_lastmsg </p>
                    </div>
                    <div class="col-sm-2 text-center d-grid justify-content-end py-2 chat-notification-flag-alert w3-animate-left $unread_alert_display_state">
                        <button type="button" class="onefit-buttons-style-dark p-2 position-relative border-0 w3-animate-left" style="margin-top:-40px;" onclick="$.loadChatConversation('$convo_conversationid', '$currentUser_Usrnm', '$convo_conversationref')">
                            <span class="material-icons material-icons-round align-middle w3-animate-fadingz" style="font-size: 30px !important">announcement</span>
                            <span class="position-absolute top-0 start-0 translate-middle p-2 bg-dangerz border-0 border-light rounded-circle w3-animate-fading" style="background-color: var(--primary-color) !important;">
                                <span class="visually-hidden">open conversation</span>
                            </span>
                        </button>
                    </div>
                </div>
                <p class="text-center d-none">
                    $convo_lastmsgdate
                </p>
            </li>
            _END;
        }

        $output = $communicationUserMessages;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User chat conversations list) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2 d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserDetails($username)
{
    global $currentUser_Usrnm, $dbconn;

    $otherUserverifIcon = $usrdetails_userid = $usrdetails_username = $usrdetails_name = $usrdetails_surname = $usrdetails_idnumber = $usrdetails_email = $usrdetails_contact = $usrdetails_dob = $usrdetails_race = $usrdetails_nationality = $usrdetails_acc_active = $usrdetails_profileid = $usrdetails_about = $usrdetails_profiletype = $usrdetails_profilepicurl = $usrdetails_verification = $currentUserAccountProdImg = "";

    // Load the user profile information
    $sql = "SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username WHERE u.username = '$username';";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $usrdetails_userid = $row["user_id"];
            $usrdetails_username = $row["username"];
            $usrdetails_name = $row["user_name"];
            $usrdetails_surname = $row["user_surname"];
            $usrdetails_idnumber = $row["id_number"];
            $usrdetails_email = $row["user_email"];
            $usrdetails_contact = $row["contact_number"];
            $usrdetails_dob = $row["date_of_birth"];
            $usrdetails_gender = $row["user_gender"];
            $usrdetails_race = $row["user_race"];
            $usrdetails_nationality = $row["user_nationality"];
            $usrdetails_acc_active = $row["account_active"];

            $usrdetails_profileid = $row["user_profile_id"];
            $usrdetails_about = $row["about"];
            $usrdetails_profiletype = $row["profile_type"];
            $usrdetails_profileurl = $row["profile_url"];
            $usrdetails_profilepicurl = $row["profile_image_url"];
            $usrdetails_profilebannerurl = $row["profile_banner_url"];
            $usrdetails_verification = $row["verification"];
        }

        // get the other profile details
        //$currentUserAccountProdImg = '<img src="../media/profiles/'.$usrprof_username.'/'.$usr_profilepicurl.'" alt="'.$usrprof_name.' '.$usrprof_surname.' - Profile Picture" class="img-fluid">';

        $otheruser_img_url = "'../media/profiles/$currentUser_Usrnm/$usrdetails_profilepicurl'";

        $otherUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="height: 200px !important; width:  200px !important; background-color: url(' . $otheruser_img_url . ')"></div>';

        // verification icon
        if ($usrdetails_verification == true) {
            $otherUserverifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
        } else {
            $otherUserverifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> groups </span>';
        }

        return $result;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Account details - 2) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

        $output = $app_err_msg;
    }

    return $output;
}
function getUserFriends()
{
    global $friendid, $friendUsername, $friendName, $friendSurname, $profileUserFriendsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;
    $frnd_profilepicurl = $currentUserAccountProdImg = $currentuser_img_url = $verifIcon = "";
    $usr_verification = false;

    //users friends list
    // $sql = "SELECT f.friendship_id, f.friend_username, u.user_name, u.user_surname, gup.profile_url, gup.verification FROM friends f 
    // INNER JOIN users u ON f.friend_username = u.username 
    // INNER JOIN general_user_profiles gup ON f.friend_username = gup.users_username
    // WHERE f.username = '$currentUser_Usrnm' AND f.friendship_status = 1";

    $sql = "SELECT DISTINCT(user_friend_username), frnds.*, usrs.*, gup.* FROM `friends` frnds
    LEFT JOIN users usrs ON usrs.username = frnds.user_friend_username
    LEFT JOIN general_user_profiles gup ON frnds.user_friend_username = gup.users_username
    WHERE frnds.users_username = '$currentUser_Usrnm'  AND frnds.friendship_status = 1";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $friendid = $row["friendship_id"];
            $friendUsername = $row["user_friend_username"];

            $friendName = $row["user_name"];
            $friendSurname = $row["user_surname"];

            $frnd_profilepicurl = $row["profile_url"];

            if ($frnd_profilepicurl == "default" || $frnd_profilepicurl == null || $frnd_profilepicurl == "") {
                $currentuser_img_url = "../media/profiles/0_default/default_profile_pic.svg";
            } else {
                $currentuser_img_url = "../media/profiles/$friendUsername/$frnd_profilepicurl";
            }

            //$currentUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: contain !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 200px !important; width:  200px !important; background: url(' . $currentuser_img_url . ') !important"></div>';

            // verification icon
            if ($usr_verification == true) {
                $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $verifIcon = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            $profileUserFriendsList .= '
            <!-- User Friends - dark Grad -->
            <div class="grid-tile p-0">
                <div class="my-4 darkpads-bg-container" id="friend-' . $friendid . '-' . $friendUsername . '" style="border-radius: 25px;">
                    <div class="top-down-grad-light" style="border-radius: 25px;">
                        <div class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                            <div class="col-xlg-2 text-center p-4">
                                <img src="' . $currentuser_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail">
                            </div>
                            <div class="col-xlg-6 text-center p-4">
                                <h3 class="text-white">' . $friendName . ' ' . $friendSurname . '</h3>
                                <p style="font-size: 10px">@' . $friendUsername . '</p>
                                <p style="font-size: 10px">Level.: 1</p>
                                ' . $verifIcon . '
                            </div>
                            <div class="col-xlg-4 text-center p-4">
                                <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $friendUsername . "'" . ')">
                                    View profile <i class=" fas fa-chevron-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ User Friends - dark Grad -->';
        }

        $output = $profileUserFriendsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users friends) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserGroups()
{
    global $grps_groupid, $grps_refcode, $grps_name, $grps_description, $grps_category, $grps_privacy, $grps_createdby, $grps_createdate, $profileUserSubsGroupsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //groups that the user is a member of
    // $sql = "SELECT g.* FROM groups g 
    // INNER JOIN group_members gm ON  g.group_ref_code = gm.group_ref_code 
    // WHERE gm.username = '$currentUser_Usrnm';"; //

    $sql = "SELECT DISTINCT(group_ref_code), grps.* FROM groups grps 
    LEFT JOIN community_group_members cgm ON cgm.groups_group_ref_code = grps.group_ref_code 
    LEFT JOIN teams_group_members tgm ON tgm.groups_group_ref_code = grps.group_ref_code 
    LEFT JOIN premium_group_members pgm ON pgm.groups_group_ref_code = grps.group_ref_code 
    WHERE (cgm.users_username = '$currentUser_Usrnm' OR tgm.users_username = '$currentUser_Usrnm' OR pgm.users_username = '$currentUser_Usrnm');";

    $groupMemsArray = array();
    $foundGroup = false;

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $foundGroup = true;

            $grps_groupid = $row["group_id"];
            $grps_refcode = $row["group_ref_code"];

            $grps_name = $row["group_name"];
            $grps_description = $row["group_description"];
            $grps_category = $row["group_category"];
            $grps_privacy = $row["group_privacy"];
            $grps_createdby = $row["administrators_username"];
            $grps_createdate = $row["creation_date"];

            $profileUserSubsGroupsList .= '
            <!-- Group Card -->
            <div class="grid-tile">
                <div class="px-2 mx-0 content-panel-border-style my-4 darkpads-bg-container"
                style="overflow: hidden; border-radius: 25px;" id="group-' . $grps_groupid . '-' . $grps_refcode . '">
                    <div class="row align-items-center top-down-grad-dark">
                        <div class="col-lg-4 text-center p-4 w-100">
                            <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid" style="border-radius: 25px;"
                            alt="preview palceholder - delete">
                        </div>
                        <div class="col-lg -8 p-4 left-right-grad-tahiti-mineshaft" style="border-radius: 25px; color: var(--secondary-color);">
                            <div class="row">
                                <div class="col-md text-dark">
                                <h3>' . $grps_name . ' <span style="font-size: 10px; color: #fff;">' . $grps_privacy . '</span></h3>
                                <p>' . $grps_category . '</p>

                                </div>
                                <div class="col-md text-white">
                                <p class="text-dark">' . $grps_description . '</p>
                                <p class="text-right mt-4" style="font-size: 8px;">' . $grps_createdate . '</p>
                                </div>
                            </div>
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font shadow my-4"
                                onclick="openGroup(' . "'" . $grps_refcode . "'" . ')">
                                Open group <i class="fas fa-chevron-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ Group Card -->';

            //$groupMemsArray = $row;
        }
        /*echo $discoverGroupsList;
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo json_encode($groupMemsArray);
    die();*/

        $output = $profileUserSubsGroupsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserMedia()
{
    global $fileList, $profileUserMediaList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //users media items
    //Get a list of file paths using the glob function.
    $fileList = glob("../media/profiles/$currentUser_Usrnm/*");

    //Loop through the array that glob returned.
    foreach ($fileList as $filename) {
        //Simply print them out onto the screen.
        //echo $filename, '<br>'; 
        $profileUserMediaList .= '
      <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px;">
      <img src="' . $filename . '" class="img-fluid" alt="media image">
      </div>';
    }

    $output = $profileUserMediaList;

    return $output;
}
// source: 
function get_time_ago($time)
{
    $time_difference = time() - strtotime($time);
    if ($time_difference < 1) {
        return 'less than 1 second ago';
    }
    $condition = array(
        12 * 30 * 24 * 60 * 60 =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>  'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return 'About ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}
function getUserNotifications($listType)
{
    // $listType determines the type of list - div / ul / accordion. If not set then default to div
    $listType = $listType ?? "div";

    global $notif_id, $notif_title, $notif_message, $notif_date, $communicationUserNotifications, $grps_category, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;
    $time_ago = null;

    // declaring opening and closing tab for list content
    $openingElem = $closingElem = null;

    // switch $listType
    switch ($listType) {
        case "div":
            $openingElem = '<div id="notifcation-list" class="my-4 top-down-grad-tahiti p-4 border-5 border-top" style="border-radius: 25px;color:var(--secondary-color);">';
            $closingElem = '</div>';
            break;
        case "ul":
            $openingElem = '<ul class="list-group-item list-group-item-action" aria-current="true" id="notifcation-list" style="border-radius: 25px !important;border-color:var(--primary-color)!important;">';
            $closingElem = '</ul>';
            break;
        case "accordion":
            $openingElem = '<div class="accordion accordion-flush" id="notificationsAccordion">';
            $closingElem = '</div>';
            break;
        default:
            $openingElem = '<div id="notifcation-list" class="my-4 top-down-grad-dark p-4 border-5 border-top" style="border-radius: 25px;">';
            $closingElem = '</div>';
            break;
    }

    //notifications
    $sql = "SELECT * FROM notifications WHERE users_username = '$currentUser_Usrnm' ORDER BY notification_date DESC";

    if ($result = mysqli_query($dbconn, $sql)) {
        // assign opening elem / tag
        $communicationUserNotifications = $openingElem;

        while ($row = mysqli_fetch_assoc($result)) {
            //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `users_username`, `notification_date`, `notification_read`

            $notif_id = $row["notification_id"];
            $notif_title = $row["notification_title"];
            $notif_message = $row["notification_message"];
            $notif_date = $row["notification_date"];

            $time_ago = get_time_ago($notif_date);

            // switch $listType
            switch ($listType) {
                case "div":
                    $communicationUserNotifications .= <<<_END
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true" id="notifcation-$notif_id" style="border-radius: 25px !important;">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 fw-bold text-truncate"> $notif_title </h5>
                            <small class="text-end" style="font-size:10px;"> $notif_date<br/>$time_ago </small>
                        </div>
                        <p class="mb-1 text-truncate" style="min-height:30px;max-height:100px;"> $notif_message </p>
                    </a>
                    _END;
                    break;
                case "li":
                    $communicationUserNotifications .= <<<_END
                    <li class="list-item">
                        <a href="#" class="list-group-item list-group-item-action" aria-current="true" id="notifcation-$notif_id" style="border-radius: 25px !important;">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 fw-bold text-truncate"> $notif_title </h5>
                                <small class="text-end" style="font-size:10px;"> $notif_date<br/>$time_ago </small>
                            </div>
                            <p class="mb-1 text-truncate" style="min-height:30px;max-height:100px;"> $notif_message </p>
                        </a>
                    </li
                    _END;
                    break;
                case "accordion":
                    $communicationUserNotifications .= <<<_END
                    <div class="accordion-item d-grid gap-2 p-0 my-2 border-0 shadow down-top-grad-tahiti">
                        <h2 class="accordion-header m-0 p-0" id="cav-flush-header-notifcation-$notif_id">
                            <button class="accordion-button fs-5 fw-bold text-truncate gap-2 d-grid align-items-center collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cav-flush-panel-notifcation-$notif_id" aria-expanded="false" aria-controls="cav-flush-panel-notifcation-$notif_id">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex gap-2 justify-content-start align-items-center">
                                        <!--  style="color: var(--secondary-color)!important;" -->
                                        <span class="material-icons material-icons-round align-middle d-none"> notifications </span>
                                        <span class="align-middle fw-bold fs-5 poppins-font">  $notif_title </span>
                                    </div>
                                    <div class="pin-item-icon shadow p-2" style="border-radius:15px;font-size:10px!important;color: var(--accent-color)!important;">
                                        <span class="material-icons material-icons-round align-middle d-nones" style="font-size:30px !important;"> visibility_off </span>
                                        <span class="poppins-font">Unread.</span>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div class="accordion-collapse w3-animate-bottom collapse" id="cav-flush-panel-notifcation-$notif_id" aria-labelledby="cav-flush-header-notifcation-$notif_id" data-bs-parent="#notificationsAccordion">
                            <div class="accordion-body bg-transparent down-top-grad-dark rounded-4">
                                <div id="notification-message-$notif_id" class="text-start" style="min-height: 100px;">
                                    <p class="poppins-font text-start" style="cursor: pointer;">
                                        $notif_message
                                    </p>
                                    <p class="text-end d-grid mb-0">
                                        <span>$time_ago</span>
                                        <span style="font-size:10px;">$notif_date</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    _END;
                    break;
                default:
                    $communicationUserNotifications .= <<<_END
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true" id="notifcation-$notif_id" style="border-radius: 25px !important;">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 fw-bold text-truncate"> $notif_title </h5>
                            <small class="text-end" style="font-size:10px;"> $notif_date<br/>$time_ago </small>
                        </div>
                        <p class="mb-1 text-truncate" style="min-height:30px;max-height:100px;"> $notif_message </p>
                    </a>
                    _END;
                    break;
            }
        }

        // assign closing elem / tag
        $communicationUserNotifications .= $closingElem;

        $output = $communicationUserNotifications;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2 d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserPref()
{
    global $output;
    $output = "Loading...";
    return $output;
}
function getUserProgSubs()
{
    global $programs_progid, $programs_refcode, $programs_title, $programs_description, $programs_duration, $programs_category, $programs_privacy, $programs_creator, $programs_active, $profileUsersProgramsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //subscriptions (programs)
    //$sql = "SELECT * FROM training_programs;";
    $sql = "SELECT ps.prog_subscriber_id, ps.username, ps.program_ref_code, ps.subscribe_date, tp.program_id, tp.program_title, tp.program_description, tp.program_duration, tp.program_category, tp.program_privacy, tp.users_username, tp.active 
  FROM program_subscribers ps 
  INNER JOIN training_programs tp ON ps.program_ref_code = tp.program_ref_code 
  WHERE username = '$currentUser_Usrnm'";

    //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `users_username`, `creation_date`, `active` 
    //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {

            $programs_progid = $row["program_id"];
            $programs_refcode = $row["program_ref_code"];
            $programs_title = $row["program_title"];
            $programs_description = $row["program_description"];
            $programs_duration = $row["program_duration"];
            $programs_category = $row["program_category"];
            $programs_privacy = $row["program_privacy"];
            $programs_creator = $row["users_username"];
            $programs_active = $row["active"];

            /*$programs_activityid = $row["prog_activity_id"];
            $programs_activitytitle = $row["activity_title"];
            $programs_activityduration = $row["activity_duration"];*/

            $profileUsersProgramsList .= '
            <div class="p-0 mx-0 my-4 darkpads-bg-container" style="border-radius: 25px;" id="discover_programs-' . $programs_progid . '-' . $programs_refcode . '">
                <div class="card content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaft"
                    style="border-right: 0 !important;">
                    <div class="card-body">
                        <img src="../media/profiles/system_tmp/photo-1517838277536-f5f99be501cd.jpg" alt="palceholder" class="img-fluid shadow d-none d-lg-block w-100" style="border-radius: 25px;">
                        <div class="row align-items-center">
                            <div class="col-md py-4">
                                <h3 class="card-title text-truncate">' . $programs_title . ' <span
                                    style="font-size: 10px">(' . $programs_privacy . ')</span>
                                </h3>
                                <p class="card-subtitle ">Head Trainer: @' . $programs_creator . '</p>
                                <p class="card-text">' . $programs_description . '</p>
                            </div>
                            <div class="col-md-8 text-center d-lg-none">
                                <img src="../media/profiles/system_tmp/photo-1517838277536-f5f99be501cd.jpg" alt="palceholder"
                                class="img-fluid shadow" style="border-radius: 25px; max-height: 30vh;">
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow"
                            onclick="openProgram(' . "'" . $programs_refcode . "'" . ')">
                            View Program <i class="fas fa-chevron-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>';
        }

        $output = $profileUsersProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserResources()
{
    global $usrresources_resourceid, $usrresources_title, $usrresources_description, $usrresources_type, $usrresources_link, $usrresources_sharedate, $usrresources_sharename, $usrresources_sharesurname, $profileUsersResourcesList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //community and resource shares (latest 50 posts each)
    $sql = "SELECT * FROM community_resources cr INNER JOIN users u ON cr.shared_by = u.username WHERE cr.shared_by = '$currentUser_Usrnm';";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`comm_resource_id`, `resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
            $usrresources_resourceid = $row["comm_resource_id"];
            $usrresources_title = $row["resource_title"];
            $usrresources_description = $row["resource_description"];
            $usrresources_type = $row["resource_type"];
            $usrresources_link = $row["resource_link"];
            $usrresources_sharedate = $row["share_date"];

            $usrresources_sharename = $row["user_name"];
            $usrresources_sharesurname = $row["user_surname"];

            if ($usrresources_type == "external link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openExtLink(' . "'" . $usrresources_link . "'" . ')"><i class="fas fa-link"></i> Follow link</button>';
            } else if ($usrresources_type == "profile link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'profile'" . ')"><i class="fas fa-id-badge"></i> View profile</button>';
            } else if ($usrresources_type == "post link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'post'" . ')"><i class="fas fa-sticky-note"></i> Open post</button>';
            } else if ($usrresources_type == "document link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'document'" . ')"><i class="fas fa-file-alt"></i> View document</button>';
            } else if ($usrresources_type == "media link") {
                $openlinkbtn = '<button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button" onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'media'" . ')"><i class="fas fa-photo-video"></i> View media</button>';
            }

            $profileUsersResourcesList .= '
            <!-- User Resources - Tile -->
            <div class="grid-tile">
                <div class="p-0 mx-0 my-4 darkpads-bg-container" style="border-radius: 25px;"
                id="resource-' . $usrresources_resourceid . '-' . $currentUser_Usrnm . '" style="max-width: 100%!important">
                <div class="content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaft p-4">
                    <h3 class=" text-truncate">' . $usrresources_title . ' <span
                        style="font-size: 10px">' . $usrresources_type . '</span></h3>
                    <p><span style="color: var(--primary-color)">' . $usrresources_description . '</span></p>
                    <p><i class="fas fa-link"></i> | ' . $usrresources_link . '</p>
                    <p>Shared by: @' . $usrresources_type . '</p>

                    ' . $openlinkbtn . '
                    <button class="onefit-buttons-style-light p-4 fw-bold fs-5 comfortaa-font m-4 shadow" type="button"
                    onclick="openIntLink(' . "'" . $usrresources_link . "'" . ', ' . "'media'" . ')">
                    View media <i class="fas fa-photo-video"></i>
                    </button>

                    <p class="text-right" style="font-size: 8px">' . $usrresources_sharedate . '</p>
                </div>
                </div>
            </div>
            <!-- User Resources - Tile -->';
        }

        $output = $profileUsersResourcesList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getUserSaves()
{
    global $fave_id, $fave_ref, $fave_date, $post_id, $post_date, $post_msg, $mod_date, $poster_name, $poster_surname, $poster_username, $profileUsersFavesList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //Favourites
    $sql = "SELECT * FROM ((fave_saves fs
    INNER JOIN users u ON fs.username = u.username) 
    INNER JOIN community_posts cp ON fs.fave_ref = cp.favourite_ref)
    WHERE fs.username = '$currentUser_Usrnm';";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fave_id = $row['fave_id'];
            $fave_ref = $row['fave_ref'];
            $fave_date = $row['fave_date'];
            $post_id = $row['post_id'];
            $post_date = $row['post_date'];
            $post_msg = $row['post_message'];
            $mod_date = $row['modified_date'];

            $poster_name = $row['user_name'];
            $poster_surname = $row['user_surname'];
            $poster_username = $row['username'];

            $profileUsersFavesList .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4 down-top-grad-tahiti" id="fave-' . $fave_id . '">
                <div class="row align-items-center p-2">
                    <div class="col-md-4 text-center">
                        <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
                    </div>
                    <div class="col-md-8">
                        <h3>' . $poster_name . ' ' . $poster_surname . ' <span style="font-size: 10px">@<span style="color: var(--primary-color)">' . $poster_username . '</span></span></h3>
                    </div>
                </div>
                <div class="post-content">
                    <hr class="bg-white">

                    <p class="my-2">' . $post_msg . '</p>
                    <p class="text-right" style="font-size: 8px">' . $post_date . '</p>

                    <!--function buttons-->
                    <ul class="list-group list-group-horizontal my-4 no-scroller">
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'like'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    favorite
                                </span>
                                <span class="d-none d-lg-block">
                                    Like
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'comment'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    insert_comment
                                </span>
                                <span class="d-none d-lg-block">
                                    Comment
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'share'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    share
                                </span>
                                <span class="d-none d-lg-block">Share</span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $post_id . ', ' . "'$currentUser_Usrnm'" . ', ' . "'save'" . ', ' . "'user_faves'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    remove_circle_outline
                                </span>
                                <span class="d-none d-lg-block">Remove</span>
                            </button>
                        </li>
                    </ul>
                    <!-- ./ function buttons -->
                </div>
            </div>';
        }

        $output = $profileUsersFavesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

        $output = $app_err_msg;
    }

    return $output;
}
function getUserSocials()
{
    global $usr_socialnet, $usr_socialhandle, $usr_sociallink, $socialNetworkIcon, $socialItems, $userSocialItemsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //get the social details
    $sql = "SELECT social_network, handle, link FROM user_socials WHERE username = '$currentUser_Usrnm'";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            //u.user_id, u.username, u.user_name, u.user_surname, u.id_number, u.user_email, u.contact_number, u.date_of_birth, u.user_gender, u.user_race, u.user_nationality, u.account_active
            $usr_socialnet = $row["social_network"];
            $usr_socialhandle = $row["handle"];
            $usr_sociallink = $row["link"];

            if ($usr_socialnet == "facebook") {
                $socialNetworkIcon = '<i class="fab fa-facebook"></i>';
            } else if ($usr_socialnet == "twitter") {
                $socialNetworkIcon = '<img class="twitter-x-icon" src="../media/assets/icons/twitter-x-symbol-white.svg" style="height:40px;width:40px"
                            alt="Twitter - X logo">';
            } else if ($usr_socialnet == "instagram") {
                $socialNetworkIcon = '<i class="fab fa-instagram"></i>';
            } else if ($usr_socialnet == "tumbler") {
                $socialNetworkIcon = '<i class="fab fa-tumblr"></i>';
            } else if ($usr_socialnet == "whatsapp") {
                $socialNetworkIcon = '<i class="fab fa-whatsapp"></i>';
            } else if ($usr_socialnet == "reddit") {
                $socialNetworkIcon = '<i class="fab fa-reddit"></i>';
            } else {
                $socialNetworkIcon = '<i class="fas fa-globe-africa"></i>';
            }

            $socialItems .= '<li class="list-group-item text-center text-dark bg-transparent rounded-pill shadow my-2 mx-1 p-4 social-link flex-fill user-social-strip"><span class="p-2 mr-2 bg-warningz" style="border-radius: 5px">' . $socialNetworkIcon . '</span> | <a href="' . $usr_sociallink . '">' . $usr_socialhandle . '</a></li>';

            $socialItems .= '';
        }
        //echo $discoverPeopleList;
        //die();

        $userSocialItemsList = <<<_END
    <ul class="list-group list-group-horizontal-md justify-content-center p-2 shadow" style="border-radius: 25px; background: #333">$socialItems</ul>
    _END;

        $output = $userSocialItemsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Social details) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        $output = $app_err_msg;
        //exit();
    }

    return $output;
}
function getUserUpdates()
{
    global $usrposts_postid, $usrposts_postdate, $usrposts_message, $usrposts_user, $usrposts_faveref, $currentUserAccountProdImg, $usrposts_name, $usrposts_surname, $profileUsersPostsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    $sql = "SELECT * FROM community_posts cp 
    INNER JOIN users u ON cp.username = u.username 
    INNER JOIN general_user_profiles gup ON u.username = gup.users_username
    WHERE cp.username = '$currentUser_Usrnm';";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
            $usrposts_postid = $row["post_id"];
            $usrposts_postdate = $row["post_date"];
            $usrposts_message = $row["post_message"];
            $usrposts_user = $row["username"];
            $usrposts_faveref = $row["favourite_ref"];

            $usrposts_name = $row["user_name"];
            $usrposts_surname = $row["user_surname"];

            $usrposts_profilepicurl = $row["profile_url"];
            $usrposts_verification = $row["verification"];

            //calc post date
            /* $date1 = $row["post_date"]; //date('Y-m-d', $usrposts_postdate); //date_create("2013-03-15");
            $date2 = date_create("2013-12-12");
            $diff = date_diff($date1, $date2);
            echo $diff->format("%a days"); */

            // verification icon
            if ($usrposts_verification == "verified") {
                $usrposts_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $usrposts_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            // start date 
            $start_date = $usrposts_postdate;

            // end date 
            $current_datetime = new DateTime(date('Y-m-d H:i:s'));
            $end_date = $current_datetime->format('Y-m-d H:i:s');

            // call dateDifference() function to find the number of days between two dates
            $dateDiff = dateDifference($start_date, $end_date);

            //echo "Difference between two dates: " . $dateDiff . " Days ";

            $profileUsersPostsList .= '
            <!-- Social Update Card -->
            <div class="my-4 p-0 social-update-card shadow-lg" style="border-bottom: #ffa500 solid 5px;"
            id="post-' . $usrposts_postid . '-' . $usrposts_user . '">
            <div class="row align-items-center px-4 py-4 m-0 down-top-grad-darkz" style="border-radius: 25px!important;">
                <div class="col-md-4  text-center">
                    ' . $currentUserAccountProdImg . '
                </div>
                <div class="col-md-8 text-end">
                    <div class="d-grid gap-4 p-2" style="border-radius: 15px!important; background-color: rgba(52, 52, 52, 0.8) !important;">
                        <h3 class="text-truncate">' . $usrposts_name . ' ' . $usrposts_surname . ' ' . $usrposts_verification_output . '</h3>
                        <span style="font-size: 10px">@<span style="color: var(--primary-color)">' . $usrposts_user . '</span>
                    </div>
                </div>
            </div>
            <div class="post-content px-4 px-0 fs-4 text-break down-top-grad-dark" style="border-radius: 25px!important;">
                <hr class="bg-white">
                <div>
                    <p class="my-2 text-break">' . $usrposts_message . '</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md text-center">
                        <hr class="bg-white">
                    </div>
                    <div class="col-md-3 text-center">
                        <p class="text-right p-3 rounded-pill bg-white text-dark m-0" style="font-size: 10px">' . $dateDiff . ' days ago <!--(' . $usrposts_postdate . ')-->
                        </p>
                    </div>
                </div>

                <!--function buttons-->
                <ul class="list-group list-group-horizontal -sm my-4 no-scroller" style="overflow-x: auto;">
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'like'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                favorite
                            </span>
                            <span class="d-none d-lg-block">Like</span>
                        </button>
                    </li>
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'comment'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                insert_comment
                            </span>
                            <span class="d-none d-lg-block">
                                Comment
                            </span>
                        </button>
                    </li>
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'share'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                share
                            </span>
                            <span class="d-none d-lg-block">Share</span>
                        </button>
                    </li>
                    <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                        <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font"
                        onclick="socialFunctions(' . $usrposts_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'save'" . ', ' . "'user_profile'" . ')">
                            <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                bookmarks
                            </span>
                            <span class="d-none d-lg-block">Save</span>
                        </button>
                    </li>
                </ul>
            </div>
            </div>
            <!-- ./ Social Update Card -->';
        }

        $output = $profileUsersPostsList;
    } else {
        $output_msg = "|[System Error]|:. [Profile load (Users posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}

// ******** ./ get users data functions ********

// ******** get community data functions ********
//Content Load Functions - Community Content
function getCommunityGroups()
{
    // declaring variables
    global $dbconn;
    global $currentUser_Usrnm, $communityGroupsList, $app_err_msg, $output;

    try {
        //groups
        $sql = "SELECT * FROM groups WHERE group_category = 'indi' ORDER BY group_id DESC";

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

                $communityGroupsList .= <<<_END
                <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="group-card-$grps_groupid-$grps_refcode">
                    <div class="row align-items-center">
                    <div class="col-md -4 text-center">
                        <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
                    </div>
                    <div class="col-md -8">
                        <h3>$grps_name<span style="font-size: 10px">$grps_privacy</span></h3>
                        <p><span style="color: var(--primary-color)">$grps_description</span></p>
                        <p>$grps_category</p>
                        <button class="null-btn shadow mt-4" onclick="openGroup('$grps_refcode')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
                        <p class="text-right" style="font-size: 8px">$grps_createdby</p>
                        <p class="text-right" style="font-size: 8px">$grps_createdate</p>
                    </div>
                    </div>
                </div>
                _END;
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
        $output_msg = "|[System Error]|:. [get_user_community_subs (user group subs) - " . $th->getMessage() . "]"; //mysqli_error($dbconn)
        $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';

        $output = $app_err_msg;
    }

    return $output;
}
function getCommunityNews()
{
    global $dbconn, $news_id, $news_title, $news_content, $news_createdby, $news_date, $news_poster_name, $news_poster_surname, $communicationNews, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //news
    // $sql = "SELECT * FROM news n INNER JOIN users u ON n.users_username = u.username ORDER BY n.creation_date DESC";
    $sql = "SELECT * FROM news ORDER BY article_id DESC";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`article_id`, `article_title`, `content`, `creation_date`

            $news_id = $row["article_id"];
            $news_title = $row["article_title"];
            $news_content = $row["content"];
            // $news_createdby = $row["users_username"];
            $news_date = $row["creation_date"];

            // $news_poster_name = $row["user_name"];
            // $news_poster_surname = $row["user_surname"];
            $news_poster_name = "One-On-One Fitness";
            $news_poster_surname = "Network (" . date('Y') . ")";

            $communicationNews .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="news-' . $news_id . '">
                <h3>' . $news_title . ' <span style="font-size: 10px">By ' . $news_poster_name . ' ' . $news_poster_surname . '</span></h3>
                <p><span style="color: var(--primary-color)">' . $news_content . '</span></p>
                <p class="text-right" style="font-size: 8px">' . $news_date . '</p>
            </div>
            ';
        }

        $output = $communicationNews;
    } else {
        $output_msg = "|[System Error]|:. [Communications load (User notifications) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2 d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getCommunityResources()
{
    global $dbconn, $resourceid, $resource_title, $resource_descr, $resource_type, $resource_link, $sharedbyUsername, $sharedate, $openlinkbtn, $outputCommunityResources, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //fitness resources (latest 50 resources)
    $sql = "SELECT * FROM community_resources";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            //`resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
            $resourceid = $row["comm_resource_id"];
            $resource_title = $row["resource_title"];
            $resource_descr = $row["resource_description"];
            $resource_type = $row["resource_type"];
            $resource_link = $row["resource_link"];
            $sharedbyUsername = $row["shared_by"];
            $sharedate = $row["share_date"];

            if ($resource_type == "external link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink(' . "'" . $resource_link . "'" . ')"><i class="fas fa-link"></i> Follow link</button>';
            } else if ($resource_type == "profile link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'profile'" . ')"><i class="fas fa-id-badge"></i> View profile</button>';
            } else if ($resource_type == "post link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'post'" . ')"><i class="fas fa-sticky-note"></i> Open post</button>';
            } else if ($resource_type == "document link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'document'" . ')"><i class="fas fa-file-alt"></i> View document</button>';
            } else if ($resource_type == "media link") {
                $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink(' . "'" . $resource_link . "'" . ', ' . "'media'" . ')"><i class="fas fa-photo-video"></i> View media</button>';
            }

            $outputCommunityResources .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-' . $resourceid . '-' . $sharedbyUsername . '">
                <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
                </div>
                <div class="col-md-8">
                    <h3>' . $resource_title . ' <span style="font-size: 10px">' . $resource_type . '</span></h3>
                    <p><span style="color: var(--primary-color)">' . $resource_descr . '</span></p>
                    <p><i class="fas fa-link"></i> | ' . $resource_link . '</p>
                    <p>Shared by: @' . $sharedbyUsername . '</p>

                    ' . $openlinkbtn . '

                    <p class="text-right" style="font-size: 8px;">' . $sharedate . '</p>
                </div>
                </div>
            </div>';
        }
        //$discoverResourcesList = $homeCommunityResources;
        $output = $outputCommunityResources;
    } else {
        $output_msg = "|[System Error]|:. [Home load (Community resources) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getCommunityUpdates()
{
    global $dbconn, $commpost_postid, $commpost_postdate, $commpost_message, $commpost_user, $commpost_faveref, $commpost_usr_name, $commpost_usr_surname, $communityPosts, $currentUserAccountProdImg, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //local
    $commpost_img_url = "";
    $commpostUserAccountProdImg = "";
    $commpostusr_profilepicurl = "";
    $commpostusr_verification = "";

    //community posts (latest 50 posts)
    $sql = "SELECT * FROM community_posts cp 
    INNER JOIN users u ON cp.username = u.username
    INNER JOIN general_user_profiles gup ON u.username = gup.users_username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            // cp: `post_id`, `users_username`, `post_date`, `post_message`, `modified_date`, `favourite_ref`
            // gup: `user_profile_id`, `about`, `profile_type`, `verification`, `profile_url`, `profile_image_url`, `profile_banner_url`, `users_username`
            // u: `user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`
            $commpost_postid = $row["post_id"];
            $commpost_postdate = $row["post_date"];
            $commpost_message = $row["post_message"];
            $commpost_username = $row["username"];
            $commpost_faveref = $row["favourite_ref"];
            $commpost_usr_name = $row["user_name"];
            $commpost_usr_surname = $row["user_surname"];

            $commpostusr_profilepicurl = $row["profile_image_url"];
            $commpostusr_verification = $row["verification"];

            // start date 
            $start_date = $commpost_postdate;

            // end date 
            $current_datetime = new DateTime(date('Y-m-d H:i:s'));
            $end_date = $current_datetime->format('Y-m-d H:i:s');

            // call dateDifference() function to find the number of days between two dates
            $dateDiff = dateDifference($start_date, $end_date);

            //echo "Difference between two dates: " . $dateDiff . " Days ";

            // verification icon
            if ($commpostusr_verification == "verified") {
                $commpostusr_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $commpostusr_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($commpostusr_profilepicurl == "default" || $commpostusr_profilepicurl == null || $commpostusr_profilepicurl == "") {
                $commpost_img_url = "'../media/profiles/0_default/default_profile_pic.svg'";
            }
            // else {
            //     $commpost_img_url = "'../media/profiles/$commpost_username/$commpostusr_profilepicurl'";
            // }

            $commpostUserAccountProdImg = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $commpost_img_url . ') !important;"></div>';


            $communityPosts .= '
            <!-- Community Update Card -->
            <div class="px-2 mx-0 my-4 social-update-card" style="border-bottom: #ffa500 solid 5px;" id="post-' . $commpost_postid . '-' . $commpost_username . '">
                <div class="row align-items-center px-4 py-4 m-0" style="border-radius: 25px!important;">
                    <div class="col-md-4 text-center">
                    ' . $commpostUserAccountProdImg . '
                    </div>
                    <div class="col-md-8 text-end">
                    <div class="d-grid gap-4 p-2" style="border-radius: 15px!important; background-color: rgba(52, 52, 52, 0.8) !important;">
                        <h3 class="text-truncate">' . $commpost_usr_name . ' ' . $commpost_usr_surname . ' ' . $commpostusr_verification_output . '</h3>
                        <span style="font-size: 10px">@<span style="color: var(--primary-color)">' . $commpost_username . '</span></span>
                    </div>
                    </div>
                </div>
                <div class="post-content">
                    <hr class="bg-white">
                    <div>
                    <p class="m-4 text-break">' . $commpost_message . '</p>
                    </div>
                    <div class="row align-items-center">
                    <div class="col-md text-center">
                        <hr class="bg-white">
                    </div>
                    <div class="col-md-3 text-center">
                        <p class="text-right p-3 rounded-pill bg-white text-dark m-0" style="font-size: 10px">' . $dateDiff . ' days ago <!--(' . $commpost_postdate . ')-->
                        </p>
                    </div>
                    </div>

                    <!-- function buttons -->
                    <ul class="list-group list-group-horizontal my-4 no-scroller">
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$commpost_username'" . ', ' . "'like'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    favorite
                                </span>
                                <span class="d-none d-lg-block">
                                    Like
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'comment'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    insert_comment
                                </span>
                                <span class="d-none d-lg-block">
                                    Comment
                                </span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'share'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    share
                                </span>
                                <span class="d-none d-lg-block">Share</span>
                            </button>
                        </li>
                        <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 px-0">
                            <button class="onefit-buttons-style-dark p-4 fw-bold fs-5 comfortaa-font" onclick="socialFunctions(' . $commpost_postid . ', ' . "'$currentUser_Usrnm'" . ', ' . "'save'" . ', ' . "'community_posts'" . ')">
                                <span class="material-icons material-icons-round" style="font-size: 30px !important;">
                                    bookmarks
                                </span>
                                <span class="d-none d-lg-block">Save</span>
                            </button>
                        </li>
                    </ul>
                    <!-- ./ function buttons -->
                </div>
            </div>
            <!-- Community Update Card -->';
        }

        $output = $communityPosts;
    } else {
        $output_msg = "|[System Error]|:. [Home load (Community posts) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}

// ******** ./ get community data functions ********

// ******** get system/platform data functions ********
//Content Load Functions - Discovery Specific Content
function getAllUsers()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $usrs_prof_acctype, $discoverPeopleList, $activitiesTraineesList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg, $usr_profileid, $usr_about, $usr_profiletype, $usr_profilepicurl, $usr_verification;

    $allusrs_userid = null;
    $allusrs_username = $allusrs_name = $allusrs_surname = $allusrs_idnumber = $allusrs_email = $allusrs_contact = $allusrs_dob = $allusrs_gender = $allusrs_race = $allusrs_nationality = "";
    $allusrs_acc_active = false;
    $allusrs_prof_acctype = "Community";
    $allusrs_profileid = null;
    $allusrs_about = $allusrs_profileurl = $allusrs_profilepicurl = $allusrs_profilebannerurl = $allusrs_verification =  $allusrs_verification_output = $allusers_account_prod_img = $allusers_img_url = "";

    $users_exist = false;

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            // gup: `user_profile_id`, `about`, `profile_type`, `verification`, `profile_url`, `profile_image_url`, `profile_banner_url`, `users_username`
            // u: `user_id`, `username`, `password_hash`, `user_name`, `user_surname`, `id_number`, `user_email`, `contact_number`, `date_of_birth`, `user_gender`, `user_race`, `user_nationality`, `account_active`

            $users_exist = true;
            $allusrs_userid = $row["user_id"];
            $allusrs_username = $row["username"];
            $allusrs_name = $row["user_name"];
            $allusrs_surname = $row["user_surname"];
            $allusrs_idnumber = $row["id_number"];
            $allusrs_email = $row["user_email"];
            $allusrs_contact = $row["contact_number"];
            $allusrs_dob = $row["date_of_birth"];
            $allusrs_gender = $row["user_gender"];
            $allusrs_race = $row["user_race"];
            $allusrs_nationality = $row["user_nationality"];
            $allusrs_acc_active = $row["account_active"];

            $allusrs_profileid = $row["user_profile_id"];
            $allusrs_about = $row["about"];
            $allusrs_prof_acctype = $row["profile_type"];
            $allusrs_profileurl = $row["profile_url"];
            $allusrs_profilepicurl = $row["profile_image_url"];
            $allusrs_profilebannerurl = $row["profile_banner_url"];
            $allusrs_verification = $row["verification"];

            // verification icon
            if ($allusrs_verification == "verified") {
                $allusrs_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $allusrs_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($allusrs_profilepicurl == "default" || $allusrs_profilepicurl == null || $allusrs_profilepicurl == "") {
                $allusers_img_url = "../media/profiles/0_default/default_profile_pic.svg";
            }
            // else {
            //     $allusers_img_url = "../media/profiles/$allusrs_username/$allusrs_profilepicurl";
            // }

            $allusers_account_prod_img = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $allusers_img_url . ') !important;"></div>';


            $discoverPeopleList .= '
            <!-- All Users Card - dark Grad -->
            <div class="grid-tile">
              <div class="my-4 container-fluid darkpads-bg-container" id="discover_trainee-' . $allusrs_userid . '-' . $allusrs_username . '"
                style="border-radius: 25px;">
                <div class="top-down-grad-light" style="border-radius: 25px;">
                  <div
                    class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                    <div class="col-xlg-2 text-center p-4">
                      <img src="' . $allusers_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail" hidden>
                      ' . $allusers_account_prod_img . '
                    </div>
                    <div class="col-xlg-6 text-center p-4">
                      <h3 class="text-white">' . $allusrs_name . ' ' . $allusrs_surname . '</h3>
                      <p style="font-size: 10px">@' . $allusrs_username . '</p>
                      <p style="font-size: 10px">Level.: 1</p>
                      ' . $allusrs_verification_output . '
                    </div>
                    <div class="col-xlg-4 text-center p-4">
                      <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $allusrs_username . "'" . ')">
                            View profile <i class=" fas fa-chevron-circle-right"></i>
                      </button>
                    </div>
                  </div>
                </div>
          
              </div>
            </div>
            <!-- ./ All Users Card - dark Grad -->';
        }
        //echo $discoverPeopleList;
        //die();

        /* <div class="grid-tile px-2 mx-0 container content-panel-border-style my-4" id="discover_people-' . $allusrs_userid . '-' . $allusrs_username . '">
                <div class="card bg-transparent align-items-center">
                <div class="text-center">
                    <!--<img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">-->
                    ' . $allusers_account_prod_img . '
                </div>
                <div class="card-body">
                    <h3>' . $allusrs_name . ' ' . $allusrs_surname . '</h3>
                    <p>@<span style="color: var(--primary-color)">' . $allusrs_username . '</span></p>
                    <div class="text-center">
                    <button class="null-btn m-4 shadow" onclick="openProfiler(' . "'" . $allusrs_username . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
                    </div>
                </div>
                </div>
            </div> */

        if ($users_exist == true) {
            $output = $discoverPeopleList;
        } else {
            $output = <<<_END
            <div class="text-center" style="padding: 100px 10px;">
                No users available
            </div>
            _END;
        }
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getFitProgramsIndi()
{
    global $dbconn, $indi_programs_progid, $indi_programs_refcode, $indi_programs_title, $indi_programs_description, $indi_programs_duration, $indi_programs_category, $indi_programs_privacy, $indi_programs_creator, $indi_programs_active, $discoverIndiProgramsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //Programs
    //$sql = "SELECT * FROM training_programs tp INNER JOIN program_activities pa ON tp.program_ref_code = pa.program_ref_code;";
    $sql = "SELECT * FROM training_programs;";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `users_username`, `creation_date`, `active` 
            //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
            $indi_programs_progid = $row["program_id"];
            $indi_programs_refcode = $row["program_ref_code"];
            $indi_programs_title = $row["program_title"];
            $indi_programs_description = $row["program_description"];
            $indi_programs_duration = $row["program_duration"];
            $indi_programs_category = $row["program_category"];
            $indi_programs_privacy = $row["program_privacy"];
            $indi_programs_creator = $row["users_username"];
            $indi_programs_active = $row["active"];

            /*$programs_activityid = $row["prog_activity_id"];
            $programs_activitytitle = $row["activity_title"];
            $programs_activityduration = $row["activity_duration"];*/

            $discoverIndiProgramsList .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-' . $indi_programs_progid . '-' . $indi_programs_refcode . '">
                <div class="card bg-transparent">
                    <div class="card-body">
                        <h3 class="card-title">' . $indi_programs_title . ' <span style="font-size: 10px">(' . $indi_programs_privacy . ')</span></h3>
                        <p class="card-subtitle ">Trainer: @' . $indi_programs_creator . '</p>
                        <p class="card-text">' . $indi_programs_description . '</p>
                        <div class="text-center">
                        <button class="null-btn m-4 shadow" onclick="openProgram(' . "'" . $indi_programs_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View program</button>
                        </div>
                    </div>
                </div>
            </div>';
        }

        $output = $discoverIndiProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getFitProgramsTeams()
{
    global $dbconn, $team_programs_progid, $team_programs_refcode, $team_programs_title, $team_programs_description, $team_programs_duration, $team_programs_category, $team_programs_privacy, $team_programs_creator, $team_programs_active, $discoverTeamProgramsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    //Programs
    //$sql = "SELECT * FROM training_programs tp INNER JOIN program_activities pa ON tp.program_ref_code = pa.program_ref_code;";
    $sql = "SELECT * FROM training_programs;";

    if ($result = mysqli_query($dbconn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `users_username`, `creation_date`, `active` 
            //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
            $team_programs_progid = $row["program_id"];
            $team_programs_refcode = $row["program_ref_code"];
            $team_programs_title = $row["program_title"];
            $team_programs_description = $row["program_description"];
            $team_programs_duration = $row["program_duration"];
            $team_programs_category = $row["program_category"];
            $team_programs_privacy = $row["program_privacy"];
            $team_programs_creator = $row["users_username"];
            $team_programs_active = $row["active"];

            /*$programs_activityid = $row["prog_activity_id"];
            $programs_activitytitle = $row["activity_title"];
            $programs_activityduration = $row["activity_duration"];*/

            $discoverTeamProgramsList .= '
            <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-' . $team_programs_progid . '-' . $team_programs_refcode . '">
                <div class="card bg-transparent">
                <div class="card-body">
                    <h3 class="card-title">' . $team_programs_title . ' <span style="font-size: 10px">(' . $team_programs_privacy . ')</span></h3>
                    <p class="card-subtitle ">Trainer: @' . $team_programs_creator . '</p>
                    <p class="card-text">' . $team_programs_description . '</p>
                    <div class="text-center">
                    <button class="null-btn m-4 shadow" onclick="openProgram(' . "'" . $team_programs_refcode . "'" . ')"><i class="fas fa-chevron-circle-right"></i> View program</button>
                    </div>
                </div>
                </div>
            </div>';
        }

        $output = $discoverTeamProgramsList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All Groups) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getAllTrainees()
{
    global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTraineesList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg, $usr_profileid, $usr_about, $usr_profiletype, $usr_profilepicurl, $usr_verification;

    $trainee_userid = null;
    $trainee_username = $trainee_name = $trainee_surname = $trainee_idnumber = $trainee_email = $trainee_contact = $trainee_dob = $trainee_gender = $trainee_race = $trainee_nationality = $trainee_acc_active = $trainee_prof_acctype = "";

    $trainee_profileid = null;
    $trainee_about = $trainee_profiletype = $trainee_profilepicurl = $trainee_verification = $trainee_verification_output = $trainee_img_url = $trainee_account_prod_img = "";

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT * FROM users u INNER JOIN general_user_profiles gup ON u.username = gup.users_username;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $trainee_userid = $row["user_id"];
            $trainee_username = $row["username"];
            $trainee_name = $row["user_name"];
            $trainee_surname = $row["user_surname"];
            $trainee_idnumber = $row["id_number"];
            $trainee_email = $row["user_email"];
            $trainee_contact = $row["contact_number"];
            $trainee_dob = $row["date_of_birth"];
            $trainee_gender = $row["user_gender"];
            $trainee_race = $row["user_race"];
            $trainee_nationality = $row["user_nationality"];
            $trainee_acc_active = $row["account_active"];

            $trainee_profileid = $row["user_profile_id"];
            $trainee_about = $row["about"];
            $trainee_prof_acctype = $row["profile_type"];
            $trainee_profilepicurl = $row["profile_image_url"];
            $trainee_verification = $row["verification"];

            // verification icon
            if ($trainee_verification == "verified") {
                $trainee_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $trainee_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($trainee_profilepicurl == "default" || $trainee_profilepicurl == null || $trainee_profilepicurl == "") {
                $trainee_img_url = "../media/profiles/0_default/default_profile_pic.svg";
            } else {
                $trainee_img_url = "../media/profiles/$trainee_username/$trainee_profilepicurl";
            }

            $trainee_account_prod_img = '<div class="social-update-profile-pic shadow" style="background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important; background-attachment: local !important; height: 150px !important; width:  150px !important; background: url(' . $trainee_img_url . ') !important;"></div>';

            //compile list of trainers
            if ($trainee_prof_acctype == "trainee") {
                $activitiesTraineesList .= '
                <!-- Trainees Card - dark Grad -->
                <div class="grid-tile">
                    <div class="my-4 container-fluid darkpads-bg-container" id="discover_trainee-' . $trainee_userid . '-' . $trainee_username . '" style="border-radius: 25px;">
                        <div class="top-down-grad-light" style="border-radius: 25px;">
                            <div class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                                <div class="col-xlg-2 text-center p-4">
                                    <img src="' . $trainee_img_url . '" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail" hidden>
                                    ' . $trainee_account_prod_img . '
                                </div>
                                <div class="col-xlg-6 text-center p-4">
                                    <h3 class="text-white">' . $trainee_name . ' ' . $trainee_surname . '</h3>
                                    <p style="font-size: 10px">@' . $trainee_username . '</p>
                                    <p style="font-size: 10px">Level.: 1</p>
                                    ' . $trainee_verification_output . '
                                </div>
                                <div class="col-xlg-4 text-center p-4">
                                    <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler(' . "'" . $usrs_username . "'" . ')">
                                        View profile <i class=" fas fa-chevron-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./ Trainees Card - dark Grad -->';
            }
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTraineesList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}
function getAllTrainers()
{
    global $dbconn, $activitiesTrainersList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

    $trainer_adminid = $trainer_profileid = null;
    $trainer_username = $trainer_name = $trainer_surname = $trainer_idnumber = $trainer_email = $trainer_contact = $trainer_dob = $trainer_gender = $trainer_race = $trainer_nationality = $trainer_acc_active = $trainer_prof_acctype = "";

    $trainer_about = $trainer_profiletype = $trainer_profileURL = $trainer_profilepicurl = $trainer_verification = $trainer_img_url = $trainer_account_prod_img = "";

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT adm.admin_id, adm.username, adm.admin_name, adm.admin_surname, adm.contact_number,adm.admin_email, adm.date_of_birth, adm.admin_gender,
    adm_prof.about, adm_prof.profile_type, adm_prof.profile_url, adm_prof.profile_image_url
    FROM administrators adm LEFT JOIN admin_user_profiles adm_prof ON adm_prof.administrators_username = adm.username
    WHERE ADM.account_active = 1 AND adm_prof.verification = 'verif'
    LIMIT 50;";

    if ($result = mysqli_query($dbconn, $sql)) {

        while ($row = mysqli_fetch_assoc($result)) {

            $trainer_adminid = $row["admin_id"];
            $trainer_username = $row["username"];
            $trainer_name = $row["admin_name"];
            $trainer_surname = $row["admin_surname"];
            $trainer_email = $row["admin_email"];
            $trainer_contact = $row["contact_number"];
            $trainer_dob = $row["date_of_birth"];
            $trainer_gender = $row["admin_gender"];

            $trainer_about = $row["about"];
            $trainer_profiletype = $row["profile_type"];
            $trainer_profileURL = $row["profile_url"];
            $trainer_profilepicurl = $row["profile_image_url"];


            // verification icon
            if ($trainer_verification == "verif") {
                $trainer_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> verified_user </span>';
            } else {
                $trainer_verification_output = '<span class="material-icons material-icons-round" style="font-size: 40px !important"> public </span>';
            }

            //profile picture
            if ($trainer_profilepicurl == "default" || $trainer_profilepicurl == null || $trainer_profilepicurl == "url" || $trainer_profilepicurl == "") {
                $trainer_img_url = "../media/profiles/0_default/default_profile_pic.svg";
            } else {
                $trainer_img_url = "../media/profiles/$trainer_username/$trainer_profilepicurl";
            }

            $trainer_account_prod_img = <<<_END
            <div class="social-update-profile-pic shadow" 
                style="background-position: center !important; background-size: cover !important; 
                background-repeat: no-repeat !important; background-attachment: local !important; 
                height: 150px !important; width:  150px !important; 
                background: url($trainer_img_url) !important;">
            </div>
            _END;

            //compile list of trainers
            if ($trainer_prof_acctype == "trainer") {
                $activitiesTrainersList .= <<<_END
                <!-- All Trainers Card - dark Grad -->
                <div class="grid-tile">
                  <div class="my-4 container-fluid darkpads-bg-container" id="discover_trainer-$trainer_adminid-$trainer_username"
                    style="border-radius: 25px;">
                    <div class="top-down-grad-light" style="border-radius: 25px;">
                      <div
                        class="row align-items-center content-panel-border-style bg-transparent left-right-grad-tahiti-mineshaftz left-right-grad-mineshaft">
                        <div class="col-xlg-2 text-center p-4">
                          <img src="$trainer_img_url" class="img-fluid rounded-circle shadow" style="border-radius: 25px;" alt="prof thumbnail" hidden>
                          $trainer_account_prod_img
                        </div>
                        <div class="col-xlg-6 text-center p-4">
                          <h3 class="text-white">$trainer_name $trainer_surname</h3>
                          <p style="font-size: 10px">@$trainer_username</p>
                          <p style="font-size: 10px">Level.: 1*</p>
                          $trainer_verification_output
                        </div>
                        <div class="col-xlg-4 text-center p-4">
                          <button class="onefit-buttons-style-light p-4 my-4 shadow" onclick="openProfiler('$trainer_username')">
                                View profile. <i class=" fas fa-chevron-circle-right"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ./ All Trainers Card - dark Grad -->
                _END;
            }
        }
        //echo $discoverPeopleList;
        //die();

        $output = $activitiesTrainersList;
    } else {
        $output_msg = "|[System Error]|:. [Discover load (All People) - " . mysqli_error($dbconn) . "]";
        $app_err_msg = '<div class="application-error-msg shadow d-grid gap-2"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport(' . "'" . $currentUser_Usrnm . "'" . ',' . "'" . $output_msg . "'" . ')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">' . $output_msg . '</div></div>';
        //exit();

        $output = $app_err_msg;
    }

    return $output;
}

// ******** ./get system/platform data functions ********
// log user activity
function log_activity($usertype, $action_title, $action_description, $affected_table, $record_id, $username)
{

    global $dbconn;

    // $action_title = sanitizeMySQL($dbconn, $action_title);
    // $action_description = sanitizeMySQL($dbconn, $action_description);
    // $affected_table = sanitizeMySQL($dbconn, $affected_table);
    // $record_id = sanitizeMySQL($dbconn, $record_id);
    // $username = sanitizeMySQL($dbconn, $username);

    $datenow = date('Y/m/d h:i:s');

    // $usertype = admin / user
    switch ($usertype) {
        case 'admin':
            # 
            $sql = "INSERT INTO `admin_activity`
            (`admin_activity_id`, `action_title`, `action_description`, `affected_table`, `record_id`, `action_date`, `users_username`) 
            VALUES 
            (null,'$action_title','$action_description','$affected_table','$record_id','$datenow','$username')";
            break;
        case 'user':
            # 
            $sql = "INSERT INTO `user_activity`
            (`user_activity_id`, `action_title`, `action_description`, `affected_table`, `record_id`, `action_date`, `users_username`) 
            VALUES 
            (null,'$action_title','$action_description','$affected_table','$record_id','$datenow','$username')";
            break;

        default:
            return false;
            break;
    }

    if ($result = mysqli_query($dbconn, $sql)) return true;
    else return "Fatal error: " . $dbconn->error; //false;
}

// json encode last error checking function
function jsonEncodeErrorCheck($json_obj_array)
{
    // source: https://www.php.net/manual/en/function.json-last-error.php
    // A valid json string
    // $json[] = '{"Organization": "PHP Documentation Team"}';

    // An invalid json string which will cause an syntax 
    // error, in this case we used ' instead of " for quotation
    // $json[] = "{'Organization': 'PHP Documentation Team'}";


    foreach ($json_obj_array as $string) {
        echo 'Decoding: ' . $string;
        json_decode($string);

        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
                break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                echo ' - Unknown error';
                break;
        }

        echo PHP_EOL;
    }
}

// remember user functions
function onLogin($usernm)
{
    $token = format_uuidv4(generateRandomBytes(128)); // generate a token, should be 128 - 256 bit
    // storeTokenForUser($user, $token);
    $cookie = $usernm . ':' . $token;
    // $mac = hash_hmac('sha256', $cookie, SECRET_KEY);
    // $cookie .= ':' . $mac;
    $expires = time() + 60 * 60 * 24 * 7; // expires in seven days
    setcookie('rememberme', $cookie, $expires, '/'); //cookie is called remeberMe, contains the username:token, expires in 7 days and is accessible from the *entire web server - must evaluate the path*
}

// function storeTokenForUser($user, $token)
// {
//  return false;
// }

function checkAccessToken($username, $token)
{
    global $dbconn;

    try {
        // select a record with a matching username and token, if
        $query = "SELECT * FROM `user_access_tokens` WHERE (`users_username` = '$username' AND `access_token` = '$token')";

        $result = $dbconn->query($query);
        if (!$result) die("Fatal Error");

        $rows = $result->num_rows;

        if ($rows == 0) {
            //there is no result so notify user that the account cannot be found
            // index.php
            return "invalid_token";
        } else {
            for ($j = 0; $j < $rows; ++$j) {
                $row = $result->fetch_array(MYSQLI_ASSOC);

                $_SESSION['currentUserAuth'] = true;
                $_SESSION['currentUserForename'] = $row["user_name"];
                $_SESSION['currentUserSurname'] = $row["user_surname"];
                $_SESSION['currentUserEmail'] = $row["user_email"];
                $_SESSION['currentUserUsername'] = $row["username"];
                // $pwdHash = $row["password_hash"];
            }

            // $result->close();
            $result = null;
            $dbconn->close();

            return true;

            //HASH Bypass - Remove after fixing current password hashes in the db
            //$hashBypass = password_hash($password, PASSWORD_DEFAULT);

            // if (password_verify($password, $pwdHash)) header("Location: ../../../../../app/?userauth=true");
            // else header("Location: ../../../../../index.php?return=mismatch&usrn=$username");
        }
    } catch (\Throwable $th) {
        throw "Excepton Error: $th";
    }
}

function rememberMe()
{
    $cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
    $result = null;
    if ($cookie) {
        // list($user, $token, $mac) = explode(':', $cookie);
        // separate the username and token
        list($usernm, $token) = explode(':', $cookie);
        // check for a valid match from the db (status should be true and expiration date should not exceed )

        // if valid match is found, authorize access to the user using their credentials
        $result = checkAccessToken($usernm, $token);
        if ($result === true) header("Location: ../../app/?userauth=true"); // grant access nav user to main app page

        // if (!hash_equals(hash_hmac('sha256', $usernm . ':' . $token, SECRET_KEY), $mac)) {
        //     return false;
        // }

        // $usertoken = fetchTokenByUserName($user);
        // if (hash_equals($usertoken, $token)) {
        //     logUserIn($user);
        // }
    }
}

// uppercase first letter of each word in string
function ucwords_str($str)
{
    $str = ucwords($str);
    $str = str_replace("_", " ", $str);
    return $str;
}




// ****************************************************************************************************************************************************
// END OF FILE ********************************
// ****************************************************************************************************************************************************




// //Content Load Functions - User Profile
// function getUserChallenges() {
//   $output = "Loading...";

//   return $output;
// }
// function getUserChats() {
//   //messages
//   //$sql = "SELECT * FROM messages msg INNER JOIN users u ON msg.receiver = u.username WHERE msg.sender = '$currentUser_Usrnm';";
//   /*$sql = "SELECT * FROM ((user_conversations uc 
//   INNER JOIN users u ON uc.secondary_user = u.username) 
//   INNER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 
//   WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY ucm.send_date DESC LIMIT 1;";*/
//   $sql = "SELECT * FROM user_conversations uc 
//   INNER JOIN users u ON uc.secondary_user = u.username
//   WHERE uc.primary_user = '$currentUser_Usrnm' ORDER BY uc.conversation_id DESC;";

//   //LEFT OUTER JOIN user_conversation_messages ucm  ON ucm.conversation_id = uc.conversation_id) 

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //ucm: `message_id`, `conversation_id`, `message`, `sender`, `receiver`, `send_date`, `message_read`
//       //uc: `conversation_id`, `primary_user`, `secondary_user`, `conversation_start_date`
//       //$msg_id = $row["message_id"];
      
//       $convo_conversationid = $row["conversation_id"];
//       //$convo_lastmsg = $row["message"];
//       $convo_secondaryuser = $row["secondary_user"];
//       //$convo_lastmsgdate = $row["send_date"];
//       //$convo_msgread = $row["message_read"];

//       $secondaryuser_name = $row["user_name"];
//       $secondaryuser_surname = $row["user_surname"];

//       $communicationUserMessages .= '
//       <li class="list-group-item bg-transparent my-2" id="conversation-'.$convo_conversationid.'">
//         <div class="row align-items-center content-panel-border-style" style="border-radius: 25px 0 25px 25px; overflow: hidden; background: #333">
//           <div class="col-sm-4">
//             <img src="../media/images/fitness/10.jpg" class="img-fluid" alt="" style="border-radius: 25px" />
//           </div>
//           <div class="col-sm py-2">
//             <div class="">'.$secondaryuser_name.' '.$secondaryuser_surname.' <span id="" class="msgr-username-tag">(@'.$convo_secondaryuser.')</span></div>
//           </div>
//           <div class="col-sm-2 py-2 text-center">
//             <button class="null-btn text-white shadow btn-block" onclick="openMessenger('."'".$convo_conversationid."'".', '."'".$currentUser_Usrnm."'".', '."'".$convo_secondaryuser."'".')" style="font-size: large"><i class="fas fa-chevron-right"></i></button>
//           </div>
//         </div>
//       </li>';

//       $output = $communicationUserMessages;
//     }
//   }else{
//     $output_msg = "|[System Error]|:. [Communications load (User conversations list) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow d-block" id="application-error-msg"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();
    
//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserFriends() {
//   //users friends list
//   $sql = "SELECT * FROM friends f INNER JOIN users u ON f.friend_username = u.username WHERE f.username = '$currentUser_Usrnm' AND f.friendship_status = 1";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       $friendid = $row["friend_username"];
//       $friendUsername = $row["friend_username"];

//       $friendName = $row["user_name"];
//       $friendSurname = $row["user_surname"];

//       $profileUserFriendsList .= '
//       <div class="grid-tile px-2 mx-0 container-fluid content-panel-border-style my-4" id="friend-'.$friendid.'-'.$friendUsername.'">
//         <div class="row align-items-center">
//           <div class="col-lg-2 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
//           </div>
//           <div class="col-lg-6 text-center">
//             <h3>'.$friendName.' '.$friendSurname.' <span style="font-size: 10px">@'.$friendUsername.'</span></h3>
//           </div>
//           <div class="col-lg-4 text-center">
//             <button class="null-btn shadow" onclick="openProfiler('."'".$friendUsername."'".')"><i class="fas fa-chevron-circle-right"></i> View profile</button>
//           </div>
//         </div>
//       </div>';
//     }

//     $output = $profileUserFriendsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Users friends) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserGroups() {
//   //groups that the user is a member of
//   $sql = "SELECT * FROM groups g INNER JOIN group_members gm ON  g.group_ref_code = gm.group_ref_code WHERE gm.username = '$currentUser_Usrnm';"; //

//   $groupMemsArray = array();
//   $foundGroup = false;

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       $foundGroup = true;

//       $grps_groupid = $row["group_id"];
//       $grps_refcode = $row["group_ref_code"];

//       $grps_name = $row["group_name"];
//       $grps_description = $row["group_description"];
//       $grps_category = $row["group_category"];
//       $grps_privacy = $row["group_privacy"];
//       $grps_createdby = $row["users_username"];
//       $grps_createdate = $row["creation_date"];

//       $profileUserSubsGroupsList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="group-'.$grps_groupid.'-'.$grps_refcode.'">
//         <div class="row align-items-center">
//           <div class="col-md -4 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
//           </div>
//           <div class="col-md -8">
//             <h3>'.$grps_name.' <span style="font-size: 10px">'.$grps_privacy.'</span></h3>
//             <p><span style="color: var(--primary-color)">'.$grps_description.'</span></p>
//             <p>'.$grps_category.'</p>
//             <button class="null-btn shadow mt-4" onclick="openGroup('."'".$grps_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
//             <p class="text-right" style="font-size: 8px;">'.$grps_createdate.'</p>
//           </div>
//         </div>
//       </div>';

//         $groupMemsArray = $row;
//     }
//     /*echo $discoverGroupsList;
//     echo "<br>";
//     echo "<br>";
//     echo "<br>";
//     echo json_encode($groupMemsArray);
//     die();*/

//     $output = $profileUserSubsGroupsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Users groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserMedia() {
//   //users media items
//   //Get a list of file paths using the glob function.
//   $fileList = glob("../../media/profiles/$currentUser_Usrnm/*");

//   //Loop through the array that glob returned.
//   foreach($fileList as $filename){
//   //Simply print them out onto the screen.
//   //echo $filename, '<br>'; 
//   $profileUserMediaList .= '
//     <div class="grid-tile p-0 mx-0 content-panel-border-style my-4 center-container" style="overflow: hidden; max-height: 200px">
//     <img src="'.$filename.'" class="img-fluidz" alt="media image" style="height: 100%">
//     </div>';
//   }

//   $output = $profileUserMediaList;

//   return $output;
// }
// function getUserNotifications() {
//   //notifications
//   $sql = "SELECT * FROM notifications WHERE notify_user = '$currentUser_Usrnm' ORDER BY users_username DESC";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`notification_id`, `notification_title`, `notification_message`, `notify_user`, `users_username`, `notification_date`, `notification_read`

//       $notif_id = $row["notification_id"];
//       $notif_title = $row["notification_title"];
//       $notif_message = $row["notification_message"];
//       $notif_date = $row["notification_date"];

//       $communicationUserNotifications .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="notifcation-'.$notif_id.'">
//         <h3>'.$notif_title.'</h3>
//         <p><span style="color: var(--primary-color)">'.$notif_message.'</span></p>
//         <p>'.$grps_category.'</p>
//         <p class="text-right" style="font-size: 8px">'.$notif_date.'</p>
//       </div>
//       ';
//     }

//     $output = $communicationUserNotifications;
//   }else{
//     $output_msg = "|[System Error]|:. [Communications load (User notifications) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserPref() {
//   $output = "Loading...";
//   return $output;
// }
// function getUserProgSubs() {
//   //subscriptions (programs)
//   //$sql = "SELECT * FROM training_programs;";
//   $sql = "SELECT ps.prog_subscriber_id, ps.username, ps.program_ref_code, ps.subscribe_date, tp.program_id, tp.program_title, tp.program_description, tp.program_duration, tp.program_category, tp.program_privacy, tp.users_username, tp.active 
//   FROM program_subscribers ps 
//   INNER JOIN training_programs tp ON ps.program_ref_code = tp.program_ref_code 
//   WHERE username = '$currentUser_Usrnm'";

//   if($result = mysqli_query($dbconn,$sql)){
//     while($row = mysqli_fetch_assoc($result)){
//       //TP: `program_id`, `program_ref_code`, `program_title`, `program_description`, `program_duration`, `program_category`, `program_privacy`, `users_username`, `creation_date`, `active` 
//       //PA: `prog_activity_id`, `activity_title`, `activity_description`, `activity_duration`, `activity_reps`, `activity_sets`, `achievement_id`, `program_ref_code`
//       $programs_progid = $row["program_id"];
//       $programs_refcode = $row["program_ref_code"];
//       $programs_title = $row["program_title"];
//       $programs_description = $row["program_description"];
//       $programs_duration = $row["program_duration"];
//       $programs_category = $row["program_category"];
//       $programs_privacy = $row["program_privacy"];
//       $programs_creator = $row["users_username"];
//       $programs_active = $row["active"];

//       /*$programs_activityid = $row["prog_activity_id"];
//       $programs_activitytitle = $row["activity_title"];
//       $programs_activityduration = $row["activity_duration"];*/

//       $profileUsersProgramsList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_programs-'.$programs_progid.'-'.$programs_refcode.'">
//         <div class="card bg-transparent">
//           <div class="card-body">
//             <h3 class="card-title">'.$programs_title.' <span style="font-size: 10px">('.$programs_privacy.')</span></h3>
//             <p class="card-subtitle ">Trainer: @'.$programs_creator.'</p>
//             <p class="card-text">'.$programs_description.'</p>
//             <div class="text-center">
//               <button class="null-btn m-4 shadow" onclick="openProgram('."'".$programs_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> View program</button>
//             </div>
//           </div>
//         </div>
//       </div>';
//     }

//     $output = $profileUsersProgramsList;
//    } else{
//     $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserResources() {
//   //community and resource shares (latest 50 posts each)
//   $sql = "SELECT * FROM community_resources cr INNER JOIN users u ON cr.shared_by = u.username WHERE cr.shared_by = '$currentUser_Usrnm';";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`comm_resource_id`, `resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
//       $usrresources_resourceid = $row["comm_resource_id"];
//       $usrresources_title = $row["resource_title"];
//       $usrresources_description = $row["resource_description"];
//       $usrresources_type = $row["resource_type"];
//       $usrresources_link = $row["resource_link"];
//       $usrresources_sharedate = $row["share_date"];

//       $usrresources_sharename = $row["user_name"];
//       $usrresources_sharesurname = $row["user_surname"];

//       if($usrresources_type == "external link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink('."'".$usrresources_link."'".')"><i class="fas fa-link"></i> Follow link</button>';
//       }else if($usrresources_type == "profile link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'profile'".')"><i class="fas fa-id-badge"></i> View profile</button>';
//       }else if($usrresources_type == "post link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'post'".')"><i class="fas fa-sticky-note"></i> Open post</button>';
//       }else if($usrresources_type == "document link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'document'".')"><i class="fas fa-file-alt"></i> View document</button>';
//       }
//       else if($usrresources_type == "media link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$usrresources_link."'".', '."'media'".')"><i class="fas fa-photo-video"></i> View media</button>';
//       }

//       $profileUsersResourcesList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-'.$usrresources_resourceid.'-'.$currentUser_Usrnm.'" style="max-width: 100%!important">
//         <div>
//           <h3>'.$usrresources_title.' <span style="font-size: 10px">'.$usrresources_type.'</span></h3>
//           <p><span style="color: var(--primary-color)">'.$usrresources_description.'</span></p>
//           <p><i class="fas fa-link"></i> | '.$usrresources_link.'</p>
//           <p>Shared by: @'.$usrresources_type.'</p>

//           '.$openlinkbtn.'

//           <p class="text-right" style="font-size: 8px">'.$usrresources_sharedate.'</p>
//         </div>
//       </div>';
//     }

//     $output = $profileUsersResourcesList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Users posts) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserSaves() {
//   //Favourites
//   $sql = "SELECT * FROM ((fave_saves fs
//   INNER JOIN users u ON fs.username = u.username) 
//   INNER JOIN community_posts cp ON fs.fave_ref = cp.favourite_ref)
//   WHERE fs.username = '$currentUser_Usrnm';";

//   if($result = mysqli_query($dbconn,$sql)){
//     while($row = mysqli_fetch_assoc($result)){
//       $fave_id = $row['fave_id'];
//       $fave_ref = $row['fave_ref'];
//       $fave_date = $row['fave_date'];
//       $post_id = $row['post_id'];
//       $post_date = $row['post_date'];
//       $post_msg = $row['post_message'];
//       $mod_date = $row['modified_date'];

//       $poster_name = $row['user_name'];
//       $poster_surname = $row['user_surname'];
//       $poster_username = $row['username'];

//       $profileUsersFavesList .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="fave-'.$fave_id.'">
//         <div class="row align-items-center p-2">
//           <div class="col-md-4 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
//           </div>
//           <div class="col-md-8">
//             <h3>'.$poster_name.' '.$poster_surname.' <span style="font-size: 10px">@<span style="color: var(--primary-color)">'.$poster_username.'</span></span></h3>
//           </div>
//         </div>
//         <div class="post-content">
//           <hr class="bg-white">

//           <p class="my-2">'.$post_msg.'</p>
//           <p class="text-right" style="font-size: 8px">'.$post_date.'</p>

//           <!--function buttons-->
//           <ul class="list-group list-group-horizontal -sm mt-4">
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//               <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
//             </li>
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//               <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
//             </li>
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//               <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
//             </li>
//             <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
//               <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
//             </li>
//           </ul>
//         </div>
//       </div>';
//     }

//     $output = $profileUsersFavesList;
//   }else{
//     $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getUserSocials() {
//   //get the social details
//   $sql = "SELECT social_network, handle, link FROM user_socials WHERE username = '$currentUser_Usrnm'";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//         //u.user_id, u.username, u.user_name, u.user_surname, u.id_number, u.user_email, u.contact_number, u.date_of_birth, u.user_gender, u.user_race, u.user_nationality, u.account_active
//         $usr_socialnet = $row["social_network"];
//         $usr_socialhandle = $row["handle"];
//         $usr_sociallink = $row["link"];
//         if($usr_socialnet == "facebook"){
//           $socialNetworkIcon = '<i class="fab fa-facebook"></i>';
//         }else if($usr_socialnet == "twitter"){
//           $socialNetworkIcon = '<img class="twitter-x-icon" src="../media/assets/icons/twitter-x-symbol-white.svg" style="height:40px;width:40px" alt="Twitter - X logo">';
//         }else if($usr_socialnet == "instagram"){
//           $socialNetworkIcon = '<i class="fab fa-instagram"></i>';
//         }else if($usr_socialnet == "tumbler"){
//           $socialNetworkIcon = '<i class="fab fa-tumblr"></i>';
//         }else if($usr_socialnet == "whatsapp"){
//           $socialNetworkIcon = '<i class="fab fa-whatsapp"></i>';
//         }else if($usr_socialnet == "reddit"){
//           $socialNetworkIcon = '<i class="fab fa-reddit"></i>';
//         }else{
//           $socialNetworkIcon = '<i class="fas fa-globe-africa"></i>';
//         }

//         $socialItems .= '<li class="list-group-item text-center text-dark bg-transparent rounded-pill shadow my-2 mx-1 social-link"><span class="p-2 mr-2 bg-warning" style="border-radius: 5px">'.$socialNetworkIcon.'</span><a href="'.$usr_sociallink.'">'.$usr_socialhandle.'</a></li>';
//     }
//     //echo $discoverPeopleList;
//     //die();

//     $userSocialItemsList = <<<_END
//     <ul class="list-group list-group-horizontal-sm justify-content-center p-2 shadow" style="border-radius: 25px; background: #333">$socialItems</ul>
//     _END;

//     $output = $userSocialItemsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Profile load (Social details) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     $output = $app_err_msg;
//     //exit();
//   }

//   return $output;
// }
// function getUserUpdates() {
//   $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username WHERE cp.username = '$currentUser_Usrnm';";

//     if($result = mysqli_query($dbconn,$sql)){
      
//       while($row = mysqli_fetch_assoc($result)){
//         //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
//         $usrposts_postid = $row["post_id"];
//         $usrposts_postdate = $row["post_date"];
//         $usrposts_message = $row["post_message"];
//         $usrposts_user = $row["username"];
//         $usrposts_faveref = $row["favourite_ref"];

//         $usrposts_name = $row["user_name"];
//         $usrposts_surname = $row["user_surname"];

//         $profileUsersPostsList .= '
//           <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-'.$usrposts_postid.'-'.$usrposts_user.'">
//             <div class="row align-items-center p-2">
//               <div class="col-md-4 text-center">
//                 '.$accountProdImg.'
//               </div>
//               <div class="col-md-8">
//                 <h3>'.$usrposts_name.' '.$usrposts_surname.' <span style="font-size: 10px">@<span style="color: var(--primary-color)">'.$usrposts_user.'</span></span></h3>
//               </div>
//             </div>
//             <div class="post-content">
//               <hr class="bg-white">

//               <p class="my-2">'.$usrposts_message.'</p>
//               <p class="text-right" style="font-size: 8px">'.$usrposts_postdate.'</p>

//               <!--function buttons-->
//               <ul class="list-group list-group-horizontal -sm mt-4">
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                   <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
//                 </li>
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                   <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
//                 </li>
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                   <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
//                 </li>
//                 <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
//                   <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
//                 </li>
//               </ul>
//             </div>
//           </div>';
//       }

//       $output = $profileUsersPostsList;
//     }else{
//       $output_msg = "|[System Error]|:. [Profile load (Users posts) - ".mysqli_error($dbconn)."]";
//       $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//       //exit();

//       $output = $app_err_msg;
//     }
  
//   return $output;
// }

// //Content Load Functions - Community Content
// function getCommunityGroups() {
//   //groups
//   $sql = "SELECT * FROM groups";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//         //`group_id`, `group_ref_code`, `group_name`, `group_description`, `group_category`, `group_privacy`, `users_username`, `creation_date`
        
//         $grps_groupid = $row["group_id"];
//         $grps_refcode = $row["group_ref_code"];
//         $grps_name = $row["group_name"];
//         $grps_description = $row["group_description"];
//         $grps_category = $row["group_category"];
//         $grps_privacy = $row["group_privacy"];
//         $grps_createdby = $row["users_username"];
//         $grps_createdate = $row["creation_date"];

//         $discoverGroupsList .= '
//         <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="discover_groups-'.$grps_groupid.'-'.$grps_refcode.'">
//           <div class="row align-items-center">
//             <div class="col-md -4 text-center">
//               <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;" alt="prof thumbnail">
//             </div>
//             <div class="col-md -8">
//               <h3>'.$grps_name.' <span style="font-size: 10px">'.$grps_privacy.'</span></h3>
//               <p><span style="color: var(--primary-color)">'.$grps_description.'</span></p>
//               <p>'.$grps_category.'</p>
//               <button class="null-btn shadow mt-4" onclick="openGroup('."'".$grps_refcode."'".')"><i class="fas fa-chevron-circle-right"></i> Open group</button>
//               <p class="text-right" style="font-size: 8px">'.$grps_createdate.'</p>
//             </div>
//           </div>
//         </div>';
//     }
//     //echo $discoverPeopleList;
//     //die();

//     $output = $discoverGroupsList;
//   }else{
//     $output_msg = "|[System Error]|:. [Discover load (All Groups) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }
  
//   return $output;
// }
// function getCommunityNews() {
//   //news
//   $sql = "SELECT * FROM news n INNER JOIN users u ON n.users_username = u.username ORDER BY n.creation_date DESC";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`article_id`, `article_title`, `content`, `users_username`, `creation_date`

//       $news_id = $row["article_id"];
//       $news_title = $row["article_title"];
//       $news_content = $row["content"];
//         $news_createdby = $row["users_username"];
//       $news_date = $row["creation_date"];

//       $news_poster_name = $row["user_name"];
//       $news_poster_surname = $row["user_surname"];

//       $communicationNews .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="news-'.$news_id.'">
//         <h3>'.$news_title.' <span style="font-size: 10px">By '.$news_poster_name.' '.$news_poster_surname.' (@'.$news_createdby.')</span></h3>
//         <p><span style="color: var(--primary-color)">'.$news_content.'</span></p>
//         <p class="text-right" style="font-size: 8px">'.$news_date.'</p>
//       </div>
//       ';
//     }

//     $output = $communicationNews;
//   }else{
//     $output_msg = "|[System Error]|:. [Communications load (User notifications) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow d-block"><h3 class=" d-block" style="color: red">An error has occured</h3><p class=" d-block">It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output d-block" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }
  
//   return $output;
// }
// function getCommunityResources() {
//   //fitness resources (latest 50 resources)
//   $sql = "SELECT * FROM community_resources";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`resource_title`, `resource_description`, `resource_type`, `resource_link`, `shared_by`, `share_date`
//       $resourceid = $row["comm_resource_id"];
//       $resource_title = $row["resource_title"];
//       $resource_descr = $row["resource_description"];
//       $resource_type = $row["resource_type"];
//       $resource_link = $row["resource_link"];
//       $sharedbyUsername = $row["shared_by"];
//       $sharedate = $row["share_date"];

//       if($resource_type == "external link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openExtLink('."'".$resource_link."'".')"><i class="fas fa-link"></i> Follow link</button>';
//       }else if($resource_type == "profile link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'profile'".')"><i class="fas fa-id-badge"></i> View profile</button>';
//       }else if($resource_type == "post link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'post'".')"><i class="fas fa-sticky-note"></i> Open post</button>';
//       }else if($resource_type == "document link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'document'".')"><i class="fas fa-file-alt"></i> View document</button>';
//       }else if($resource_type == "media link"){
//         $openlinkbtn = '<button class="null-btn shadow" type="button" onclick="openIntLink('."'".$resource_link."'".', '."'media'".')"><i class="fas fa-photo-video"></i> View media</button>';
//       }

//       $homeCommunityResources .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="resource-'.$resourceid.'-'.$sharedbyUsername.'">
//         <div class="row align-items-center">
//           <div class="col-md-4 text-center">
//             <img src="../media/assets/One-Symbol-Logo-White.svg" class="img-fluid" style="border-radius: 25px;max-height:100px" alt="prof thumbnail">
//           </div>
//           <div class="col-md-8">
//             <h3>'.$resource_title.' <span style="font-size: 10px">'.$resource_type.'</span></h3>
//             <p><span style="color: var(--primary-color)">'.$resource_descr.'</span></p>
//             <p><i class="fas fa-link"></i> | '.$resource_link.'</p>
//             <p>Shared by: @'.$sharedbyUsername.'</p>

//             '.$openlinkbtn.'

//             <p class="text-right" style="font-size: 8px;">'.$sharedate.'</p>
//           </div>
//         </div>
//       </div>';
//     }
//     //$discoverResourcesList = $homeCommunityResources;
//     $output = $homeCommunityResources;
//   }else{
//     $output_msg = "|[System Error]|:. [Home load (Community resources) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }

//   return $output;
// }
// function getCommunityUpdates() {
//   //community posts (latest 50 posts)
//   $sql = "SELECT * FROM community_posts cp INNER JOIN users u ON cp.username = u.username;";

//   if($result = mysqli_query($dbconn,$sql)){
    
//     while($row = mysqli_fetch_assoc($result)){
//       //`post_id`, `post_date`, `post_message`, `username`, `modified_date`, `favourite_ref`FROM `community_posts` WHERE 
//       $commpost_postid = $row["post_id"];
//       $commpost_postdate = $row["post_date"];
//       $commpost_message = $row["post_message"];
//       $commpost_user = $row["username"];
//       $commpost_faveref = $row["favourite_ref"];

//       $commpost_usr_name = $row["user_name"];
//       $commpost_usr_surname = $row["user_surname"];

//       $homeCommunityPosts .= '
//       <div class="grid-tile px-2 mx-0 content-panel-border-style my-4" id="post-'.$commpost_postid.'-'.$commpost_user.'">
//           <div class="row align-items-center p-2">
//             <div class="col-md-4 text-center">
//               '.$accountProdImg.'
//             </div>
//             <div class="col-md-8">
//               <h3>'.$commpost_usr_name.' '.$commpost_usr_surname.' <span style="font-size: 10px">@<span style="color: var(--primary-color)">'.$commpost_user.'</span></span></h3>
//             </div>
//           </div>
//           <div class="post-content">
//             <hr class="bg-white">

//             <p class="my-2 text-wrap">'.$commpost_message.'</p>
//             <p class="text-right" style="font-size: 8px">'.$commpost_postdate.'</p>

//             <!--function buttons-->
//             <ul class="list-group list-group-horizontal -sm mt-4">
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                 <i class="fas fa-heart"></i> <span class="d-none d-lg-block">Dope</span>
//               </li>
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                 <i class="fas fa-comment-alt"></i> <span class="d-none d-lg-block">Comment</span>
//               </li>
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-2">
//                 <i class="fas fa-share-alt"></i> <span class="d-none d-lg-block">Share</span>
//               </li>
//               <li class="list-group-item text-center flex-fill bg-transparent border-0 py-2 pl-0 pr-0">
//                 <i class="fas fa-bookmark"></i> <span class="d-none d-lg-block">Fave</span>
//               </li>
//             </ul>
//           </div>
//         </div>';
//     }

//     $output = $homeCommunityPosts;
//   }else{
//     $output_msg = "|[System Error]|:. [Home load (Community posts) - ".mysqli_error($dbconn)."]";
//     $app_err_msg = '<div class="application-error-msg shadow"><h3 style="color: red">An error has occured</h3><p>It seems that an error has occured while loading the app. Please try again and if the problem persists, contact <a class="text-decoration-none" onclick="contactSupport('."'".$currentUser_Usrnm."'".','."'".$output_msg."'".')">support</a></p><div class="application-error-msg-output" style="font-size: 10px">'.$output_msg.'</div></div>';
//     //exit();

//     $output = $app_err_msg;
//   }
  
//   return $output;
// }