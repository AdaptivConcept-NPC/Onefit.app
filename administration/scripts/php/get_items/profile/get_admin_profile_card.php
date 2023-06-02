<?php
session_start();
require("../../admin_config.php");
require('../../functions.php');

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

$output = <<<_END
<div class="text-center mb-4">
    <img src="../media/assets/OnefitNet Profile Pic Redone.png" alt="profile pic thumbnail"
        class="img-fluid rounded-circle shadow -sm mb-4" style="max-height: 200px !important;">
    <h3 class="fw-bold"><span id="profile-disp-toggle-btn">Mposula, Thabang</span></h3>
    <h5><span id="profile-disp-toggle-btn" style="font-size: 8px;">[ 001 ]</span></h5>
</div>
<div id="admin-details-list">
    <ul class="list-group list-group-flush mb-4 shadow"
        style="border-radius: 25px;overflow: hidden;">
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">First
                Name:</span> <br>
            <span class="fs-5">Thabang</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">Last
                Name:</span> <br>
            <span class="fs-5">Mposula</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark">
            <span class="fw-bold">Salutation:</span> <br>
            <span class="fs-5">Mr.</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark">
            <span class="fw-bold">Username:</span> <br>
            <span>KING_001</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">Email
                Address:</span> <br>
            <span class="fs-5 text-truncate">thabang.mposula@outlook.com</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">Primary
                Contact:</span> <br>
            <span class="fs-5">0987654321</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">Secondary
                Contact:</span> <br>
            <span class="fs-5">1234567890</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">ID
                Number:</span> <br>
            <span class="fs-5">12345678901234</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">Physical
                Address:</span> <br>
            <span class="fs-5">qwerty 123, asdfg road</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark"><span class="fw-bold">Employee
                Number:</span> <br>
            <span class="fs-5">001</span>
        </li>
        <li class="list-group-item list-group-item-action list-group-item-dark">
            <span class="fw-bold">Registration Date:</span> <br>
            <span class="fs-5">2023-06-01 19:17:17</span>
        </li>
    </ul>
</div>
<div class="d-flex justify-content-between align-items-end">
    <div class="btn-group dropup dropdown-centerz mt-3 d-grid justify-content-end">
        <button class="onefit-buttons-style-dark shadow dropdown-toggle p-4 mb-4" type="button"
            id="dropdownMenuButton" data-bs-toggle="dropdown">
            <span class="material-icons material-icons-round">
                settings
            </span>
        </button>
        <ul class="dropdown-menu fw-bold" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item fw-bold" href="#"><span
                        class="material-icons align-middle">manage_accounts</span> <span
                        class="align-middle">Edit Profile</span></a></li>
            <li><a class="dropdown-item fw-bold" href="#"><span
                        class="material-icons align-middle">settings</span> <span
                        class="align-middle">Open Settings</span></a></li>
            <li class="bg-danger"><a class="dropdown-item fw-bold text-white"
                    onclick="adminSignOut()"><span
                        class="material-icons align-middle">logout</span>
                    <span class="align-middle">Sign Out</span></a></li>
        </ul>
    </div>
    <div class="text-center">
        <!-- version# display -->
        <span style="font-size: 10px !important;">App Version: 1.1.1</span>
    </div>
</div>
_END;
