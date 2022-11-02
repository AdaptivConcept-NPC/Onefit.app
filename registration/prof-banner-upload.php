<?php
session_start();
require("../scripts/php/config.php");
require('../scripts/php/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $uploaddir = "upload/profile_banner/";
        $default_filname_str = "../media/profiles/0_default/default_profile_banner.png";

        $target_file = basename($_FILES["profbannerformFileLg"]["name"]);

        // Extract the file extension
        $imageFileType = strtolower(
            pathinfo($target_file, PATHINFO_EXTENSION)
        );

        // Make an array of allowed extensions
        $extensions = array("jpeg", "jpg", "png", "gif", "webp");

        // Check that extension is present in the array or not
        if (in_array($imageFileType, $extensions) === true) {
            $datenow = date("Ymd-h-i-s");
            $rand = generateAlphaNumericRandomString(50); // rand();
            $n = $uploaddir . $rand . "_$datenow.$imageFileType";
            move_uploaded_file($_FILES['profbannerformFileLg']['tmp_name'], $n);
            echo "success: [$n]";
        } else {
            echo "error: File type not allowed.";
        }

        // reference: https://www.geeksforgeeks.org/why-would-_files-be-empty-when-uploading-files-to-php/
    } catch (\Throwable $th) {
        // exception - throw $th;
        echo "exception Error: Failed to upload Profile Image: " . $th;
    }
} else {
    echo "error: (REQUEST_METHOD) - no Post received.";
}
