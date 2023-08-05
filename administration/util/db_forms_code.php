<?php
// sources: https://stackoverflow.com/questions/25759056/creating-an-html-form-depending-on-database-fields
// https://dev.mysql.com/doc/refman/8.0/en/describe.html
// https://dev.mysql.com/doc/refman/8.0/en/explain.html ***

require("../scripts/php/admin_config.php");
require('../scripts/php/functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error: db connection error");

if (!isset($_GET['tblname'])) die("Please provide a database name using url parameter: tblname");
else $tblname = sanitizeMySQL($dbconn, $_GET['tblname']);

$query = "DESCRIBE `$tblname`";

$result = $dbconn->query($query);
$fields =
    $type =
    $isNull =
    $default =
    $extraInfo = array();

while ($row = $result->fetch_assoc()) {
    $fields[] = $row['Field'];
    $type[] = $row['Type'];
    $isNull[] = $row['Null'];
    $default[] = $row['Default'];
    $extraInfo[] = $row['Extra'];
}

$compile = $jquery_submit = $fieldName = $visibilityState = $requiredAttribute = $inputType = $defaultValue = $defaultValueString = $maxLength = null;

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

    $jquery_submit = <<<_JQuery
    <script>
        $("#$tblname-form").submit(function (e) {
            e = e || window.event;
            e.preventDefault();
            e.stopImmediatePropagation();
            var form_data = new FormData($('#$tblname-form')[0]);
            setTimeout(function () {
                $.ajax({
                    type: 'POST',
                    url: 'scripts/php/database/dynamic_dbtable_insert.php?tblsubmit=$tblname',
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    data: form_data,
                    contentType: false /* "multipart/form-data" */ /* "application/json; charset=utf-8" */,
                    beforeSend: function () {
                        console.log('beforeSend: submitting $tblname-form');
                    },
                    success: function (response) {
                        if (response.startsWith("success")) {
                            console.log('success: returning response - submitted $tblname-form successfully');
                            console.log("Response: \n" + response);
                            // pass success message output to ui
                            $("#$tblname-form > #form-output-message").html("Bulk data submitted successfully.");
                            // toggle alert classes
                            $("#$tblname-form > #form-output-message").show();
                            $("#$tblname-form > #form-output-message").removeClass("alert-info");
                            $("#$tblname-form > #form-output-message").addClass("alert-success");
                        } else {
                            console.log("error: returning response - an error occurred");
                            console.log("Response: \n" + response);
                            // pass error message output to ui
                            $("#$tblname-form > #form-output-message").html("An error occured whilst processing your request. \n\n" + response);
                            // toggle alert classes
                            $("#$tblname-form > #form-output-message").show();
                            $("#$tblname-form > #form-output-message").removeClass("alert-info");
                            $("#$tblname-form > #form-output-message").addClass("alert-danger");
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log("exception error: " + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }, 1000);
        });
    </script>
    _JQuery;

    $compile .= <<<_END
    <div class="form-group my-4">
        <label for="$field" class="poppins-font fs-4 mb-4" style="color: #ffa500;" $visibilityState> $fieldName: </label>
        <input class="form-control-text-input p-4" type="$inputType" name="$field" id="$field" $maxLength value="$defaultValueString" placeholder="$fieldName" $requiredAttribute $visibilityState>
    </div>
    _END;

    // reset variables for next iteration
    $visibilityState = $requiredAttribute = $inputType = $defaultValue = $defaultValueString = $maxLength = null;
}

?>

<!-- custom css -->
<link rel="stylesheet" href="../css/form_style.css">

<?php echo $jquery_submit; ?>
<form id="<?php echo $tblname; ?>-form" method="post" class="container p-4 gap-2">
    <div id="form-output-message"></div>
    <?php echo $compile; ?>

    <div class="d-grid">
        <input class="onefit-buttons-style-tahiti p-4" type="submit" name="Save." />
    </div>
</form>

<button class="navbar-toggler onefit-buttons-style-light p-4 d-grid gap-2 shadow collapsed" type="button"
    data-bs-toggle="collapse" data-bs-target="#dataArrays" aria-controls="dataArrays" aria-expanded="false"
    aria-label="Toggle dataArrays">
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

<!-- 
<php foreach ($fields as $key => $field) : ?>
        <label>
            <php echo "$field: "; ?>
            <input type="text" name="<php echo $field; ?>" />
        </label><br />
    < endforeach; ?>
    <input type="submit" name="submit" />
 -->