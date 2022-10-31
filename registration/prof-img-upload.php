<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $uploaddir = "upload/";
        $filname_str = "../media/profiles/0_default/default_profile_pic.png";

        // another method
        // foreach ($_FILES["profpicformFileLg"]["error"] as $key => $error) {
        //     if ($error == UPLOAD_ERR_OK) {
        //         $name = $_FILES["profpicformFileLg"]["name"][$key];
        //         move_uploaded_file($_FILES["profpicformFileLg"]["tmp_name"][$key], $uploaddir . $_FILES['profpicformFileLg']['name'][$key]);

        //         // echo the success output
        //         $filname_str = $uploaddir . $_FILES['profpicformFileLg']['name'][$key];
        //     }
        // }

        // echo "success: [$filname_str]";

        // https://www.edureka.co/blog/upload-file-in-ajax

        // $data = array();
        // //check with your logic
        // if (isset($_FILES)) {
        //     $error = false;
        //     $files = array();

        //     $rand = rand();

        //     foreach ($_FILES as $file) {
        //         if (move_uploaded_file($file['tmp_name'], $uploaddir . $rand  . basename($file['name']))) {
        //             $files[] = $uploaddir . $file['name'];
        //             $file_name = $rand . $file['name'];
        //         } else {
        //             $error = true;
        //         }
        //     }
        //     $data = ($error) ? array('error' => 'There was an error uploading your profile image.') : array('files' => $files);
        //     echo json_encode($data);
        // } else {
        //     $data = array('success' => 'NO FILES ARE SENT', 'formData' => $_REQUEST);
        //     echo json_encode($data);
        // }

        /*
        You can also print the errors in json format using json_encode($data)

        https://solvetechy.com/upload-files-using-ajax-php/
    */

        // $name = $_FILES['profpicformFileLg']['name'];

        // $type = $_FILES['profpicformFileLg']['type'];

        // die("Output: Name($name) Type($type)");

        $target_file = basename($_FILES["profpicformFileLg"]["name"]);

        // Extract the file extension
        $imageFileType = strtolower(
            pathinfo($target_file, PATHINFO_EXTENSION)
        );

        // Make an array of allowed extensions
        $extensions = array("jpeg", "jpg", "png", "gif", "webp");

        // Check that extension is present in the array or not
        if (in_array($imageFileType, $extensions) === true) {
            $datenow = date("Ymd");
            $rand = rand();
            $n = $uploaddir . $rand . "user_prof_img_$datenow.$imageFileType";
            move_uploaded_file($_FILES['profpicformFileLg']['tmp_name'], $n);
            echo "success: [$n]";
        } else {
            echo "error: File type not allowed.";
            // exit;
        }

        // switch ($_FILES['profpicformFileLg']['type']) {
        //     case 'image/jpeg':
        //         $ext = 'jpg';
        //         break;
        //     case 'image/gif':
        //         $ext = 'gif';
        //         break;
        //     case 'image/png':
        //         $ext = 'png';
        //         break;
        //     case 'image/tiff':
        //         $ext = 'tif';
        //         break;
        //     case 'image/webp':
        //         $ext = 'webp';
        //         break;
        //     default:
        //         $ext = '';
        //         break;
        // }

        // if ($ext) {
        //     $datenow = date("Ymd");
        //     $n = $uploaddir . "user_prof_img_ud$datenow.$ext";
        //     move_uploaded_file($_FILES['filename']['tmp_name'], $n);
        //     echo "success: [$n]";
        // } else {
        //     echo "Error: File type not allowed.";
        // }
    } catch (\Throwable $th) {
        //throw $th;
        echo "Exception Error: Failed to upload Profile Image: " . $th;
    }
} else {
    echo "REQUEST_METHOD Error: no post received.";
}
