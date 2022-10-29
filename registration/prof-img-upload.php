<?php
try {
    $uploaddir = "upload/";

    $files = $_FILES['profpicformFileLg'];

    $data = array();
    //check with your logic
    if (isset($_FILES)) {
        $error = false;
        $files = array();

        $rand = rand();

        foreach ($_FILES as $file) {
            if (move_uploaded_file($file['tmp_name'], $uploaddir . $rand  . basename($file['name']))) {
                $files[] = $uploaddir . $file['name'];
                $file_name = $rand . $file['name'];
            } else {
                $error = true;
            }
        }
        $data = ($error) ? array('error' => 'There was an error uploading your profile image.') : array('files' => $files);
        echo json_encode($data);
    } else {
        $data = array('success' => 'NO FILES ARE SENT', 'formData' => $_REQUEST);
        echo json_encode($data);
    }

    /*
        You can also print the errors in json format using json_encode($data)

        https://solvetechy.com/upload-files-using-ajax-php/
    */

    // $name = $_POST[$_FILES['filename']['name']];

    // switch ($_FILES['filename']['type']) {
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
    //     echo "success [$n]";
    // } else {
    //     echo "Error: File type not allowed.";
    // }
} catch (\Throwable $th) {
    //throw $th;
    echo "Exception Error: Failed to upload Profile Image: " . $th;
}
