<?php
// include mysql database configuration file
// code sourced from: https://www.tutsmake.com/import-csv-file-into-mysql-using-php/
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// 
if (!isset($_GET['giveme'])) $requestfor = "";
else $requestfor = sanitizeMySQL($dbconn, $_GET['giveme']);

if (!isset($_GET['content'])) die("error: content requested not defined");
else $contentRequested = sanitizeMySQL($dbconn, $_GET['content']);

$compile = $output = null;

function get_fitness_categories($req)
{
    global $dbconn, $compile, $output;

    $category_class_id =
        $category_class_code =
        $category_class_name = null;

    try {
        // limit to 100 records
        $query = "SELECT * FROM `category_class` LIMIT 100";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /* category_class_id, 
            category_class_code, 
            category_class_name */

            $category_class_id = $row["category_class_id"];
            $category_class_code =  $row["category_class_name"];
            $category_class_name  = $row["category_class_name"];

            $compile .= <<<_END
            <tr>
                <td> $category_class_id </td>
                <td> $category_class_code </td>
                <td> $category_class_name </td>
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

function get_workouts($req)
{
    global $dbconn, $compile, $output;

    $workout_id =
        $workout_name =
        $workout_description =
        $goal_definition =
        $total_xp_points =
        $premium =
        $category_class_category_class_code  = null;

    try {
        // limit to 10 records
        $query = "SELECT * FROM `workouts` LIMIT 10";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /* workout_id, 
            workout_name, 
            workout_description, 
            goal_definition, 
            total_xp_points, 
            premium, 
            category_class_category_class_code */

            $workout_id =  $row["workout_id"];
            $workout_name =  $row["workout_name"];
            $workout_description =  $row["workout_description"];
            $goal_definition =  $row["goal_definition"];
            $total_xp_points =  $row["total_xp_points"];
            $premium =  $row["premium"];
            $category_class_category_class_code = $row["category_class_category_class_code"];

            $compile .= <<<_END
            <tr>
                <td> $workout_id </td> 
                <td> $workout_name </td> 
                <td> $workout_description </td> 
                <td> $goal_definition </td> 
                <td> $total_xp_points </td> 
                <td> $premium </td> 
                <td> $category_class_category_class_code </td>
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

function get_exercises($req)
{
    global $dbconn, $compile, $output;

    $exercise_id =
        $exercise_name =
        $instructions =
        $guidelines =
        $sets =
        $reps =
        $rests =
        $xp_points =
        $training_phase  = null;

    try {
        // limit to 100 records
        $query = "SELECT * FROM `exercises` LIMIT 10";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /*exercise_id, 
            exercise_name, 
            instructions, 
            guidelines, 
            sets, 
            reps, 
            rests, 
            xp_points, 
            training_phase */

            $exercise_id = $row["exercise_id"];
            $exercise_name = $row["exercise_name"];
            $instructions = $row["instructions"];
            $guidelines = $row["guidelines"];
            $sets = $row["sets"];
            $reps = $row["reps"];
            $rests = $row["rests"];
            $xp_points = $row["xp_points"];
            $training_phase = $row["training_phase"];

            $compile .= <<<_END
            <tr>
                <td> $exercise_id </td> 
                <td> $exercise_name </td> 
                <td> $instructions </td> 
                <td> $guidelines </td> 
                <td> $sets </td> 
                <td> $reps </td> 
                <td> $rests </td> 
                <td> $xp_points </td> 
                <td> $training_phase </td> 
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

function get_training_drills($req)
{
    global $dbconn, $compile, $output;

    $exercise_drill_id =
        $sport =
        $drill_title =
        $thumbnail =
        $drill_demo_vid =
        $training_level =
        $target_area =
        $benefits =
        $instructions =
        $administrators_username = null;

    try {
        // limit to 100 records
        $query = "SELECT * FROM `exercise_drills` LIMIT 10";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /*exercise_drill_id, 
            sport, 
            drill_title, 
            thumbnail, 
            drill_demo_vid, 
            training_level, 
            target_area, 
            benefits, 
            instructions, 
            administrators_username*/

            $exercise_drill_id = $row["exercise_drill_id"];
            $sport = $row["sport"];
            $drill_title = $row["drill_title"];
            $thumbnail = $row["thumbnail"];
            $drill_demo_vid = $row["drill_demo_vid"];
            $training_level = $row["training_level"];
            $target_area = $row["target_area"];
            $benefits = $row["benefits"];
            $instructions = $row["instructions"];
            $administrators_username = $row["administrators_username"];

            $compile .= <<<_END
            <tr>
                <td> $exercise_drill_id </td>  
                <td> $sport </td>  
                <td> $drill_title </td>  
                <td> $thumbnail </td>  
                <td> $drill_demo_vid </td>  
                <td> $training_level </td>  
                <td> $target_area </td>  
                <td> $benefits </td>  
                <td> $instructions </td>  
                <td> $administrators_username </td>  
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

function get_supplements($req)
{
    global $dbconn, $compile, $output;

    $supplements_id =
        $category_tags =
        $supplement_type =
        $description =
        $recommended_dosage =
        $source = null;

    try {
        // limit to 100 records
        $query = "SELECT * FROM `supplements_list` LIMIT 10";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /*supplements_id, 
            category_tags, 
            supplement_type, 
            description, 
            recommended_dosage, 
            source*/

            $supplements_id = $row["supplements_id"];
            $category_tags = $row["category_tags"];
            $supplement_type = $row["supplement_type"];
            $description = $row["description"];
            $recommended_dosage = $row["recommended_dosage"];
            $source = $row["source"];

            $compile .= <<<_END
            <tr>
                <td> $supplements_id </td>
                <td> $category_tags </td>
                <td> $supplement_type </td>
                <td> $description </td>
                <td> $recommended_dosage </td>
                <td> $source </td>
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

function get_sports($req)
{
    global $dbconn, $compile, $output;

    $sport_id =
        $category =
        $name =
        $administrators_username = null;

    try {
        // limit to 100 records
        $query = "SELECT * FROM `sports_list` LIMIT 10";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /*sport_id, 
            category, 
            name, 
            administrators_username*/

            $sport_id = $row["sport_id"];
            $category = $row["category"];
            $name = $row["name"];
            $administrators_username = $row["administrators_username"];

            $compile .= <<<_END
            <tr>
                <td> $sport_id </td>
                <td> $category </td>
                <td> $name </td>
                <td> $administrators_username </td>
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

function get_muscle_groups($req)
{
    global $dbconn, $compile, $output;

    $muscle_group_id =
        $major_muscle_group =
        $sub_muscle_group =
        $position_definition = null;

    try {
        // limit to 100 records
        $query = "SELECT * FROM `muscle_groups` LIMIT 100";

        $result = $dbconn->query($query);

        if (!$result) return false;

        $rows = $result->num_rows;

        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            /*muscle_group_id, 
            major_muscle_group, 
            sub_muscle_group, 
            position_definition*/

            $muscle_group_id = $row["muscle_group_id"];
            $major_muscle_group = $row["major_muscle_group"];
            $sub_muscle_group = $row["sub_muscle_group"];
            $position_definition = $row["position_definition"];

            $compile .= <<<_END
            <tr>
                <td> $muscle_group_id </td>
                <td> $major_muscle_group </td>
                <td> $sub_muscle_group </td>
                <td> $position_definition </td>
            </tr>
            _END;
        }

        if ($req == 'ui_data') {
            $output = $compile;
            return $output;
        } elseif ($req == 'json') {
            $output = $row;
            return json_encode($output);
        }
    } catch (\Throwable $th) {
        return "Exeption error occured: " . $th->getMessage();
    }
}

switch ($contentRequested) {
    case 'fitness_categies':
        # code...
        $returned = get_fitness_categories($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;
    case 'workouts':
        # code...
        $returned = get_workouts($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;
    case 'exercises':
        # code...
        $returned = get_exercises($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;
    case 'training_drills':
        # code...
        $returned = get_training_drills($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;
    case 'supplements':
        # code...
        $returned = get_supplements($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;
    case 'sports':
        # code...
        $returned = get_sports($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;
    case 'muscle_groups':
        # code...
        $returned = get_muscle_groups($requestfor);
        if ($returned === false || strpos($returned, "exception") || strpos($returned, "error")) die("error: coudld not get requested data for $contentRequested");
        else echo $returned;
        break;

    default:
        die("error: content requested not defined");
        break;
}
