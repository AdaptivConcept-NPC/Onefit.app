<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    echo <<<_END
    <div class="row">
        <div class="col-md-4 light-scroller pb-4" style="max-height:80vh;overflow-y:auto;">
            <div class="create-btn-container-static comfortaa-font d-grid gap-2">
                <div class="p-0 w3-animate-bottom d-grid" id="staticCreateCommandList">
                    <!-- toggle button -->
                    <div id="toggle-create-functions-menu" class="sticky-top d-flex justify-content-between align-items-center m-0 pb-4 top-down-grad-dark">
                        <button class="onefit-buttons-style-dark p-4 border-5 border-bottomz border-whitez d-lg-nonez collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#create-functions-tab-btn" aria-expanded="false" aria-controls="create-functions-tab-btn">
                            <div class="d-grid gap-2">
                                <span class="material-icons material-icons-round"> menu </span>
                                <p class="m-0" style="font-size: 8px;">Creations.</p>
                            </div>
                        </button>
                        <div class="d-grid w-100">
                            <h1 class="fs-5 comfortaa-font my-4 text-end -md-end -sm-end -lg-center" style="color:var(--tahitigold);"><span style="color:var(--white);">
                                Onefit.</span>Create.
                            </h1>
                            <!-- onclick="$('#toggle-create-functions-menu').click();" -->
                        </div>
                    </div>
                    <ul id="create-functions-tab-btn" class="list-groupz list-group-flush list-group border-0 text-white fw-bold text-center comfortaa-font collapse show" style="overflow-x: hidden; overflow-y: auto !important;">
                        <li class="list-group-item bg-transparent d-grid visually-hidden">
                            <button id="v-pills-creation-start-tab" type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-2 justify-content-between align-items-center" data-bs-toggle="pill" data-bs-target="#v-pills-creation-start" role="tab" aria-controls="v-pills-creation-start" aria-selected="true"
                                onclick="$.smoothScroll('#interactionsContentContainer', '#v-pills-tabCreationContent', 100);">
                                start.
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-commfeed-tab" 
                                onclick="$('#v-pills-creation-start').removeClass('active show');$.smoothScroll('#interactionsContentContainer', '#v-pills-tabCreationContent', 100);" 
                                    type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-4 justify-content-evenly align-items-center" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#v-pills-creation-commfeed" 
                                    role="tab" 
                                    aria-controls="v-pills-creation-commfeed" 
                                    aria-selected="false">
                                <span class="material-icons material-icons-round align-middle" style="color:var(--tahitigold);">
                                    post_add
                                </span> 
                                <span class="d-none d-lg-block" style="color:var(--tahitigold);">|</span> 
                                <span class="d-none d-lg-block d-sm-block text-start">community feed.</span>
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-grpshare-tab" 
                                onclick="$('#v-pills-creation-start').removeClass('active show');$.smoothScroll('#interactionsContentContainer', '#v-pills-tabCreationContent', 100);" 
                                    type="button" 
                                    class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-top border-bottom d-flex gap-4 justify-content-evenly align-items-center" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#v-pills-creation-grpshare" 
                                    role="tab" 
                                    aria-controls="v-pills-creation-grpshare" 
                                    aria-selected="false">
                                <span class="material-icons material-icons-round align-middle" style="color:var(--tahitigold);">
                                    volunteer_activism
                                </span> 
                                <span class="d-none d-lg-block" style="color:var(--tahitigold);">|</span> 
                                <span class="d-none d-lg-block d-sm-block text-start">Group sharing.</span>
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-stream-tab" 
                                onclick="$('#v-pills-creation-start').removeClass('active show');$.smoothScroll('#interactionsContentContainer', '#v-pills-tabCreationContent', 100);" 
                                    type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-4 justify-content-evenly align-items-center" 
                                    data-bs-toggle="pill" data-bs-target="#v-pills-creation-stream" 
                                    role="tab" 
                                    aria-controls="v-pills-creation-stream" 
                                    aria-selected="false">
                                <span class="material-icons material-icons-round align-middle" style="color:var(--tahitigold);">
                                    live_tv
                                </span> 
                                <span class="d-none d-lg-block" style="color:var(--tahitigold);">|</span> 
                                <span class="d-none d-lg-block d-sm-block text-start">Onefit.Stream</span>
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-mdupload-tab" 
                                onclick="$('#v-pills-creation-start').removeClass('active show');$.smoothScroll('#interactionsContentContainer', '#v-pills-tabCreationContent', 100);" 
                                    type="button" class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-bottom border-top d-flex gap-4 justify-content-evenly align-items-center" data-bs-toggle="pill" 
                                    data-bs-target="#v-pills-creation-mdupload" 
                                    role="tab" 
                                    aria-controls="v-pills-creation-mdupload" 
                                    aria-selected="false">
                                <span class="material-icons material-icons-round align-middle" style="color:var(--tahitigold);">
                                    perm_media
                                </span> 
                                <span class="d-none d-lg-block" style="color:var(--tahitigold);">|</span> 
                                <span class="d-none d-lg-block d-sm-block text-start">Upload media.</span>
                            </button>
                        </li>
                        <li class="list-group-item bg-transparent d-grid">
                            <button id="v-pills-creation-messenger-tab" 
                                onclick="$('#v-pills-creation-start').removeClass('active show');$.smoothScroll('#interactionsContentContainer', '#v-pills-tabCreationContent', 100);" 
                                    type="button" 
                                    class="onefit-buttons-style-dark text-white p-5 fs-3 shadow border-5 border-start border-end d-flex gap-4 justify-content-evenly align-items-center" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#v-pills-creation-messenger" 
                                    role="tab" 
                                    aria-controls="v-pills-creation-messenger" 
                                    aria-selected="false">
                                <span class="material-icons material-icons-round align-middle" style="color:var(--tahitigold);">
                                    forum
                                </span> 
                                <span class="d-none d-lg-block" style="color:var(--tahitigold);">|</span> 
                                <span class="d-none d-lg-block d-sm-block text-start">Messenger.</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md -8 light-scroller" style="overflow-y:auto;background-color:rgba(52,52,52,0.8)!important;z-index:1;min-height:80vh;max-height:90vh;">
            <div class="tab-content h-100" id="v-pills-tabCreationContent">
                <div class="tab-pane fadez w3-animate-left active show" id="v-pills-creation-start" role="tabpanel" aria-labelledby="v-pills-creation-start-tab" tabindex="0">
                    <div class="top-down-grad-tahiti d-grid justify-content-center align-items-center shadow" style="border-radius:25px;min-height:80vh;">
                        <div class="w-100 h-100 d-grid gap-4 justify-content-center align-items-center text-center">
                            <img src="../media/assets/icons/brush_white_24dp.svg" class="img-fluid" style="height: 25vh; filter: invert(0);" alt="creation tools icon">
                        </div>
                    </div>
                </div>
                <!-- <hr/> -->
                <div class="tab-pane p-4 fadez w3-animate-left" id="v-pills-creation-commfeed" role="tabpanel" aria-labelledby="v-pills-creation-commfeed-tab" tabindex="0">
                    <h1 class="mb-4 fs-2"> Social community feed.</h1>
                </div>
                <div class="tab-pane p-4 fadez w3-animate-left" id="v-pills-creation-grpshare" role="tabpanel" aria-labelledby="v-pills-creation-grpshare-tab" tabindex="0">
                    <h1 class="mb-4 fs-2"> Group sharing.</h1>
                </div>
                <div class="tab-pane p-4 fadez w3-animate-left" id="v-pills-creation-stream" role="tabpanel" aria-labelledby="v-pills-creation-stream-tab" tabindex="0">
                    <h1 class="mb-4 fs-2"> Stream.</h1>
                </div>
                <div class="tab-pane p-4 fadez w3-animate-left" id="v-pills-creation-mdupload" role="tabpanel" aria-labelledby="v-pills-creation-mdupload-tab" tabindex="0">
                    <h1 class="mb-4 fs-2"> Media upload.</h1>
                </div>
                <div class="tab-pane p-4 fadez w3-animate-left" id="v-pills-creation-messenger" role="tabpanel" aria-labelledby="v-pills-creation-messenger-tab" tabindex="0">
                    <h1 class="mb-4 fs-2"> Messenger.</h1>
                </div>
            </div>
        </div>
    </div>
    _END;
} else {
    echo "return: No POST request received";
}
