<?php
session_start();
require_once("./scripts/php/functions.php");

// check if remeberMe cookie exists, if true then try to auto-authenticate the user, else do nothing
rememberMe();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Onefit.app | OnefitNet &copy; 2022</title>

  <!-- My CSS styles -->
  <link rel="stylesheet" href="./css/styles.css" />

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
      coreScriptLoaded_bootstrap_bundle_cdn_js =
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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" onload="coreScriptLoaded_googlefont_icons_css=true;" />

  <!-- Bootstrap local -->
  <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" onload="coreScriptLoaded_bootstrap_local_css=true;">

  <!-- W3 CSS -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" onload="coreScriptLoaded_w3_css=true;" />

  <!-- My CSS styles -->
  <link rel="stylesheet" href="./css/styles.css" onload="coreScriptLoaded_custom_styles_css=true;" />

  <!-- JQuery local -->
  <script src="./node_modules/jquery/dist/jquery.min.js" onload="coreScriptLoaded_jquery_local_js=true;"></script>

  <!-- JQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" onload="coreScriptLoaded_custom_jquery_func_js=true;"></script>
  <!-- ./ JQuery CDN -->

  <!-- Custom Site Scripts -->
  <script src="./scripts/js/jquery_functions.js" onload="coreScriptLoaded_custom_jquery_func_js=true;"></script>
  <script src="./scripts/js/script.js" onload="coreScriptLoaded_custom_script_js=true;"></script>

</head>

<body class="noselect" onload="toggleLoadCurtain()">

  <!-- Notification Snackbar (mini) -->
  <!-- <button class="btn btn-primary btn-lg" onclick="showSnackbar('notification message here...')">Show Snackbar</button> -->
  <!-- The actual snackbar -->
  <div id="snackbar">No notification.</div>

  <!-- offline Curtain -->
  <div class="offline-curtain" id="offline-curtain" style="display: none;background-color:var(--mineshaft);">
    <div class="d-flex align-items-center down-top-grad-white" style="width: 100%; height: 100%;">
      <div class="text-center w-100">
        <div class="ring d-flex align-items-center p-4 shadow-lg">
          <!-- <span></span> -->
          <div class="d-flex align-items-center justify-content-center" style="width: 100%;">
            <img src="../media/assets/icons/wifi_off_black_24dp.svg" class="img-fluid p-4 rounded-circle text-white border-5 border-white shadow" style="height: 130px;background-color:var(--white)!important;" alt="onefit logo">
            <!-- -->
          </div>
        </div>
      </div>
    </div>
    <nav class="text-center text-center p-4 fixed-bottom" alt="">
      <h1 id="output-msg-heading" class="navbar-brand fs-1 fw-bold comfortaa-font d-grid" style="color: var(--mineshaft);">
        <span class="material-icons material-icons-round align-middle" style="font-size:40px!important;">
          offline_bolt
        </span>
        <span class="align-middle">You are offline.</span>
      </h1>
      <p id="output-msg-text" class="text-center poppins-font" style="color: var(--mineshaft);">Please check your
        internet connection</p>
    </nav>
  </div>
  <!-- ./ offline Curtain -->

  <!-- Load Curtain -->
  <div class="load-curtain" id="LoadCurtain" style="display: block;">
    <div class="d-flex align-items-center top-down-grad-tahiti" style="width: 100%; height: 100%;">
      <div class="text-center w-100">
        <div class="ring d-flex align-items-center p-4 my-pulse-animation-light">
          <!-- <span></span> -->
          <div style="width: 100%;">
            <img src="./media/assets/One-Symbol-Logo-White.svg" class="img-fluid p-4" style="max-height: 20vh;" alt="">
          </div>
        </div>
      </div>
    </div>
    <nav class="text-center text-center p-4 fixed-bottom" alt="">
      <p class="navbar-brand fs-1 text-white comfortaa-font">One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span></p>
      <p class="text-center comfortaa-font" style="font-size: 10px !important;">Loading. Please wait.</p>
    </nav>
  </div>
  <!-- ./Load Curtain -->

  <!-- Navigation bar -->
  <nav class="navbar navbar-light stickyz fixed-top navbar-style bg-transparent top-down-grad-dark" style="z-index: 10000;">
    <div class="container-fluid">
      <a class="navbar-brand fs-1 text-white comfortaa-font" href="#">One<span style="color: #ffa500">fit</span>.app<span style="font-size: 10px">&trade;</span></a>
      <button class="navbar-toggler shadow onefit-buttons-style-dark bg-transparent p-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <!--<span class="navbar-toggler-icon"></span>-->
        <!--<img src="./media/assets/One-Symbol-Logo-Two-Tone.svg" alt="" class="img-fluid logo-size-1" />-->
        <span class="material-icons material-icons-round align-middle" style="font-size: 28px!important;"> public
          <!-- menu_open --> </span>
      </button>
      <div class="offcanvas offcanvas-end offcanvas-menu-primary-style" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div id="offcanvas-menu" class="pb-4" style="border-radius: 0 0 25px 25px; overflow: hidden;">
          <div class="offcanvas-header fs-1" style="background-color: #343434; color: #fff">
            <img src="./media/assets/One-Logo.svg" alt="" class="img-fluid logo-size-2" style="max-width:100px;">
            <h5 class="offcanvas-title text-center" id="offcanvasNavbarLabel">
              <span class="material-icons material-icons-round align-middle" style="color: #ffa500; cursor: pointer;font-size:20px!important;">
                public
              </span>
              Web.
            </h5>
            <button type="button" class="onefit-buttons-style-light shadow p-4" data-bs-dismiss="offcanvas" aria-label="Close">
              <span class="material-icons material-icons-round align-middle"> close </span>
            </button>
          </div>
          <div class="offcanvas-body pb-4 top-down-grad-dark" style="max-height: 80vh;">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 comfortaa-font fs-3 h-100" style="overflow-y: auto;">
              <li class="nav-item d-grid">
                <p class="text-white text-center" style="font-size:10px;">Get started with your fitness journey by
                  signing up for a free community account or subscribe to our Premium offering to get access to
                  Pro.Athlete level fitness tracking resources, guides, physical trainer and community support.</p>
                <a class="onefit-buttons-style-light p-4 text-center text-decoration-none shadow fw-bold fs-5" href="registration/" style="border-radius: 25px !important; font-size: 20px !important;transform:scale(1)!important;color:var(--mineshaft)!important;">Register
                  your account.<!-- <span class="material-icons material-icons-round align-middle"
                    style="font-size: 25px !important; color: #ffa500;">
                    login
                  </span> -->
                  <i class="fas fa-file-signature"></i>
                </a>
              </li>
              <hr class="text-white">
              <li class="nav-item">
                <a class="nav-link active p-4" aria-current="page" href="#" style="border-radius: 25px !important;">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" href="https://onefitnet.co.za/about/" target="_blank" style="border-radius: 25px !important;">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" href="https://onefitnet.co.za/services/" target="_blank" style="border-radius: 25px !important;">Services</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" href="https://onefitnet.co.za/contact/" target="_blank" style="border-radius: 25px !important;">Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" href="https://onefitnet.co.za/blog/" target="_blank" style="border-radius: 25px !important;">Onefit.Edu™ (Blog)</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-4" href="https://onefitnet.co.za/store/" target="_blank" style="border-radius: 25px !important;">Onefit.Store™</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- ./ Navigation bar -->

  <!-- Onefit.app Logo 
    <hr class="text-white" />-->

  <div class="text-center pb-4" style="padding-top: 150px;">
    <div class="d-grid mb-2 w3-animate-top">
      <p class="text-white comfortaa-font fs-4 mb-0 fw-bold"> Presented by </p>
      <p class="text-white audiowide-font mt-1 mb-4 fw-bold" style="font-size: 8px !important;"> <span style="color: #ffa500;">One</span>-On-<span style="color: #ffa500;">One</span> Fitness
        Network<sup style="color: #ffa500;">&reg;</sup>
      </p>

      <!-- <i class="fas fa-grip-lines -vertical text-white"></i> -->
      <span class="material-icons material-icons-round" style="color: #ffa500; cursor: pointer;">
        public
      </span>
    </div>

    <img src="./media/assets/One-Logo-Vertical.svg" class="border-5 border-start border-end p-4" alt="Onefit™.app Logo" style="max-height: 50vh; width: auto !important; border-radius: 25px; background-color: #343434;">
  </div>

  <hr class="text-white" style="height: 50px" />
  <!-- Onefit.app Logo -->

  <div class="text-center p-4" style="background-color: rgba(52, 52, 52, 0.8); margin: 40px 0;">
    <span class="material-icons material-icons-round" style="font-size: 100px!important;color: #fff!important;">
      fingerprint </span>

    <h1 class="down-top-grad-dark py-0 px-4" style="color: #fff; font-size: 40px; border-radius: 00 25px 25px !important;">Sign into your Account<span style="color: #ffa500;">.</span></h1>
  </div>

  <!-- User Sign in Section -->
  <div class="container-fluid m-0 down-top-grad-dark">
    <div class="container text-center text-white mt-4" style="min-height: 100vh; padding-bottom: 10vh">

      <div class="row align-items-center my-4 px-4" style="border-radius: 25px; background-color: rgba(52, 52, 52, 0.8)">
        <div class="col-sm py-4">
          <form class="text-center text-white comfortaa-font align-middle" method="post" action="./scripts/php/main_app/compile_content/profile_tab/login.php" autocomplete="off">
            <!--target="_blank"-->
            <div class="mb-4 p-4 text-white" id="error-output"></div>
            <div class="mb-3">
              <label for="onefitUserEmail" class="form-label fs-4">Email address</label>
              <input type="email" class="form-controlz form-control-text-input shadow p-2" id="onefitUserEmail" name="onefitUserEmail" aria-describedby="emailHelp" />
            </div>
            <div class="mb-4">
              <label for="onefitUserPassword" class="form-label fs-4">Password</label>
              <input type="password" class="form-controlz form-control-text-input shadow text-center p-2" id="onefitUserPassword" name="onefitUserPassword" />
              <div class="text-center mt-3">
                <a href="" class="comfortaa-font fw-bold tahiti-links" style="font-size: 10px;">Forgot
                  Password?</a>
              </div>
            </div>
            <div class="my-4 form-check d-flex gap-2 text-center justify-content-center">
              <input type="checkbox" class="form-check-input me-1" id="keep-me-signed-in" />
              <label class="form-check-label text-center pt-2" for="keep-me-signed-in">Keep me signed in?</label>
            </div>
            <div class="mt-4 d-grid gap-2">
              <button type="submit" class="btn onefit-buttons-style-light shadow align-items-center p-4" onclick="toggleLoadCurtain()">
                <span class="align-middle" style="font-size: 20px !important;">
                  <span class="align-middle">Sign in.</span>

                  <span class="material-icons material-icons-round align-middle" style="font-size: 25px !important; color: #ffa500;">
                    login
                  </span>
                </span>
              </button>
            </div>
          </form>
        </div>

        <div class="col-sm py-4 darkpads-bg-container shadow border-5 border-start border-end" style="border-radius: 25px; color: #fff">
          <div class="d-grid gap-2">
            <button class="onefit-buttons-style-light py-4 shadow comfortaa-font" onclick="showSnackbar('Google API is not available at the moment. Please use your email to login.')">
              <i class="fab fa-google"></i>
              Sign in with
              <strong class="fs-5 poppins-font">
                <span style="color: #4285F4;">G</span><span style="color: #DB4437;">o</span><span style="color: #F4B400;">o</span><span style="color: #4285F4;">g</span><span style="color: #0F9D58;">l</span><span style="color: #DB4437;">e</span>
              </strong>
            </button>
            <button class="onefit-buttons-style-light py-4 shadow comfortaa-font" onclick="showSnackbar('Twitter API is not available at the moment. Please use your email to login.')">
              <i class="fab fa-twitter"></i>
              Sign in with
              <strong class="fs-5 poppins-font">
                <span style="color: #1DA1F2;">Twitter</span>
              </strong>
            </button>
            <button class="onefit-buttons-style-light py-4 shadow comfortaa-font" onclick="showSnackbar('Facebook API is not available at the moment. Please use your email to login.')">
              <i class="fab fa-facebook"></i> Sign in with
              <strong class="fs-5 poppins-font">
                <span style="color: #4267B2;">Facebook</span>
              </strong>
            </button>

            <hr class="text-white" />

            <a href="registration/" class="onefit-buttons-style-dark fw-bold p-4 comfortaa-font align-end" style="text-decoration: none;">Or
              Create an Account.
              <span class="material-icons material-icons-round align-middle" style="font-size: 20px !important; color: var(--tahitigold);">
                person_add
              </span>
            </a>
          </div>
        </div>
      </div>

      <!-- Carousal -->
      <div class="container-fluid m-0 p-4">
        <span class="material-icons material-icons-outlined"> tv </span>
        <p style="font-size: 10px">Latest Training Programs | <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span></p>

        <div class="video-card-container">
          <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="" class="img-fluid shadow" />
          <button class="onefit-buttons-style-light shadow play-btn p-3" onclick="playVideo()">
            <span class="material-icons material-icons-round" style="font-size: 40px !important;">
              play_circle_outline
            </span>
          </button>
        </div>
      </div>
      <!-- ./ Carousal -->
    </div>
  </div>

  <!-- / User Sign in Section -->

  <!-- Main Content -->
  <div class="container-fluid">
    <div class="row align-items-center text-white py-4" style="background-color: rgba(52, 52, 52, 0.9)">
      <div class="col-md py-4">
        <div class="content-panel-border-style p-4 tunnel-bg text-center" style="border-radius: 25px">
          <div class="my-2 pt-4 site-description text-center">
            <h1>Welcome to the One<span style="color: #ffa500 !important">fit</span><span style="font-size: 10px">&trade;</span> Community.</h1>
            <p class="mt-2 p-4 comfortaa-font">
              One<span style="color: #ffa500 !important">fit</span><span style="font-size: 10px">&trade;</span> is a
              community based fitness, wellness and lifestyle platform. We aim to assist people from all backgrounds
              find a better state of being by accessing inspirational and instructional resources, connecting trainers
              with trainees and developing fitness groups in all spheres of physical activity and athletisism. We will
              help you reach your fitness goals, find friends, obtain knowledge about uplifting yourself. Register an
              account today to get a personalized training and eating plans from professional trainers and dieticians
              as
              well as resources from health professionals. Proudly brought to you by AdaptivConcept (Media), LMM
              1-ON-1
              Trainer and One-On-One Fitness Network. &copy; 2021
            </p>
          </div>
          <img src="./media/assets/OnefitNet Profile Pic Redone.png" class="img-fluid my-4 shadow" alt="one fitness" style="max-height: 50vh; border-radius: 25px" />
          <p class="my-4 text-center comfortaa-font" style="font-size: 10px">Crafted by AdaptivConcept&trade; NPC,
            <br />in Partneship
            with One-On-One Fitness Network | &copy; 2021
          </p>
          <hr class="text-white" />
        </div>
      </div>
      <div class="col-md py-4 text-center" style="overflow-y: auto; overflow-x: hidden">
        <!--<div class="content-panel-border-style login-form tunnel-bg mb-4 shadow" style="width: 100%">
            <h2 class="text-center pt-4" style="color: #ffa500">Sign In</h2>
            <hr class="mx-4 bg-white" />

            <form class="text-center px-4 pb-4 pt-0">
              <div class="output-container my-2" id="output-container"></div>

              <div class="form-group my-4">
                <input type="text" id="username" placeholder="username/email" />
              </div>

              <div class="form-group">
                <input type="password" id="password" placeholder="password" />
              </div>
              <a href="" class="forgot-password">Forgot password?</a>
            </form>
            <div class="text-center">
              <button type="button" class="mb-4" id="signin-btn"><i class="fas fa-sign-in-alt" style="color: #ffa500"></i> Sign In</button>
            </div>
            <div class="text-center">
              <button type="button" class="mb-4" id="signup-btn"><i class="fas fa-file-signature" style="color: #ffa500"></i> Don't have an account? Sign Up Now</button>
            </div>
          </div>-->

        <div class="content-panel-border-style p-4 tunnel-bg -white shadow" style="border-radius: 25px">
          <h2 class="text-center mt-4" style="color: #ffa500">Social</h2>
          <hr class="bg-warning" />

          <h5 class="mt-4 text-center"><i class="fab fa-twitter"></i> Twitter Feed</h5>

          <!--<a class="twitter-timeline" href="https://twitter.com/tweet_shurriken?ref_src=twsrc%5Etfw">Tweets by tweet_shurriken</a>-->
          <div class="pb-4 no-scroller d-grid" style="border-radius: 25px !important; overflow-y: scroll; max-height: 90vh">
            <a class="twitter-timeline" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by
              <span style="color: var(--tahitigold)!important;">@OnefitNet</span></a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
            <div class="d-flex justify-content-center">
              <div class="spinner-border grow text-light my-4" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ./ Main Content -->

  <!-- Footer -->

  <div class="navbar navbar-dark fixed-bottom navbar-stylez down-top-grad-dark py-4 justify-content-center">
    <div class="collapse w-100z fitness-bg-containerz darkpads-bg-container no-scroller shadow -lg border-5 border-start border-end mx-4 px-4" style="max-height: 90vh !important; overflow-y: auto; border-radius: 25px; border-color: #ffa500 !important; margin-bottom: 40px; padding-top: 100px;" id="navbarToggleExternalContent">
      <div class="p-4 top-down-grad-dark" style="border-radius: 25px;">
        <div class="text-center pt-4 mb-4">
          <img src="./media/assets/One-Symbol-Logo-White.svg" alt="logo" class="img-fluid my-4 p-4 my-pulse-animation-light" style="max-width: 100px;border-radius: 50%;">
        </div>


        <!-- Onefit.TV Horizontal Content Stream -->
        <div class="mb-4" id="onefittv-footer-h-content-stream">
          <div class="content-panel-border-stylez p-4 shadow border-5 border-start border-end text-white" style="padding-bottom: 40px; border-radius: 25px; background-color: #343434; border-color: #ffa500 !important;">

            <h5 class="fs-1 h4 aligh-middle d-grid text-center" style="color: #ffa500;">
              <span class="material-icons material-icons-outlined" style="color: #fff;"> tv </span>
              <span>OnefitNet.TV</span>
            </h5>
            <hr class="text-white" />

            <p class="my-4 text-center" style=" font-size: 10px">Latest Training Programs | <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span></p>

            <div class="d-lg-none w3-animate-bottom">
              <!-- d-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none -->
              <!-- <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid"
                > -->

              <div class="video-card-container">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="latest video" class="img-fluid shadow mb-4" style="border-radius: 15px;" />
                <button class="onefit-buttons-style-light shadow-lg play-btn p-2 aligh-middle" onclick="playVideo()">
                  <span class="material-icons material-icons-round aligh-middle" style="font-size: 20px !important;">
                    play_circle_outline
                  </span>
                </button>
              </div>

              <div class="d-grid mt-4 w-100 justify-content-center">
                <button class="onefit-buttons-style-dark shadow d-grid p-4 comfortaa-font text-center aligh-middle position-relative">
                  <span>View Playlist.</span>
                  <span class="material-icons material-icons-round aligh-middle">playlist_play</span>

                  <span class="position-absolute top-0 start-100 translate-middle p-2 comfortaa-font border border-light rounded-pill align-middle shadow" style="background-color: #343434 !important; color: #ffa500 !important; border-color: #ffa500 !important;">
                    <span class="align-middle" style="font-size: 10px !important;">+3</span>
                    <span class="visually-hidden">Latest Video Count</span>
                  </span>
                </button>
              </div>
            </div>


            <div class="horizontal-scroll d-none d-lg-block w3-animate-bottom">
              <div class="horizontal-scroll-card p-4">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2 text-center">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.1 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                      Category: Resistence
                    </p>

                    <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                      Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="horizontal-scroll-card p-4">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2 text-center">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                      Category: Resistence
                    </p>

                    <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                      Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="horizontal-scroll-card p-4">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2 text-center">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                      Category: Resistence
                    </p>

                    <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                      Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="horizontal-scroll-card p-4">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2 text-center">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                      Category: Resistence
                    </p>

                    <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                      Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </div>

              <div class="horizontal-scroll-card p-4">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4" style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2 text-center">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder" style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">timer</span> Duration: 1 hour</p>
                    <p class="align-middle comfortaa-font"><span class="material-icons material-icons-round" style="font-size: 20px !important;">category</span>
                      Category: Resistence
                    </p>

                    <button class="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                      Subscribe on <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>


            <!-- <ol class="list-group list-group-numberedz bg-transparent no-scroller horizontal-scroll"
              style="max-height: 80vh !important; overflow-y: auto;">
              <li class="list-group-item bg-transparentz border-0 general-dark-link-item shadow my-2"
                style="cursor: pointer" onClick="launchLink('www.google.com')">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4"
                  style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder"
                      style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.1 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <button class="onefit-buttons-style-dark shadow p-4 comfortaa-font">
                      Subscribe to <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </li>
              <li class="list-group-item bg-transparentz border-0 general-dark-link-item shadow my-2"
                style="cursor: pointer" onClick="launchLink('www.google.com')">
                <img src="./media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder" class="img-fluid mb-4"
                  style="border-radius: 25px;">
                <hr class="text-white" style="height: 5px;">

                <div class="row my-2 align-items-center">
                  <div class="col-sm-2">
                    <img src="./media/assets/icons/icons8-sports-mode-50.png" class="img-fluid p-4" alt="placeholder"
                      style="border-radius: 5px; background-color: #ffa500;">
                  </div>
                  <div class="col-sm">
                    <h5>Ep.2 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                    <button class="onefit-buttons-style-dark shadow p-4 comfortaa-font">
                      Subscribe to <span class="comfortaa-font" style="color: #ffa500">OnefitNet.TV</span>
                    </button>
                  </div>
                </div>
              </li>
            </ol> -->
          </div>
        </div>
        <!-- ./ Onefit.TV Horizontal Content Stream -->

        <div class="row mt-4 text-center align-items-startz">

          <div class="col-lg mb-4">
            <div class="content-panel-border-style p-4 h-100" style="padding-bottom: 40px; border-radius: 25px; background-color: #343434;">
              <span class="material-icons material-icons-outlined" style="color: #fff;">tag</span>
              <h5 class="fs-1 h4" style="color: #ffa500;">Social</h5>
              <hr class="text-white" />
              <ul class="list-group bg-transparent comfortaa-font">
                <li class="list-group-item bg-transparent border-0 social-link-icon-insta my-2 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  <div class="row align-items-center">
                    <div class="col-4 text-end">
                      <i class="fab fa-instagram" style="font-size: 40px;"></i>
                    </div>
                    <div class="col text-center" style="color: #ffa500;">
                      |
                    </div>
                    <div class="col text-start">
                      @onefit_net
                    </div>
                  </div>
                </li>
                <li class="list-group-item bg-transparent border-0 social-link-icon-twitter my-2 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  <div class="row align-items-center">
                    <div class="col-4 text-end">
                      <i class="fab fa-twitter" style="font-size: 40px;"></i>
                    </div>
                    <div class="col text-center" style="color: #ffa500;">
                      |
                    </div>
                    <div class="col text-start">
                      @onefitnet_za
                    </div>
                  </div>
                </li>
                <li class="list-group-item bg-transparent border-0 social-link-icon-fb my-2 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  <div class="row align-items-center">
                    <div class="col-4 text-end">
                      <i class="fab fa-facebook" style="font-size: 40px;"></i>
                    </div>
                    <div class="col text-center" style="color: #ffa500;">
                      |
                    </div>
                    <div class="col text-start">
                      /OnefitNetwork
                    </div>
                  </div>
                </li>
                <li class="list-group-item bg-transparent border-0 social-link-icon-yt my-2 shadow" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  <div class="row align-items-center">
                    <div class="col-4 text-end">
                      <i class="fab fa-youtube" style="font-size: 40px;"></i>
                    </div>
                    <div class="col text-center" style="color: #ffa500;">
                      |
                    </div>
                    <div class="col text-start">
                      OnefitNet.TV
                    </div>
                  </div>
                </li>
              </ul>

              <span class="material-icons material-icons-outlined mt-4" style="color: #fff;">error_outline</span>
              <h5 class="fs-1 h4" style="color: #ffa500;">Important</h5>
              <hr class="text-white" />
              <ul class="list-group bg-transparent comfortaa-font">
                <li class="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  Our COVID-19 Responsibility
                </li>
                <li class="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  Privacy Policy
                </li>
                <li class="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  Terms of use
                </li>
                <li class="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4" style="cursor: pointer" onClick="launchLink('www.google.com')">
                  Refund Policy
                </li>
              </ul>
            </div>
          </div>
          <div class="col-lg mb-4">
            <div class="content-panel-border-style p-4 h-100" style="padding-bottom: 40px; border-radius: 25px; background-color: #343434;">
              <span class="material-icons material-icons-outlined" style="color: #fff;">touch_app</span>
              <h5 class="fs-1 h4" style="color: #ffa500;">Navigation</h5>
              <hr class="text-white" />
              <ul class="list-group justify-content-end flex-grow-1z pe-3 comfortaa-font fs-3">
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center" href="#">Home</button>
                </li>
                <li class="my-2 m shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center" href="#">Services</button>
                </li>
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center" href="#">About</button>
                </li>
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center" href="#">Contact</button>
                </li>
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center active" aria-current="page" href="#">Onefit.app&trade;</button>
                </li>
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center" href="#">Onefit.Edu&trade;
                    (Blog)</button>
                </li>
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <button class="nav-link onefit-buttons-style-dark p-4 text-center" href="#">Onefit.Shop&trade;</button>
                </li>
                <hr class="text-dark" />
                <li class="my-2 shadow general-dark-link-itemz d-grid gap-2" style="border-radius: 25px;">
                  <a class="nav-link onefit-buttons-style-dark p-4 text-center" href="registration/" style="border-bottom: 0 !important">Account
                    Registration</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid px-4 align-items-center">
      <button class="navbar-toggler shadow onefit-buttons-style-dark p-3 ms-4z" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <!--<span class="navbar-toggler-icon"></span>-->
        <div class="d-grid">
          <span class="material-icons material-icons-round" style="font-size: 40px !important"> widgets </span>
          <span class="material-icons material-icons-round" style="font-size: 20px !important"> more_horiz </span>
        </div>

      </button>

      <p class="text-white align-end me-4z text-center comfortaa-font py-4 m-0">
        <span style="font-size: 10px;">
          <span>Crafted by AdaptivConcept&trade; NPC &copy; 2022</span> |
        </span>
        <a href="https://www.adaptivconcept.co.za/" target="_blank" class="comfortaa-font" style="color:var(--tahitigold);">Support</a>
      </p>
    </div>
  </div>
  <!-- ./ Footer -->

  <script>
    // coreScriptLoaded_bootstrap_bundle_local_js == false ||
    if (coreScriptLoaded_googlefont_icons_css == false ||
      coreScriptLoaded_plyrio_css == false ||
      coreScriptLoaded_plyrio_js == false ||
      coreScriptLoaded_hls_js == false ||
      coreScriptLoaded_bootstrap_local_css == false ||
      coreScriptLoaded_bootstrap_bundle_cdn_js == false ||
      coreScriptLoaded_w3_css == false ||
      coreScriptLoaded_custom_styles_css == false ||
      coreScriptLoaded_digiclock_css == false ||
      coreScriptLoaded_digiclock_js == false ||
      coreScriptLoaded_timeline_css == false ||
      coreScriptLoaded_custom_jquery_func_js == false ||
      coreScriptLoaded_custom_script_js == false ||
      coreScriptLoaded_custom_api_req_js == false ||
      coreScriptLoaded_jquery_local_js == false ||
      coreScriptLoaded_custom_jquery_func_js == false ||
      coreScriptLoaded_moment_js == false ||
      /* coreScriptLoaded_googlefonts_fonts == false || */
      coreScriptLoaded_googlefonts_css == false ||
      coreScriptLoaded_soccerfield_css == false ||
      coreScriptLoaded_soccerfield_js == false ||
      coreScriptLoaded_chartjs_js == false) {
      console.log("Some core scripts were not loaded. Please check your internet connection. \n" +
        "\n googlefont_icons_css: " + coreScriptLoaded_googlefont_icons_css +
        "\n plyrio_css: " + coreScriptLoaded_plyrio_css +
        "\n plyrio_js: " + coreScriptLoaded_plyrio_js +
        "\n hls_js: " + coreScriptLoaded_hls_js +
        "\n bootstrap_local_css: " + coreScriptLoaded_bootstrap_local_css +
        "\n bootstrap_bundle_cdn_js: " + coreScriptLoaded_bootstrap_bundle_cdn_js +
        "\n w3_css: " + coreScriptLoaded_w3_css +
        "\n custom_styles_css: " + coreScriptLoaded_custom_styles_css +
        "\n digiclock_css: " + coreScriptLoaded_digiclock_css +
        "\n digiclock_js: " + coreScriptLoaded_digiclock_js +
        "\n timeline_css: " + coreScriptLoaded_timeline_css +
        "\n custom_jquery_func_js: " + coreScriptLoaded_custom_jquery_func_js +
        "\n custom_script_js: " + coreScriptLoaded_custom_script_js +
        "\n custom_api_req_js: " + coreScriptLoaded_custom_api_req_js +
        "\n jquery_local_js: " + coreScriptLoaded_jquery_local_js +
        "\n custom_jquery_func_js: " + coreScriptLoaded_custom_jquery_func_js +
        "\n moment_js: " + coreScriptLoaded_moment_js +
        "\n googlefonts_fonts: " + coreScriptLoaded_googlefonts_fonts +
        "\n googlefonts_css: " + coreScriptLoaded_googlefonts_css +
        "\n soccerfield_css: " + coreScriptLoaded_soccerfield_css +
        "\n soccerfield_js: " + coreScriptLoaded_soccerfield_js +
        "\n chartjs_js: " + coreScriptLoaded_chartjs_js);
      // show offline curtain and pass message of none-loaded scripts
      document.getElementById("output-msg-heading").innerHTML = "You are offline.";
      document.getElementById("output-msg-text").innerHTML = "Some core scripts were not loaded. Please check your internet connection and try reloadig the page.<br>If the error persists, please contact <a href='https://help.onefitnet.co.za/systems/?errortype=core_script_error'>support</a>";
      document.getElementById("offline-curtain").style.display = "block";
    }

    // *** perform curtain fade using jQuery instead
    // function toggleLoadCurtain() {
    //   //Show / Hide the Load Curtain Container
    //   var curtain = document.getElementById("LoadCurtain");
    //   var toggleState = curtain.style.display.toString();
    //   // alert("toggleState: " + toggleState);

    //   if (toggleState == "none") {
    //     curtain.style.display = "block";
    //   } else if (toggleState == "block") {
    //     curtain.style.display = "none";
    //   } else {
    //     curtain.style.display = "none";
    //   }
    // }

    function checkLoginReturnParams() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const returnStr = urlParams.get('return');
      const usrnStr = urlParams.get('usrn');

      var errorMsgOutput = document.getElementById('error-output');
      var usernameFld = document.getElementById('onefitUserEmail');

      if (returnStr == "mismatch") {
        // set the usrn value in the username/email address field
        usernameFld.value = usrnStr;
        errorMsgOutput.innerText = "The email address or password you entered is incorrect. Please try again.";
        errorMsgOutput.style.display = "block";
      }
    }

    // hide the loading curtain - fade out jquery
    $('#LoadCurtain').fadeOut('2500');
  </script>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>