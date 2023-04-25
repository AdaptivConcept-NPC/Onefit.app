<?php
session_start();
require("../../../functions.php");

if (!isset($_GET['dir'])) die("No directory specified.");

$requestDir = $_GET['dir'];
$output = $gridContainerItems = null;

if (!isset($_SESSION['currentUserUsername'])) die("Fatal Error");
else $current_user_username = $_SESSION['currentUserUsername'];

// function to list the files and sub-directories in a specified root directory
function listDirectory($path)
{
    global $output, $gridContainerItems, $current_user_username;
    $items = scandir("../../../../" . $path);

    foreach ($items as $item) {

        // Ignore the . and .. folders
        if ($item != "." and $item != "..") {
            if (is_file("../../../../" . $path . $item)) {
                // this is the file
                // echo "-> " . $item . "<br>";
                $fullPath = $path . $item;

                $gridContainerItems .= <<<_END
                <div class="grid-tile" style="background-color: #343434;>
                    <div class="media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" 
                    style="border-radius:25px;overflow:hidden;">
                        <img src="$fullPath" class="img-fluid" style="max-height: 30vh;border-radius:25px;" alt="$current_user_username's media - $item" />
                        <button class="onefit-buttons-style-tahiti p-3 d-grid" onclick="viewMedia('image','$fullPath')">
                            <span class="material-icons material-icons-round align-middle"
                                style="font-size: 20px !important;">
                                open_in_new
                            </span>
                            <span class="align-middle" style="font-size: 10px !important;">View.</span>
                        </button>
                        <!-- media info collapse btn -->
                        <a style="text-decoration: none;color: #ffa500 !important;" data-bs-toggle="collapse"
                            href="#friend-card-info-userid" role="button" aria-expanded="false"
                            aria-controls="friend-card-info-userid" class="collapsed">
                            <span class="material-icons material-icons-round align-middle text-white"
                                style="font-size: 20px !important;">
                                info
                            </span>
                            <span class="align-middle text-white">info.</span>
                        </a>
                        <!-- ./ media info collapse btn -->
                        <!-- media info collapse -->
                        <span id="friend-card-info-userid" class="collapse p-1 shadow w3-animate-bottom"
                            style="background-color: rgb(52, 52, 52, 0.5);">
                            Users
                            biography here.media info here.Users
                            biography here.media info here.
                        </span>
                        <!-- media info collapse -->
                    </div>
                    <div id="media-info-container">
                        <!-- display user like, save and  -->
                        <div class="">
                            
                        </div>
                    </div>
                </div>
                _END;
            } else {
                // this is the directory

                // do the list it again!
                // echo "---> " . $item;
                $gridContainerItems .= <<<_END
                <div class="grid-tile media-item-tile p-2 mx-0 center-container shadow d-flex align-items-center justify-content-center border border-5" style="background-color: #343434;">
                    <h1 class="text-center d-grid gap-2 fs-1">
                        <span class="material-icons material-icons-round align-middle" style="color: #ffa500; font-size: 60px !important">
                            topic
                        </span>
                        <span class="align-middle w-100 text-truncate text-white">$item</span>
                    </h1>
                </div>
                _END;
                // echo "<div style='padding-left: 10px'>";
                listDirectory($path . $item . "/");
                // echo "</div>";
            }
        }
    }

    $output = $gridContainerItems;
    echo $output;
}

function dir_is_empty($dir)
{
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            closedir($handle);
            return false;
        }
    }
    closedir($handle);
    return true;
}

function noMediaItems($req)
{
    return <<<_END
    <div class="text-center">
        <h5>No media in .</h5>
    </div>
    _END;
}

switch ($requestDir) {
    case 'shared':
        $dirpathstring = "../media/profiles/$current_user_username/shared_media/";
        if (dir_is_empty($dir)) listDirectory($dirpathstring);
        else echo noMediaItems($requestDir);
        break;
    case 'private':
        $dirpathstring = "../media/profiles/$current_user_username/private_media/";
        listDirectory($dirpathstring);
        break;
    case 'video':
        $dirpathstring = "../media/profiles/$current_user_username/video_media/";
        listDirectory($dirpathstring);
        break;
    case 'audio':
        $dirpathstring = "../media/profiles/$current_user_username/audio_media/";
        listDirectory($dirpathstring);
        break;

    default:
        die("Unknown path requested: $dirPath");
        break;
}

// listDirectory($dirPath);
