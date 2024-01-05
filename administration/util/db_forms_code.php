<?php
// sources: https://stackoverflow.com/questions/25759056/creating-an-html-form-depending-on-database-fields
// https://dev.mysql.com/doc/refman/8.0/en/describe.html
// https://dev.mysql.com/doc/refman/8.0/en/explain.html ***

require("../scripts/php/admin_config.php");
require('../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error: db connection error");

if (!isset($_GET['req'])) die("Please provide a database name using url parameter: req (js/form)");
else $requesting = sanitizeMySQL($dbconn, $_GET['req']);

$jquery_submit = $tblname = $jquery_submit_script = null;

$fields =
    $type =
    $isNull =
    $default =
    $extraInfo = array();

try {
    // get all table names from our db
    $query = "SHOW tables";

    $result = $dbconn->query($query);
    if (!$result) die("Fatal error occured while executing query." . $dbconn->error);

    $rows = $result->num_rows;

    $list_compile
        = $table_name
        = $table_name_text = null;

    if ($rows == 0) {
        //there is no result die and return with the response
        die("No tables found.");
    } else {
        $jquery_submit_script = "<!-- custom js -->\n";
        $compileForm = "<!-- custom html forms -->\n";
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            // echo print_r($row);
            $table_name = $row['Tables_in_adaptivc_onefit_db'];
            $table_name_text = ucfirst(str_replace("_", " ", $table_name));
            // echo $table_name; // 'Tables_in_adaptivc_onefit_db'
            // echo "<br/>";

            $jquery_submit_script .= <<<_JQuery
            $("#$table_name-form").on("submit", function (e) {
                e = e || window.event;
                e.preventDefault();
                var form_data = new FormData($('#$table_name-form')[0]);
                setTimeout(function () {
                    $.ajax({
                        type: 'POST',
                        url: 'scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=$table_name',
                        processData: false,
                        contentType: false,
                        async: false,
                        cache: false,
                        data: form_data,
                        contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
                        beforeSend: function () {
                            console.log('beforeSend: submitting $table_name-form');
                        },
                        success: function (response) {
                            if (response.startsWith("success")) {
                                console.log('success: returning response - submitted $table_name-form successfully');
                                console.log("Response: \n" + response);
                                /* pass success message output to ui */
                                $("#$table_name-form > #form-output-message").html("Bulk data submitted successfully.");
                                /* toggle alert classes */
                                $("#$table_name-form > #form-output-message").show();
                                $("#$table_name-form > #form-output-message").removeClass("alert-info");
                                $("#$table_name-form > #form-output-message").addClass("alert-success");
                            } else {
                                console.log("error: returning response - an error occurred");
                                console.log("Response: \n" + response);
                                /* pass error message output to ui */
                                $("#$table_name-form > #form-output-message").html("An error occured whilst processing your request. \n\n" + response);
                                /* toggle alert classes */
                                $("#$table_name-form > #form-output-message").show();
                                $("#$table_name-form > #form-output-message").removeClass("alert-info");
                                $("#$table_name-form > #form-output-message").addClass("alert-danger");
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }, 1000);
                e.stopImmediatePropagation();
                return false;
            });
            <br/>
            _JQuery;

            $returned = getDBTable($dbconn, $table_name);

            $list_compile .= <<<_END
            // $table_name <br/>
            $returned
            _END;
        }

        switch ($requesting) {
            case 'js':
                # compile js submit form script
                $html = <<<_END
                // script>
                $jquery_submit_script        
                // /script>
                <br/>
                _END;
                break;
            case 'form':
                # copile html form
                $html = <<<_END
                $list_compile
                <br/>
                _END;
                break;

            default:
                # compile both js script and html forms
                $html = <<<_END
                // script>
                $jquery_submit_script        
                // /script>
                <br/>
                $list_compile
                _END;
                break;
        }

        echo $html;
    }

    $result = null;
    $dbconn->close();
} catch (\Throwable $th) {
    throw "Exception error: " . $th;
}

function getDBTable($dbconn, $tblname)
{
    global $fields, $type, $isNull, $default, $extraInfo;
    $compileForm = $fieldName = $visibilityState = $requiredAttribute = $inputType = $defaultValue = $defaultValueString = $maxLength = null;

    if (!isset($tblname)) die("Please provide a database name using url parameter: tblname");

    $query = "DESCRIBE `$tblname`";

    $result = $dbconn->query($query);
    while ($row = $result->fetch_assoc()) {
        $fields[] = $row['Field'];
        $type[] = $row['Type'];
        $isNull[] = $row['Null'];
        $default[] = $row['Default'];
        $extraInfo[] = $row['Extra'];
    }

    foreach ($fields as $key => $field) {
        # code...
        $fieldName = ucfirst(str_replace("_", " ", $field));
        $inputType = $type[$key];
        $requiredAttribute = $isNull[$key];
        $defaultValue = $default[$key];
        $autoIncrement = $extraInfo[$key];

        switch ($inputType) {
            case strpos($inputType, 'varchar'):
                # set input type to text and then set the max length
                $maxLength = get_string_between($inputType, "(", ")");
                $maxLength = <<<_END
            maxlength="$maxLength"
            _END;
                $inputType = "text";
                break;
            case strpos($inputType, 'text'):
                # set input type to text and then set the max length
                $maxLength = get_string_between($inputType, "(", ")");
                $maxLength = <<<_END
            maxlength="$maxLength" 
            _END;
                $inputType = "text";
                break;
            case strpos($inputType, 'int'):
                # set input type to text and then set the max length
                $maxLength = get_string_between($inputType, "(", ")");
                $maxLength = <<<_END
            maxlength="$maxLength" 
            _END;

                $inputType = "number";
                break;
            case strpos($inputType, 'tinyint'):
                # set input type to text and then set the max length
                $maxLength = get_string_between($inputType, "(", ")");
                $maxLength = <<<_END
            maxlength="$maxLength" 
            _END;
                $inputType = "number";
                break;
            case strpos($inputType, 'float'):
                # set input type to text and then set the max length
                $maxLength = get_string_between($inputType, "(", ")");
                $maxLength = <<<_END
            maxlength="$maxLength" 
            _END;
                $inputType = "number";
                break;

            default:
                # set input type to text and then set the max length
                $maxLength = get_string_between($inputType, "(", ")");
                $maxLength = 'maxlength="255"';
                $inputType = "text";
                break;
        }

        if ($requiredAttribute == "YES") {
            $requiredAttribute = "required";
        }

        if ($defaultValue != "") {
            $defaultValueString = $defaultValue;
        }

        if ($autoIncrement == "auto_increment") {
            $visibilityState = "hidden";
            $defaultValueString = "null";
        }

        $compileForm .= <<<_END
        <div class="form-group my-4">
            <label for="$field" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);" $visibilityState> $fieldName: </label>
            <input class="form-control-text-input p-4" type="$inputType" name="$field" id="$field" $maxLength value="$defaultValueString" placeholder="$fieldName" $requiredAttribute $visibilityState>
        </div>
        _END;

        // reset variables for next iteration
        $visibilityState = $requiredAttribute = $inputType = $defaultValue = $defaultValueString = $maxLength = null;
    }

    return <<<_OUTPUT
    <form id="$tblname-form" method="post" class="container p-4 gap-2">
        <div id="form-output-message"></div>
        $compileForm
        <div class="d-grid">
            <input class="onefit-buttons-style-tahiti p-4" type="submit" name="Save." />
        </div>
    </form>
    <br/>
    _OUTPUT;
}


?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DB Tables JQuery and HTML Forms</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="../css/form_style.css">
</head>

<body>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <?php
    echo $html;
    ?>

    <div class="table-info-arrays">
        <button class="navbar-toggler onefit-buttons-style-light p-4 d-grid gap-2 shadow collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dataArrays" aria-controls="dataArrays" aria-expanded="false" aria-label="Toggle dataArrays">
            <!-- <span class="navbar-toggler-icon"></span> -->
            <span class="material-icons material-icons-round">
                query_stats
            </span>
            <span class="comfortaa-font" style="font-size: 10px!important;">
                View Data Array.
            </span>
        </button>
        <div class="collapse p-4" id="dataArrays">
            <?php
            print_r($fields);
            echo "Fields. <br/><br/>";
            print_r($type);
            echo "Data Types. <br/><br/>";
            print_r($isNull);
            echo "Is Null?. <br/><br/>";
            print_r($extraInfo);
            echo "Extra Info. <br/><br/>";
            ?>
        </div>
    </div>

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>