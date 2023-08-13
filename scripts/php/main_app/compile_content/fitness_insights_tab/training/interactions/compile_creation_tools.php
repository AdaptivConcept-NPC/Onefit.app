<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    echo <<<_END
    <div class="row">
        <div class="col-md-4">
            <div class="create-btn-container-static comfortaa-font d-grid gap-2 d-none d-lg-block">
                <div class="p-4 w3-animate-bottom d-grid" id="staticCreateCommandList">
                    <ul class="list-groupz list-group-flush list-group border-0 text-white fw-bold text-center comfortaa-font" style="overflow: initial !important;">
                        <li class="list-group-item bg-transparent d-grid visually-hidden">
                            <button id="v-pills-creation-start-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-2 justify-content-between align-items-center"
                            data-bs-toggle="pill" data-bs-target="#v-pills-creation-start" type="button" role="tab" aria-controls="v-pills-creation-start" aria-selected="true">
                                start.
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-commfeed-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-2 justify-content-between align-items-center"
                            data-bs-toggle="pill" data-bs-target="#v-pills-creation-commfeed" type="button" role="tab" aria-controls="v-pills-creation-commfeed" aria-selected="false">
                                <span class="material-icons material-icons-round align-middle">
                                    post_add
                                </span> 
                                <span style="color:var(--tahitigold);">|</span> 
                                community feed.
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-grpshare-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-top border-bottom d-flex gap-4 justify-content-between align-items-center"
                            data-bs-toggle="pill" data-bs-target="#v-pills-creation-grpshare" type="button" role="tab" aria-controls="v-pills-creation-grpshare" aria-selected="false">
                                <span class="material-icons material-icons-round align-middle">
                                    volunteer_activism
                                </span> 
                                <span style="color:var(--tahitigold);">|</span> 
                                Group sharing.
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-stream-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-4 justify-content-between align-items-center"
                            data-bs-toggle="pill" data-bs-target="#v-pills-creation-stream" type="button" role="tab" aria-controls="v-pills-creation-stream" aria-selected="false">
                                <span class="material-icons material-icons-round align-middle">
                                    live_tv
                                </span> 
                                <span style="color:var(--tahitigold);">|</span> 
                                Onefit.Stream.
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-mdupload-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-bottom border-top d-flex gap-4 justify-content-between align-items-center"
                            data-bs-toggle="pill" data-bs-target="#v-pills-creation-mdupload" type="button" role="tab" aria-controls="v-pills-creation-mdupload" aria-selected="false">
                                <span class="material-icons material-icons-round align-middle">
                                    perm_media
                                </span> 
                                <span style="color:var(--tahitigold);">|</span> 
                                Upload media.
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-messenger-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-4 justify-content-between align-items-center"
                            data-bs-toggle="pill" data-bs-target="#v-pills-creation-messenger" type="button" role="tab" aria-controls="v-pills-creation-messenger" aria-selected="false">
                                <span class="material-icons material-icons-round align-middle">
                                    forum
                                </span> 
                                <span style="color:var(--tahitigold);">|</span> 
                                Messenger.
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md d-nonez light-scroller" style="overflow-y:auto">
            <div class="w3-animate-right top-down-grad-tahiti" style="border-radius:25px;" id="v-pills-creation-start">
                <div class="w-100 h-100 d-grid gap-4 justify-content-center align-items-center text-center">
                    <img src="../media/assets/icons/brush_white_24dp.svg" class="img-fluid" style="height: 50vh; filter: invert(0);" alt="creation tools icon">
                    <span class="mb-5">Start creating...</span>
                </div>
            </div>
            <hr/>
            <div class="tab-content h-100" id="v-pills-tabCreationContent">
                <div class="tab-pane fadez w3-animate-right" id="v-pills-creation-commfeed" role="tabpanel" aria-labelledby="v-pills-creation-commfeed-tab" tabindex="0">
                    Social community feed.
                </div>
                <div class="tab-pane fadez w3-animate-right" id="v-pills-creation-grpshare" role="tabpanel" aria-labelledby="v-pills-creation-grpshare-tab" tabindex="0">
                    Group sharing.
                </div>
                <div class="tab-pane fadez w3-animate-right" id="v-pills-creation-stream" role="tabpanel" aria-labelledby="v-pills-creation-stream-tab" tabindex="0">
                    Stream.
                </div>
                <div class="tab-pane fadez w3-animate-right" id="v-pills-creation-mdupload" role="tabpanel" aria-labelledby="v-pills-creation-mdupload-tab" tabindex="0">
                    Media centre.
                </div>
                <div class="tab-pane fadez w3-animate-right" id="v-pills-creation-messenger" role="tabpanel" aria-labelledby="v-pills-creation-messenger-tab" tabindex="0">
                    Messenger.
                </div>
            </div>
        </div>
    </div>
    _END;
} else {
    echo "return: No POST request received";
}
