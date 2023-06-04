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
$fields = array();
$type = array();
$isNull = array();
while ($row = $result->fetch_assoc()) {
    $fields[] = $row['Field'];
    $type[] = $row['Type'];
    $isNull[] = $row['Null'];
}

print_r($fields);
echo "<br/>";
print_r($type);
echo "<br/>";
print_r($isNull);
echo "<br/>";
echo "<br/>";

?>

<form id="generate-form" type="POST">
    <?php foreach ($fields as $field) : ?>
        <label>
            <?php echo "$field: "; ?>
            <input type="text" name="<?php echo $field; ?>" />
        </label><br />
    <?php endforeach; ?>
    <input type="submit" name="submit" />
</form>