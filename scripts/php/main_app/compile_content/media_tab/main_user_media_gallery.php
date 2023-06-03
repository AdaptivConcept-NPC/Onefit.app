<?php
session_start();
require("../../../functions.php");

if (!isset($_GET['dir'])) die("No directory specified.");

$requestDir = $_GET['dir'];
$output = $subFoldersList = $imageGridItems = null;

if (!isset($_SESSION['currentUserUsername'])) die("Fatal Error");
else $current_user_username = $_SESSION['currentUserUsername'];

function getSubFolders($path)
{
    $directories = glob("../../../../$path" . '/*', GLOB_ONLYDIR);
    return $directories;
}

// function to list the files and sub-directories in a specified root directory
function listDirectory($path)
{
    global $output, $subFoldersList, $imageGridItems, $current_user_username;


    $subFoldersList = $subFoldersListArray = $imageGridItems = $tabButtonsList = $tabContentContainers = null; // clear these variables

    // get a list of all sub-folder from the requested directory #.'/*'
    $subFoldersListArray = getSubFolders($path);

    // for each sub-folder, create a button list for the gallery tab container
    $btnActiveState = "active";
    foreach ($subFoldersListArray as $subFolder) {
        // explode the string and 
        $dirSegmentsArray = explode("/", $subFolder);
        // get the last index
        $lastIndexItem = end($dirSegmentsArray);
        // remove all spaces & special characters in the $lastIndexItem string
        $subFolderIndex = clean($lastIndexItem);

        $tabButtonsList .= <<<_END
        <button class="nav-link $btnActiveState" id="v-pills-$subFolderIndex-tab" data-bs-toggle="pill" data-bs-target="#v-pills-$subFolderIndex" type="button" role="tab" aria-controls="v-pills-$subFolderIndex" aria-selected="false">
            <span class="material-icons material-icons-round align-middle" style="color: #ffa500; font-size: 60px !important">
                topic
            </span>
            <span class="align-middle w-100 text-truncate text-white">$lastIndexItem</span>
        </button>
        _END;

        $btnActiveState = ""; // set active state to the first iteration only
    }

    $subFoldersList = $tabButtonsList;

    // for each sub-folder, get all media gallery image grid
    $tabPaneActiveState = "show active";
    foreach ($subFoldersListArray as $subFolder) {
        // explode the string and 
        $dirSegmentsArray = explode("/", $subFolder);
        // get the last index
        $lastIndexItem = end($dirSegmentsArray);
        // remove all spaces & special characters in the $lastIndexItem string
        $subFolderIndex = clean($lastIndexItem);
        $items = scandir($subFolder);
        //die(print_r($items));

        $imageGridItems = ""; // clear the existing media


        foreach ($items as $item) {

            // $mediaItemIndex = str_replace(" ", "", $item); // remove all spaces in the $item string

            // $fullPath = $subFolder . "/" . $item;
            // $randStr = generateNumericRandomString(10);
            // $imageGridItems .= <<<_END
            // <img src="$fullPath" id="media-$subFolderIndex-$randStr" class="img-fluidz" style="border-radius:25px;" alt="$current_user_username media - $item" />
            // _END;

            // Ignore the . and .. folders
            if ($item != "." and $item != "..") {
                // echo $subFolder . "/" . $item;
                // echo "<br/>";
                if (is_file($subFolder . "/" . $item)) {
                    // this is the file "../../../../" . 
                    // echo "-> " . $item . "<br>";
                    $fullPath = $path . "/" . $lastIndexItem . "/" . $item;
                    // echo $path . "/" . $lastIndexItem .  "/" . $item;
                    // echo "<br/>";

                    $randStr = generateNumericRandomString(10);

                    $imageGridItems .= <<<_END
                    <img src="$fullPath" id="media-$subFolderIndex-$randStr" class="img-fluidz" style="border-radius:25px;" alt="$current_user_username media - $item" />
                    _END;
                }
            }
        }

        // create the tab-content container and add gallery grid items inside it
        $tabContentContainers .= <<<_END
        <div class="tab-pane fade $tabPaneActiveState" id="v-pills-$subFolderIndex" role="tabpanel" aria-labelledby="v-pills-$subFolderIndex-tab" tabindex="0">
            <div class="p-4 my-4 d-grid text-center down-top-grad-dark border-5 border-end border-start" style="border-radius:25px;">
                <h5 class="fs-4 text-center text-white">$lastIndexItem.</h5>
            </div>
            <div class="media-container">
                $imageGridItems
            </div>
        </div>
        _END;

        $tabPaneActiveState = ""; // set active state to the first iteration only
    }

    $output = <<<_END
    <div class="d-grid align-items-startz">
        <div class="nav flex-columnz nav-pills me-3z" id="v-pills-mediaGalleryTab" role="tablist" aria-orientation="vertical">
            $subFoldersList
        </div>
        <div class="tab-content" id="v-pills-mediaGalleryContent">
            $tabContentContainers
        </div>
    </div>
    _END;
    echo $output;
}

function dir_is_empty($dir)
{
    $handle = opendir("../../../../$dir/");
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
    <div class="no-media">
        <h5 class="fs-1 fw-bold d-grid gap-4 text-center">
            <span class="material-icons material-icons-round" style="font-size:100px!important;">
                hourglass_empty
            </span>
            <span>No media<!--in $req--><span style="color:var(--tahitigold);">.</span></span>
        </h5>
    </div>
    _END;
}


switch ($requestDir) {
    case 'shared':
        $dirpathstring = "../media/profiles/$current_user_username/shared_media";
        if (!dir_is_empty($dirpathstring)) listDirectory($dirpathstring);
        else echo noMediaItems($requestDir);
        break;
    case 'private':
        $dirpathstring = "../media/profiles/$current_user_username/private_media";
        if (!dir_is_empty($dirpathstring)) listDirectory($dirpathstring);
        else echo noMediaItems($requestDir);
        break;
    case 'video':
        $dirpathstring = "../media/profiles/$current_user_username/video_media";
        if (!dir_is_empty($dirpathstring)) listDirectory($dirpathstring);
        else echo noMediaItems($requestDir);
        break;
    case 'audio':
        $dirpathstring = "../media/profiles/$current_user_username/audio_media";
        if (!dir_is_empty($dirpathstring)) listDirectory($dirpathstring);
        else echo noMediaItems($requestDir);
        break;

    default:
        die("Unknown path requested: $dirPath");
        break;
}

// listDirectory($dirPath);

/* 
 else {
    // this is the directory



    // do the list it again!
    // echo "---> " . $item;
    $subFoldersList .= <<<_END
    <button class="nav-link" id="v-pills-$dirNameId-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
        <span class="material-icons material-icons-round align-middle" style="color: #ffa500; font-size: 60px !important">
            topic
        </span>
        <span class="align-middle w-100 text-truncate text-white">$item</span>
    </button>
    _END;
    // echo "<div style='padding-left: 10px'>";
    listDirectory($path . $item . "/");
    // echo "</div>";
}
*/

/* 
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
*/