<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration | onefit&trade; &copy; 2021 AdaptivConcept</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/styles.css" />

    <script>
    // check if these core scripts are loaded for js check function
    var coreScriptLoaded =
        coreScriptLoaded_googlefont_icons_css =
        coreScriptLoaded_bootstrap_local_css =
        coreScriptLoaded_w3_css =
        coreScriptLoaded_custom_styles_css =
        coreScriptLoaded_custom_script_js =
        coreScriptLoaded_jquery_local_js =
        coreScriptLoaded_custom_jquery_func_js = false;

    // these core scripts are not available in this page so set them as true as not to interfere with js check function
    var coreScriptLoaded_plyrio_css =
        coreScriptLoaded_plyrio_js =
        coreScriptLoaded_hls_js =
        coreScriptLoaded_bootstrap_bundle_local_js =
        coreScriptLoaded_digiclock_css =
        coreScriptLoaded_digiclock_js =
        coreScriptLoaded_timeline_css =
        coreScriptLoaded_custom_jquery_func_js =
        coreScriptLoaded_custom_api_req_js =
        coreScriptLoaded_moment_js =
        coreScriptLoaded_googlefonts_fonts =
        coreScriptLoaded_googlefonts_css =
        coreScriptLoaded_soccerfield_css =
        coreScriptLoaded_soccerfield_css =
        coreScriptLoaded_soccerfield_js =
        coreScriptLoaded_chartjs_js = true;
    </script>

    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"
        onload="coreScriptLoaded_googlefont_icons_css=true;" />

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css"
        onload="coreScriptLoaded_bootstrap_local_css=true;">

    <!-- W3 CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" onload="coreScriptLoaded_w3_css=true;" />

    <!-- My CSS styles -->
    <link rel="stylesheet" href="../css/styles.css" onload="coreScriptLoaded_custom_styles_css=true;" />

    <!-- JQuery local -->
    <script src="../node_modules/jquery/dist/jquery.min.js" onload="coreScriptLoaded_jquery_local_js=true;"></script>

    <!-- JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        onload="coreScriptLoaded_custom_jquery_func_js=true;"></script>
    <!-- ./ JQuery CDN -->

    <!-- Custom Site Scripts -->
    <script src="../scripts/js/script_jquery.js" onload="coreScriptLoaded_custom_jquery_func_js=true;"></script>
    <script src="../scripts/js/script.js" onload="coreScriptLoaded_custom_script_js=true;"></script>

</head>

<body>
    <div class="container-fluid h-100 no-scroller" style="max-height: 100vh !important; overflow-y: auto;">
        <!-- Navigation bar -->
        <nav class="navbar navbar-light sticky-top navbar-style">
            <div class="container-fluid">
                <a class="navbar-brand fs-1 text-white comfortaa-font" href="../index.php">One<span
                        style="color: var(--primary-color)">fit</span>.app<span
                        style="font-size: 10px">&trade;</span></a>
                <button class="navbar-toggler shadow onefit-buttons-style-dark bg-transparent p-4" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <!--<span class="navbar-toggler-icon"></span>-->
                    <!--<img src="./media/assets/One-Symbol-Logo-Two-Tone.svg" alt="" class="img-fluid logo-size-1" />-->
                    <span class="material-icons material-icons-round align-middle" style="font-size: 28px!important;">
                        public
                        <!-- menu_open -->
                    </span>
                </button>
                <div class="offcanvas offcanvas-end offcanvas-menu-primary-style" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="h-100" id="offcanvas-menu">
                        <div class="offcanvas-header fs-1"
                            style="background-color: var(--secondary-color); color: #fff">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img
                                    src="../media/assets/One-Symbol-Logo-White.svg" alt=""
                                    class="img-fluid logo-size-2" /> Navigation</h5>
                            <button type="button" class="onefit-buttons-style-light rounded-pill shadow p-2"
                                data-bs-dismiss="offcanvas" aria-label="Close">
                                <span class="material-icons material-icons-round align-middle">
                                    close
                                </span>
                            </button>
                        </div>
                        <div class="offcanvas-body pb-4 top-down-grad-dark" style="max-height: 100vh;">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 comfortaa-font fs-3 h-100"
                                style="overflow-y: auto;">
                                <li class="nav-item d-grid">
                                    <p class="text-white text-center" style="font-size:10px;">Get started with your
                                        fitness
                                        journey by
                                        signing up for a free community account or subscribe to our Premium offering to
                                        get
                                        access to
                                        Pro.Athlete level fitness tracking resources, guides, physical trainer and
                                        community
                                        support.</p>
                                    <a class="onefit-buttons-style-light p-4 text-center text-decoration-none shadow fw-bold fs-5"
                                        href="registration/"
                                        style="border-radius: 25px !important; font-size: 20px !important;transform:scale(1)!important;color: var(--secondary-color)!important;">Register
                                        your account.
                                        <i class="fas fa-file-signature"></i>
                                    </a>
                                </li>
                                <hr class="text-white">
                                <li class="nav-item">
                                    <a class="nav-link active p-4" href="https://onefitnet.co.za/" aria-current="page"
                                        href="#" style="border-radius: 25px !important;">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" href="https://onefitnet.co.za/about/" target="_blank"
                                        style="border-radius: 25px !important;">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" href="https://onefitnet.co.za/training/" target="_blank"
                                        style="border-radius: 25px !important;">Training Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" href="https://onefitnet.co.za/contact/" target="_blank"
                                        style="border-radius: 25px !important;">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-4" href="https://onefitnet.co.za/blog/" target="_blank"
                                        style="border-radius: 25px !important;">OnefitNet Blog</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a class="nav-link p-4" href="https://onefitnet.co.za/store/" target="_blank"
                                        style="border-radius: 25px !important;">Onefit.Store™</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- ./ Navigation bar -->

        <div class="row align-items-center">
            <div class="col-xl py-4">
                <!-- collapsable logo panel -->
                <div id="collapseLogoPanel"
                    class="content-panel-border-style p-4 darkpads-bg-container text-center shadow collapse multi-collapse show w3-animate-top"
                    style="border-radius: 25px">
                    <img src="../media/assets/One-Logo-Vertical.svg" class="img-fluid my-4 screenz" alt="one fitness"
                        style="max-height: 50vh" />

                    <p class="my-4 text-center comfortaa-font" style="color: #fff; font-size: 10px">Crafted by
                        AdaptivConcept FL &copy;
                        2021. All rights reserved.</p>
                </div>
                <!-- ./ collapsable logo panel -->

                <!-- collapsable plan comparison table panel -->
                <div id="collapsePlanCompTblPanel"
                    class="content-panel-border-style p-4 darkpads-bg-container text-center shadow collapse multi-collapse w3-animate-bottom no-scroller"
                    style="border-radius: 25px;max-height: 80vh; overflow-y: auto;">
                    <h5 class="fs-1 d-flexz gap-2 justify-content-center fw-bold text-center mt-4 mb-2"
                        style="color:var(--white);">
                        <span class="material-icons material-icons-round align-middle"
                            style="font-size:80px!important;color: var(--primary-color);">
                            verified_user
                        </span>
                        <span class="align-middle"><strong style="color: var(--primary-color);">Pro</strong>
                            Membership.</span>
                    </h5>
                    <p class="text-center mb-5">Plan comparison.</p>
                    <div class="table-responsive light-scroller">
                        <table class="table table-stripedz shadow-lg align-middle"
                            style="border-radius: 25px;overflow-y:auto;background-color: var(--secondary-color);color: var(--text-color);">
                            <thead>
                                <tr>
                                    <th colspan="5" scope="col p-4 text-start"
                                        style="background-color:var(--white)!important;color: var(--secondary-color);border-radius:25px 25px 0 0 !important;overflow:hidden;">
                                        <p class="text-center my-4 fs-3">Membership Benefits.</p>
                                    </th>
                                </tr>
                                <tr class="text-center fs-3">
                                    <th scope="col p-4 text-start">
                                        <p class="align-middle my-4 text-start">Features</p>
                                    </th>
                                    <th scope="col p-4">
                                        <p class="align-middle my-4">Community.<span
                                                style="color: var(--primary-color)">Indi</span></p>
                                    </th>
                                    <th scope="col p-4">
                                        <p class="align-middle my-4">Pro.<span
                                                style="color: var(--primary-color)">Starter</span></p>
                                    </th>
                                    <th scope="col p-4">
                                        <p class="align-middle my-4">Pro.<span
                                                style="color: var(--primary-color)">Athlete</span></p>
                                    </th>
                                    <th scope="col p-4">
                                        <p class="align-middle my-4">Teams.<span
                                                style="color: var(--primary-color)">Pro</span>
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <tr>
                                    <td colspan="5" class="text-center bg-white text-dark fw-bold fs-3"
                                        style="background-color: var(--primary-color);">For Individuals.</td>
                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Pro.Starter Active kit (carry bag, water bottle, towel,
                                        yoga-mat,
                                        resistance band,
                                        mini-tripod)</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Pro.Athlete Active kit (fitbit activity band, carry bag,
                                        water
                                        bottle, towel,
                                        yoga-mat, resistance band, mini-tripod)</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">fitbit stats integration</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Level-1 curated fitness programs.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Level-2 curated fitness programs.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Level-3 curated fitness programs.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Pro rewards program (xp prizes).</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Community rewards program (xp prizes).</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Community Live Streams.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Private group training</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Virtual training support.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Personal trainer support.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Wellness tools and counselling. </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Nutrition tracking and management tools.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Dieticien support and meal-kits resources.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <td colspan="5" class="text-center bg-white text-dark fw-bold fs-3">For Teams.</td>
                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Power BI analytics dashboard.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Google community survey dashboard.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">Training resource research APIs (AdaptEngine™).</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="text-center">
                                    <!-- <th scope="row">1</th> -->
                                    <td class="text-start">AI content generation tools.</td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle">
                                            highlight_off
                                        </span>
                                    </td>
                                    <td>
                                        <span class="material-icons material-icons-round align-middle"
                                            style="color: var(--primary-color)!important;">
                                            check_circle_outline
                                        </span>
                                    </td>

                                </tr>
                                <tr class="py-4 border-0 text-center">
                                    <td class="border-0 fs-1">Subscribe today!</td>
                                    <td class="border-0 py-4">
                                        <button
                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold shadowz fs-2">
                                            Free
                                        </button>
                                    </td>
                                    <td class="border-0 py-4">
                                        <button
                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold shadowz">
                                            R1800 (3 Months)
                                        </button>
                                    </td>
                                    <td class="border-0 py-4">
                                        <button
                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold shadowz">
                                            R5200 (12 Months)
                                        </button>
                                    </td>
                                    <td class="border-0 py-4">
                                        <button
                                            class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold shadowz">
                                            Contact Sales
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="my-4 text-center comfortaa-font" style="color: #fff; font-size: 10px">Crafted by
                        AdaptivConcept FL &copy;
                        2021. All rights reserved.</p>
                </div>
                <!-- ./ collapsable plan comparison table panel -->
            </div>
            <div class="col-xl py-4 text-center"
                style="max-height: 90vh; overflow-y: auto; overflow-x: hidden;border-radius:25px;">
                <div class="content-panel-border-style registration-form tunnel-bg mb-4 shadow p-4"
                    style="width: 100%; border-radius: 25px; background-color: var(--secondary-color);">
                    <h2 class="text-center fs-1 pt-4" style="color: var(--primary-color)"><i
                            class="fas fa-file-signature"></i> Sign
                        up for a
                        Community
                        account, it's free.</h2>
                    <p>Get free access to tons of Fitness, Health and Lifestyle related Resources, News, Blogs and
                        Shopping
                        Content
                        with the Community Account. We also offer Community Members checkout discounts on selected
                        One<span style="color: var(--primary-color);">fit</span>.Store Products
                        and Services. Sign up today to start the meaningful and insightful fitness journey that you have
                        always been
                        looking for.</p>
                    <hr class="mx-4 bg-white" />

                    <form id="community-registration-form" name="community-registration-form"
                        class="container text-center comfortaa-font fs-5 needs-validation" method="post"
                        action="../scripts/php/main_app/data_management/system_admin/user_registration/register_user.php"
                        autocomplete="off">
                        <div class="output-container my-2" id="output-container">
                            <!--<?php echo $output; ?>-->
                        </div>

                        <div id="emailHelp" class="form-text text-center d-grid gap-2 fw-bold my-4"
                            style=" color: #fff">
                            <p>We have a responsibility to
                                keep your keep your Identity &amp; Privacy safe!
                            </p>
                            <span class="material-icons material-icons-round align-middle"
                                style="font-size: 28px!important;">
                                policy
                            </span>
                            <a href="http://" class="fw-bold mx-2" style="color: var(--primary-color);">Feel free to
                                read
                                our Privacy
                                Policy.</a>
                        </div>

                        <hr class="mx-4 bg-white" />

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-name"
                                style="color: var(--primary-color);">First
                                Name</label>
                            <input class="form-control-text-input p-4" type="text" name="reg-name" id="reg-name"
                                placeholder="Required." required />
                        </div>

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-surname"
                                style="color: var(--primary-color);">Last
                                Name</label>
                            <input class="form-control-text-input p-4" type="text" name="reg-surname" id="reg-surname"
                                placeholder="Required." required />
                        </div>

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-email"
                                style="color: var(--primary-color);">Email
                                address</label>
                            <input class="form-control-text-input p-4" type="email" name="reg-email" id="reg-email"
                                placeholder="Required." required />
                        </div>

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-contact"
                                style="color: var(--primary-color);">Phone
                                number</label>
                            <input class="form-control-text-input p-4" type="tel" value="+27" name="reg-contact"
                                id="reg-contact" placeholder="Required." required />
                            <!-- pattern="((\+|00)?[1-9]{2}|0)[0-9]{8}" must fix pattern, not working at the moment -->
                            <p class="text-center">
                                <span class="material-icons material-icons-round align-middle"
                                    style="font-size: 20px!important;color: var(--primary-color);">
                                    crisis_alert
                                </span>
                                <small class="align-middle">please use this format: <strong>+27
                                        714567890</strong></small>
                            </p>
                            <!-- [0-9]{3}-[0-9]{3}-[0-9]{4} -->
                            <!-- pattern="((\+|00)?[1-9]{2}|0)[1-9](?[0-9]){8}" - https://stackoverflow.com/questions/27000681/how-to-verify-form-input-using-html5-input-verification -->
                        </div>
                        <!-- <div class="form-group my-4">
              <input class="form-control-text-input p-4" type="text" name="reg-idnum" id="reg-idnum" placeholder="ID/Passport number (Optional)" />
            </div> -->

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-dob" style="color: var(--primary-color);">Date
                                of
                                birth</label>
                            <input class="form-control-text-input p-4" type="date" name="reg-dob" id="reg-dob"
                                placeholder="Required." required />
                        </div>

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-gender"
                                style="color: var(--primary-color);">Gender</label>
                            <select class="custom-select form-control-select-input p-4" name="reg-gender"
                                id="reg-gender" placeholder="Required." required>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>
                        </div>

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-race" style="color: var(--primary-color);">Race
                                /
                                Ethnicity</label>
                            <select class="custom-select form-control-select-input p-4" name="reg-race" id="reg-race"
                                placeholder="Required." required>
                                <option value="black">Black</option>
                                <option value="white">White</option>
                                <option value="coloured">Coloured</option>
                                <option value="asian">Asian</option>
                            </select>
                        </div>
                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-nationality"
                                style="color: var(--primary-color);">Nationality</label>
                            <select class="custom-select form-control-select-input p-4" name="reg-nationality"
                                id="reg-nationality" placeholder="Required." required>
                                <option value='South Africa'>South Africa</option>
                                <option value='Afghanistan'>Afghanistan</option>
                                <option value='Akrotiri'>Akrotiri</option>
                                <option value='Albania'>Albania</option>
                                <option value='Algeria'>Algeria</option>
                                <option value='American Samoa'>American Samoa</option>
                                <option value='Andorra'>Andorra</option>
                                <option value='Angola'>Angola</option>
                                <option value='Anguilla'>Anguilla</option>
                                <option value='Antarctica'>Antarctica</option>
                                <option value='Antigua and Barbuda'>Antigua and Barbuda</option>
                                <option value='Argentina'>Argentina</option>
                                <option value='Armenia'>Armenia</option>
                                <option value='Aruba'>Aruba</option>
                                <option value='Ashmore and Cartier Islands'>Ashmore and Cartier Islands</option>
                                <option value='Australia'>Australia</option>
                                <option value='Austria'>Austria</option>
                                <option value='Azerbaijan'>Azerbaijan</option>
                                <option value='Bahamas, The'>Bahamas, The</option>
                                <option value='Bahrain'>Bahrain</option>
                                <option value='Bangladesh'>Bangladesh</option>
                                <option value='Barbados'>Barbados</option>
                                <option value='Bassas da India'>Bassas da India</option>
                                <option value='Belarus'>Belarus</option>
                                <option value='Belgium'>Belgium</option>
                                <option value='Belize'>Belize</option>
                                <option value='Benin'>Benin</option>
                                <option value='Bermuda'>Bermuda</option>
                                <option value='Bhutan'>Bhutan</option>
                                <option value='Bolivia'>Bolivia</option>
                                <option value='Bosnia and Herzegovina'>Bosnia and Herzegovina</option>
                                <option value='Botswana'>Botswana</option>
                                <option value='Bouvet Island'>Bouvet Island</option>
                                <option value='Brazil'>Brazil</option>
                                <option value='British Indian Ocean Territory'>British Indian Ocean Territory</option>
                                <option value='British Virgin Islands'>British Virgin Islands</option>
                                <option value='Brunei'>Brunei</option>
                                <option value='Bulgaria'>Bulgaria</option>
                                <option value='Burkina Faso'>Burkina Faso</option>
                                <option value='Burma'>Burma</option>
                                <option value='Burundi'>Burundi</option>
                                <option value='Cambodia'>Cambodia</option>
                                <option value='Cameroon'>Cameroon</option>
                                <option value='Canada'>Canada</option>
                                <option value='Cape Verde'>Cape Verde</option>
                                <option value='Cayman Islands'>Cayman Islands</option>
                                <option value='Central African Republic'>Central African Republic</option>
                                <option value='Chad'>Chad</option>
                                <option value='Chile'>Chile</option>
                                <option value='China'>China</option>
                                <option value='Christmas Island'>Christmas Island</option>
                                <option value='Clipperton Island'>Clipperton Island</option>
                                <option value='Cocos (Keeling) Islands'>Cocos (Keeling) Islands</option>
                                <option value='Colombia'>Colombia</option>
                                <option value='Comoros'>Comoros</option>
                                <option value='Congo, Democratic Republic of the'>Congo, Democratic Republic of the
                                </option>
                                <option value='Congo, Republic of the'>Congo, Republic of the</option>
                                <option value='Cook Islands'>Cook Islands</option>
                                <option value='Coral Sea Islands'>Coral Sea Islands</option>
                                <option value='Costa Rica'>Costa Rica</option>
                                <option value='Cote d Ivoire'>Cote d'Ivoire</option>
                                <option value='Croatia'>Croatia</option>
                                <option value='Cuba'>Cuba</option>
                                <option value='Cyprus'>Cyprus</option>
                                <option value='Czech Republic'>Czech Republic</option>
                                <option value='Denmark'>Denmark</option>
                                <option value='Dhekelia'>Dhekelia</option>
                                <option value='Djibouti'>Djibouti</option>
                                <option value='Dominica'>Dominica</option>
                                <option value='Dominican Republic'>Dominican Republic</option>
                                <option value='Ecuador'>Ecuador</option>
                                <option value='Egypt'>Egypt</option>
                                <option value='El Salvador'>El Salvador</option>
                                <option value='Equatorial Guinea'>Equatorial Guinea</option>
                                <option value='Eritrea'>Eritrea</option>
                                <option value='Estonia'>Estonia</option>
                                <option value='Ethiopia'>Ethiopia</option>
                                <option value='Europa Island'>Europa Island</option>
                                <option value='Falkland Islands (Islas Malvinas)'>Falkland Islands (Islas Malvinas)
                                </option>
                                <option value='Faroe Islands'>Faroe Islands</option>
                                <option value='Fiji'>Fiji</option>
                                <option value='Finland'>Finland</option>
                                <option value='France'>France</option>
                                <option value='French Guiana'>French Guiana</option>
                                <option value='French Polynesia'>French Polynesia</option>
                                <option value='French Southern and Antarctic Lands'>French Southern and Antarctic Lands
                                </option>
                                <option value='Gabon'>Gabon</option>
                                <option value='Gambia, The'>Gambia, The</option>
                                <option value='Gaza Strip'>Gaza Strip</option>
                                <option value='Georgia'>Georgia</option>
                                <option value='Germany'>Germany</option>
                                <option value='Ghana'>Ghana</option>
                                <option value='Gibraltar'>Gibraltar</option>
                                <option value='Glorioso Islands'>Glorioso Islands</option>
                                <option value='Greece'>Greece</option>
                                <option value='Greenland'>Greenland</option>
                                <option value='Grenada'>Grenada</option>
                                <option value='Guadeloupe'>Guadeloupe</option>
                                <option value='Guam'>Guam</option>
                                <option value='Guatemala'>Guatemala</option>
                                <option value='Guernsey'>Guernsey</option>
                                <option value='Guinea'>Guinea</option>
                                <option value='Guinea-Bissau'>Guinea-Bissau</option>
                                <option value='Guyana'>Guyana</option>
                                <option value='Haiti'>Haiti</option>
                                <option value='Heard Island and McDonald Islands'>Heard Island and McDonald Islands
                                </option>
                                <option value='Holy See (Vatican City)'>Holy See (Vatican City)</option>
                                <option value='Honduras'>Honduras</option>
                                <option value='Hong Kong'>Hong Kong</option>
                                <option value='Hungary'>Hungary</option>
                                <option value='Iceland'>Iceland</option>
                                <option value='India'>India</option>
                                <option value='Indonesia'>Indonesia</option>
                                <option value='Iran'>Iran</option>
                                <option value='Iraq'>Iraq</option>
                                <option value='Ireland'>Ireland</option>
                                <option value='Isle of Man'>Isle of Man</option>
                                <option value='Israel'>Israel</option>
                                <option value='Italy'>Italy</option>
                                <option value='Jamaica'>Jamaica</option>
                                <option value='Jan Mayen'>Jan Mayen</option>
                                <option value='Japan'>Japan</option>
                                <option value='Jersey'>Jersey</option>
                                <option value='Jordan'>Jordan</option>
                                <option value='Juan de Nova Island'>Juan de Nova Island</option>
                                <option value='Kazakhstan'>Kazakhstan</option>
                                <option value='Kenya'>Kenya</option>
                                <option value='Kiribati'>Kiribati</option>
                                <option value='Korea, North'>Korea, North</option>
                                <option value='Korea, South'>Korea, South</option>
                                <option value='Kuwait'>Kuwait</option>
                                <option value='Kyrgyzstan'>Kyrgyzstan</option>
                                <option value='Laos'>Laos</option>
                                <option value='Latvia'>Latvia</option>
                                <option value='Lebanon'>Lebanon</option>
                                <option value='Lesotho'>Lesotho</option>
                                <option value='Liberia'>Liberia</option>
                                <option value='Libya'>Libya</option>
                                <option value='Liechtenstein'>Liechtenstein</option>
                                <option value='Lithuania'>Lithuania</option>
                                <option value='Luxembourg'>Luxembourg</option>
                                <option value='Macau'>Macau</option>
                                <option value='Macedonia'>Macedonia</option>
                                <option value='Madagascar'>Madagascar</option>
                                <option value='Malawi'>Malawi</option>
                                <option value='Malaysia'>Malaysia</option>
                                <option value='Maldives'>Maldives</option>
                                <option value='Mali'>Mali</option>
                                <option value='Malta'>Malta</option>
                                <option value='Marshall Islands'>Marshall Islands</option>
                                <option value='Martinique'>Martinique</option>
                                <option value='Mauritania'>Mauritania</option>
                                <option value='Mauritius'>Mauritius</option>
                                <option value='Mayotte'>Mayotte</option>
                                <option value='Mexico'>Mexico</option>
                                <option value='Micronesia, Federated States of'>Micronesia, Federated States of</option>
                                <option value='Moldova'>Moldova</option>
                                <option value='Monaco'>Monaco</option>
                                <option value='Mongolia'>Mongolia</option>
                                <option value='Montserrat'>Montserrat</option>
                                <option value='Morocco'>Morocco</option>
                                <option value='Mozambique'>Mozambique</option>
                                <option value='Namibia'>Namibia</option>
                                <option value='Nauru'>Nauru</option>
                                <option value='Navassa Island'>Navassa Island</option>
                                <option value='Nepal'>Nepal</option>
                                <option value='Netherlands'>Netherlands</option>
                                <option value='Netherlands Antilles'>Netherlands Antilles</option>
                                <option value='New Caledonia'>New Caledonia</option>
                                <option value='New Zealand'>New Zealand</option>
                                <option value='Nicaragua'>Nicaragua</option>
                                <option value='Niger'>Niger</option>
                                <option value='Nigeria'>Nigeria</option>
                                <option value='Niue'>Niue</option>
                                <option value='Norfolk Island'>Norfolk Island</option>
                                <option value='Northern Mariana Islands'>Northern Mariana Islands</option>
                                <option value='Norway'>Norway</option>
                                <option value='Oman'>Oman</option>
                                <option value='Pakistan'>Pakistan</option>
                                <option value='Palau'>Palau</option>
                                <option value='Panama'>Panama</option>
                                <option value='Papua New Guinea'>Papua New Guinea</option>
                                <option value='Paracel Islands'>Paracel Islands</option>
                                <option value='Paraguay'>Paraguay</option>
                                <option value='Peru'>Peru</option>
                                <option value='Philippines'>Philippines</option>
                                <option value='Pitcairn Islands'>Pitcairn Islands</option>
                                <option value='Poland'>Poland</option>
                                <option value='Portugal'>Portugal</option>
                                <option value='Puerto Rico'>Puerto Rico</option>
                                <option value='Qatar'>Qatar</option>
                                <option value='Reunion'>Reunion</option>
                                <option value='Romania'>Romania</option>
                                <option value='Russia'>Russia</option>
                                <option value='Rwanda'>Rwanda</option>
                                <option value='Saint Helena'>Saint Helena</option>
                                <option value='Saint Kitts and Nevis'>Saint Kitts and Nevis</option>
                                <option value='Saint Lucia'>Saint Lucia</option>
                                <option value='Saint Pierre and Miquelon'>Saint Pierre and Miquelon</option>
                                <option value='Saint Vincent and the Grenadines'>Saint Vincent and the Grenadines
                                </option>
                                <option value='Samoa'>Samoa</option>
                                <option value='San Marino'>San Marino</option>
                                <option value='Sao Tome and Principe'>Sao Tome and Principe</option>
                                <option value='Saudi Arabia'>Saudi Arabia</option>
                                <option value='Senegal'>Senegal</option>
                                <option value='Serbia and Montenegro'>Serbia and Montenegro</option>
                                <option value='Seychelles'>Seychelles</option>
                                <option value='Sierra Leone'>Sierra Leone</option>
                                <option value='Singapore'>Singapore</option>
                                <option value='Slovakia'>Slovakia</option>
                                <option value='Slovenia'>Slovenia</option>
                                <option value='Solomon Islands'>Solomon Islands</option>
                                <option value='Somalia'>Somalia</option>
                                <option value='South Georgia and the South Sandwich Islands'>South Georgia and the South
                                    Sandwich
                                    Islands</option>
                                <option value='Spain'>Spain</option>
                                <option value='Spratly Islands'>Spratly Islands</option>
                                <option value='Sri Lanka'>Sri Lanka</option>
                                <option value='Sudan'>Sudan</option>
                                <option value='Suriname'>Suriname</option>
                                <option value='Svalbard'>Svalbard</option>
                                <option value='Swaziland'>Swaziland</option>
                                <option value='Sweden'>Sweden</option>
                                <option value='Switzerland'>Switzerland</option>
                                <option value='Syria'>Syria</option>
                                <option value='Taiwan'>Taiwan</option>
                                <option value='Tajikistan'>Tajikistan</option>
                                <option value='Tanzania'>Tanzania</option>
                                <option value='Thailand'>Thailand</option>
                                <option value='Timor-Leste'>Timor-Leste</option>
                                <option value='Togo'>Togo</option>
                                <option value='Tokelau'>Tokelau</option>
                                <option value='Tonga'>Tonga</option>
                                <option value='Trinidad and Tobago'>Trinidad and Tobago</option>
                                <option value='Tromelin Island'>Tromelin Island</option>
                                <option value='Tunisia'>Tunisia</option>
                                <option value='Turkey'>Turkey</option>
                                <option value='Turkmenistan'>Turkmenistan</option>
                                <option value='Turks and Caicos Islands'>Turks and Caicos Islands</option>
                                <option value='Tuvalu'>Tuvalu</option>
                                <option value='Uganda'>Uganda</option>
                                <option value='Ukraine'>Ukraine</option>
                                <option value='United Arab Emirates'>United Arab Emirates</option>
                                <option value='United Kingdom'>United Kingdom</option>
                                <option value='United States'>United States</option>
                                <option value='Uruguay'>Uruguay</option>
                                <option value='Uzbekistan'>Uzbekistan</option>
                                <option value='Vanuatu'>Vanuatu</option>
                                <option value='Venezuela'>Venezuela</option>
                                <option value='Vietnam'>Vietnam</option>
                                <option value='Virgin Islands'>Virgin Islands</option>
                                <option value='Wake Island'>Wake Island</option>
                                <option value='Wallis and Futuna'>Wallis and Futuna</option>
                                <option value='West Bank'>West Bank</option>
                                <option value='Western Sahara'>Western Sahara</option>
                                <option value='Yemen'>Yemen</option>
                                <option value='Zambia'>Zambia</option>
                                <option value='Zimbabwe'>Zimbabwe</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
              <input class="form-control-text-input p-4" type="text" name="reg-username" id="reg-username"
                placeholder="Username (Required)" required />
            </div> -->

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-password"
                                style="color: var(--primary-color);">Create your password</label>
                            <input class="form-control-text-input p-4" type="password" name="reg-password"
                                id="reg-password" placeholder="Create your new password." required />
                        </div>

                        <div class="form-group mb-4 text-start">
                            <label class="fw-bold poppins-font" for="reg-confirmpassword"
                                style="color: var(--primary-color);">Repeat your password</label>
                            <input class="form-control-text-input p-4" type="password" name="reg-confirmpassword"
                                id="reg-confirmpassword" placeholder="Let's check if you have it down." required />
                        </div>

                        <div class="text-center d-gridz gap-2 py-2 down-top-grad-tahiti"
                            style="border-radius:0 0 25px 25px;">
                            <button type="submit" class="my-4 p-5 onefit-buttons-style-dark btn-lg shadow-lg"
                                id="signup-btn">
                                <span class="material-icons material-icons-round align-middle"
                                    style="color: var(--primary-color);">
                                    how_to_reg
                                </span>
                                <span class="align-middle"> Create account.</span>
                            </button>
                        </div>
                    </form>

                    <hr class="text-white">

                    <div class="my-4">
                        <!-- Membership Sales Card Grid -->
                        <p class="text-center">Or Sign Up for</p>
                        <h5 class="fs-1 d-grid fw-bold text-center my-4" style="color:var(--white);">
                            <span class="material-icons material-icons-round"
                                style="font-size:80px!important;color: var(--primary-color);">
                                verified_user
                            </span>
                            <span><strong style="color: var(--primary-color);">Pro</strong>.Membership</span>
                        </h5>

                        <!-- multi-collapse left panels to toggle membership plan comparison table -->
                        <button class="onefit-buttons-style-tahiti shadow p-4 mt-0 mb-5" type="button"
                            data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="true"
                            aria-controls="collapseLogoPanel collapsePlanCompTblPanel">
                            Compare Plans.
                        </button>

                        <div class="card-groupz grid-container">
                            <div class="card grid-tile shadow border-5 border-top border-bottom"
                                style="border-color: var(--primary-color)!important;background-color: var(--secondary-color) !important; overflow: hidden;">
                                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Pro.Starter Training (Basic) - 3 Months</h5>
                                    <p class="card-text">The Indi.Starter account offers Trainees access to Curated
                                        Premium Fitness
                                        Programs from Level-1 to Level-3 of our
                                        Catalogue as well as access to Personal Trainer Support services to make
                                        transitioning into Fitness
                                        Process much easier.</p>
                                </div>
                                <div class="card-footer d-grid">
                                    <button
                                        class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                        R1800 (3 Months)
                                    </button>
                                </div>
                            </div>
                            <div class="card grid-tile shadow border-5 border-top border-bottom"
                                style="border-color: var(--primary-color)!important;background-color: var(--secondary-color) !important; overflow: hidden;">
                                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Pro.Athlete Training (Pro) - 12 Months</h5>
                                    <p class="card-text">This card has supporting text below as a natural lead-in to
                                        additional content.
                                    </p>
                                </div>
                                <div class="card-footer d-grid">
                                    <button
                                        class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                        R5200 (12 Months)
                                    </button>
                                </div>
                            </div>
                            <div class="card wide-grid-tile grid-tile shadow border-5 border-top border-bottom"
                                style="border-color: var(--primary-color)!important;background-color: var(--secondary-color) !important; overflow: hidden;">
                                <img src="../media/assets/OnefitNet Profile Pic Redone.png" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Teams.Pro Training (Pro) - Contact Sales</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to
                                        additional
                                        content.
                                        This card has even longer content than the first to show that equal height
                                        action.</p>
                                </div>
                                <div class="card-footer d-grid">
                                    <button
                                        class="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                                        Contact Sales
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Membership Sales Card Grid -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="text-center fixed-bottom p-4" style="background: #ffa500; color: var(--secondary-color)" hidden>
        <p>Crafted by AdaptivConcept FL &copy; 2021. All rights reserved.</p>
    </div>

    <script>
    var signinbtn = document.getElementById("signup-btn");
    //signupbtn.addEventListener("click", signin);

    document.getElementById("output-container").addEventListener("click", function() {
        document.getElementById("output-container").style.display = "none";
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>