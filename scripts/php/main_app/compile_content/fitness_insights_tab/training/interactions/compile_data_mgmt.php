<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    echo <<<_END
    <h1 class="fs-5">Sports Drills</h1>
    <p>Insert Category, Type, and Sport Dropdown list filters here</p>
    <div class="container">
        <div class="grid-container">
            <div class="grid-tile p-4 down-top-grad-white shadow border-5 border-bottom" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;">
                <p class="fs-2 fw-bold comfortaa-font">Warm-Up Drills</p>
            </div>
            <div class="grid-tile p-4 down-top-grad-white shadow border-5 border-bottom" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;">
                <p class="fs-2 fw-bold comfortaa-font">Pair Drills</p>
            </div>
            <div class="grid-tile p-4 down-top-grad-white shadow border-5 border-bottom" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;">
                <p class="fs-2 fw-bold comfortaa-font">Speed &amp; Reaction Drills</p>
            </div>
            <div class="grid-tile p-4 down-top-grad-white shadow border-5 border-bottom" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;">
                <p class="fs-2 fw-bold comfortaa-font">Dribbling Drills</p>
            </div>
            <div class="grid-tile p-4 down-top-grad-white shadow border-5 border-bottom" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;">
                <p class="fs-2 fw-bold comfortaa-font">Shooting Drills</p>
            </div>
            <div class="grid-tile p-4 down-top-grad-tahiti shadow border-5 border-bottom" style="border-radius: 0 0 25px 25px;border-color: var(--tahitigold)!important;">
                <p class="fs-2 fw-bold comfortaa-font">Shooting Drills</p>
            </div>
        </div>
    </div>
    <hr class="text-white">
    <h1 class="fs-5">Personal Fitness Workouts</h1>
    <div class="container">
        <div id="daily-challenges-grid" class="grid-container gap-5 mb-4" style="max-width: 100% !important;">
            <div class="grid-tile p-4 shadow text-center border-5 border position-relative down-top-grad-tahiti" style="background-color: #343434; border-color: #ffa500 !important;">
                <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid shadow mb-4" style="border-radius: 25px; max-height: 300px;" alt="placeholder">
                <p class="fs-2 comfortaa-font">Exercise Title</p>
                <p class="mb-4">Exercise summary</p>
                <p class="mt-4 text-mutedz text-white"><span class="material-icons material-icons-round align-middle" style="font-size: 10px !important; color: #ffa500 !important;">schedule</span>
                    Exercise Duration:
                    *12-15 min</p>
                <!-- <span class="rounded-pill position-absolute top-0 start-0 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;">
                    1. </span> -->
            </div>
            <div class="grid-tile p-4 shadow text-center border-5 border position-relative down-top-grad-white" style="background-color: #343434; border-color: #ffa500 !important;">
                <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid shadow mb-4" style="border-radius: 25px; max-height: 300px;" alt="placeholder">
                <p class="fs-2 comfortaa-font text-dark">Exercise Title</p>
                <p class="mb-4 text-dark">Exercise summary</p>
                <p class="mt-4 text-muted"><span class="material-icons material-icons-round align-middle" style="font-size: 10px !important; color: #ffa500 !important;">schedule</span>
                    Exercise Duration:
                    *12-15 min</p>
                <!-- <span class="rounded-pill position-absolute top-0 start-0 translate-middle align-middle badge border-3 border p-4 fs-5z" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;" hidden="">
                    2. </span> -->
            </div>
            <div class="grid-tile p-4 shadow text-center border-5 border position-relative" style="background-color: #343434; border-color: #ffa500 !important;">
                <img src="../media/assets/OnefitNet Profile PicArtboard 3.jpg" class="img-fluid shadow mb-4" style="border-radius: 25px; max-height: 300px;" alt="placeholder">
                <p class="fs-2 comfortaa-font">Exercise Title</p>
                <p class="mb-4">Exercise summary</p>
                <p class="mt-4 text-muted"><span class="material-icons material-icons-round align-middle" style="font-size: 10px !important; color: #ffa500 !important;">schedule</span>
                    Exercise Duration:
                    *12-15 min</p>
                <!-- <span class="rounded-pill position-absolute top-0 start-0 translate-middle align-middle badge border-3 border p-4 fs-5" style="height: 70px; width: 60px; font-size: 8px; border-color: #ffa500 !important; background-color: #343434 !important;">
                    3. </span> -->
            </div>
        </div>
    </div>
    
    _END;
} else {
    echo "return: No POST request received";
}
