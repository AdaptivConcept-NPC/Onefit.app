<?php
session_start();
require("../admin_config.php");
require('../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

// format: default, table, options, json
if (isset($_GET['format'])) $format = $_GET['format'];
else die("No format provided");

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
        for ($j = 0; $j < $rows; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            // echo print_r($row);
            $table_name = $row['Tables_in_adaptivc_onefit_db'];
            $table_name_text = ucfirst(str_replace("_", " ", $table_name));
            // echo $table_name; // 'Tables_in_adaptivc_onefit_db'
            // echo "<br/>";

            switch ($format) {
                case 'table':
                    # compile table row
                    $list_compile .= <<<_END
                    <tr><td>$table_name</td></tr>
                    _END;
                    break;
                case 'options':
                    # compile select>options items
                    $list_compile .= <<<_END
                    <option value="$table_name">$table_name_text</option>
                    _END;
                    break;
                case 'json':
                    # return result as json / array
                    $list_compile = json_encode($row, JSON_PRETTY_PRINT);
                    break;

                default:
                    # return result as json / array
                    $list_compile = json_encode($row, JSON_PRETTY_PRINT);
                    break;
            }
        }

        echo $list_compile;
    }

    $result = null;
    $dbconn->close();
} catch (\Throwable $th) {
    throw "Exception error: " . $th;
}
