<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    echo <<<_END
    <div class="row">
        <div class="col-md">
            <div class="create-btn-container-static comfortaa-font d-grid gap-2 d-none d-lg-block">
                <div class="p-4 w3-animate-bottom" id="staticCreateCommandList">
                    <ul class="list-groupz list-group-flush list-group border-0 text-white fw-bold text-center comfortaa-font" style="overflow: initial !important;">
                        <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow">Post Group Update</button></li>
                        <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow">Post Community Resource</button></li>
                        <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow">Share Media</button></li>
                        <li class="list-group-item bg-transparent d-grid"><button type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow">Send Message</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md d-none">
        </div>
    </div>
    _END;
} else {
    echo "return: No POST request received";
}
