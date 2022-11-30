<?php
session_start();
require("../../../functions.php");

if (!isset($_GET['dir'])) die("No directory specified.");

$dirPath = $_GET['dir'];
$output = $gridContainerItems = null;

// function to list the files and sub-directories in a specified root directory
function listDirectory($path)
{
    global $output, $gridContainerItems;
    $items = scandir($path);

    foreach ($items as $item) {

        // Ignore the . and .. folders
        if ($item != "." and $item != "..") {
            if (is_file($path . $item)) {
                // this is the file
                // echo "-> " . $item . "<br>";
                $fullPath = $path . $item;
                $gridContainerItems .= <<<_END
                <div class="grid-tile" style="background-color: #343434;>
                    <div class="media-item-tile p-2 mx-0 center-container shadow d-flex align-items-end justify-content-between" style="border-radius: 25px; overflow: hidden; max-height: 200px; background-image: url('$fullPath');">
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
                listIt($path . $item . "/");
                // echo "</div>";
            }
        }
    }

    $output = $gridContainerItems;
    echo $output;
}

switch ($dirPath) {
    case 'shared':
        listDirectory("../../../../../media/profiles/$currentUser_Usrnm/shared_media");
        break;
    case 'private':
        listDirectory("../../../../../media/profiles/$currentUser_Usrnm/private_media");
        break;
    case 'videos':
        listDirectory("../../../../../media/profiles/$currentUser_Usrnm/video_media");
        break;

    default:
        break;
}

// listDirectory($dirPath);
