<?php

$dirPath = "profiles/";
$fullPath = $gridContainerItems = "";

function listIt($path)
{
    global $gridContainerItems;
    $items = scandir($path);

    foreach ($items as $item) {

        // Ignore the . and .. folders
        if ($item != "." and $item != "..") {
            if (is_file($path . $item)) {
                // this is the file
                // echo "-> " . $item . "<br>";
                $fullPath = $path . $item;
                echo <<<_END
                <div class="grid-tile">
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
                echo <<<_END
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
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onefit.app&trade; | Onefit.Net&reg; &copy;
        <?php echo date('Y'); ?>
    </title>

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Plyr.io Media Player -->
    <link rel="stylesheet" href="https://cdn.plyr.io/1.8.2/plyr.css">

    <!-- Plry.io JS CDN -->
    <script src="https://cdn.plyr.io/1.8.2/plyr.js"></script>
    <script src="https://cdn.jsdelivr.net/hls.js/latest/hls.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

    <!-- W3 CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

    <!-- My CSS styles -->
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="stylesheet" href="../css/digital-clock.css" />
    <link rel="stylesheet" href="../css/timeline-styles.css" />

    <!-- Site Scripts -->
    <!-- <script src="../scripts/js/script.js"></script>
    <script src="../scripts/js/api_requests.js"></script> -->

    <!-- ./ Site Scripts -->

    <!-- JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <?php
        echo '<div class="grid-container p-4" style="border-radius: 25px; max-height: 100vh; overflow-y: auto;overflow-x: hidden;">';
        listIt($dirPath);
        echo "</div>";
        ?>
    </div>
</body>

</html>