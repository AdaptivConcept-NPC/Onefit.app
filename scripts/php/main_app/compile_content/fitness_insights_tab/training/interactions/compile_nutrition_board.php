<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    echo <<<_END
    <div class="modal-body w3-animate-top rounded-5 top-down-grad-tahiti" style="/* background: var(--white); */">
        <h1 class="fs-1 text-center text-white py-5 bg-dark poppins-font fw-bold shadow" style="color: var(--mineshaft);background-color: var(--mineshaft)!important;border-radius:25px;">
            A. Match Day - Carbohydrate Fueling Plan.
        </h1>
        <hr class="text-white">
        <div class="text-center">
            <img src="../media/assets/body_charts/carbohydrate fueling plan.jpeg" alt="carbohydrate fueling plan template" class="img-fluid my-4 shadow" style="border-radius: 25px; filter: invert(0);">
            <div id="fueling-plan-decription">
                <p class="text-white fs-1">Description here.</p>
            </div>
        </div>
        <hr class="text-white">
        <h1 class="fs-1 text-center text-white py-5 bg-dark poppins-font fw-bold shadow" style="color: var(--mineshaft);background-color: var(--mineshaft)!important;border-radius:25px;">
            B. Post-Match Recovery Chart.
        </h1>
        <hr class="text-white">
        <div class="recovery-chart top-down-grad-dark rounded-5 px-4 py-5">
            <h5 class="fs-1 my-4 py-0 text-center p-4 comfortaa-font">
                WITHIN 30 MINUTES
            </h5>
            <hr class="text-white">
            <p class="fw-bold text-center">CHOOSE AT LEAST ONE WHITE BOX OPTION</p>
            <input type="number" value="0" class="form-control" id="min30-selection-count" readonly="" hidden="">
            <div class="grid-container my-4 py-5">
                <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                    <span class="align-middle fw-bold">Carbohydrate / Protein Recovery
                        Drink
                        <hr class="bg-white">
                    </span>
                </div>
                <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                    <span class="align-middle fw-bold">Carbohydrate Food
                        <hr class="bg-white">
                    </span>
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('30min','option-1')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="min30-option-1-check">
                            <span class="align-middle fw-bold">Light Exercise / Stretch
                                Cool Down</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('30min','option-2')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="min30-option-2-check">
                            <span class="align-middle fw-bold">Cold Water Immersion - 10
                                Minutes</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
            </div>
            <hr class="text-white">
            <h5 class="fs-1 my-4 py-0 text-center p-4 comfortaa-font">
                WITHIN 1 HOUR
            </h5>
            <hr class="text-white">
            <p class="fw-bold text-center">CHOOSE AT LEAST ONE WHITE BOX OPTION</p>
            <input type="number" value="0" class="form-control" id="hr1-selection-count" readonly="" hidden="">
            <div class="grid-container my-4 py-5">
                <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                    <span class="align-middle fw-bold">1 X 500ML Rehydrate Drink</span>
                    <hr class="bg-white">
                </div>
                <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                    <span class="align-middle fw-bold">Carbohydrate Food</span>
                    <hr class="bg-white">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('1hr','option-1')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr1-option-1-check">
                            <span class="align-middle fw-bold">Lower Limb Massage</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('1hr','option-2')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr1-option-2-check">
                            <span class="align-middle fw-bold">Compression Tights Until
                                Bed</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
            </div>
            <hr class="text-white">
            <h5 class="fs-1 my-4 py-0 text-center p-4 comfortaa-font">
                WITHIN 24 MINUTES
            </h5>
            <hr class="text-white">
            <p class="fw-bold text-center">CHOOSE AT LEAST THREE WHITE BOX OPTION</p>
            <input type="number" value="0" class="form-control" id="hr24-selection-count" readonly="" hidden="">
            <div class="grid-container my-4 py-5">
                <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                    <span class="align-middle fw-bold">2 X 500ML Rehydrate Drink</span>
                    <hr class="bg-white">
                </div>
                <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                    <span class="align-middle fw-bold">Rest - Aim for 8 Hours
                        Sleep</span>
                    <hr class="bg-white">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-1')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr24-option-1-check">
                            <span class="align-middle fw-bold">Light Exercise and Foam
                                Roll</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-2')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr24-option-1-check">
                            <span class="align-middle fw-bold">Contrast Bath - 2 Minutes
                                Hot / 2 Minutes Cold X 4</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-3')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr24-option-1-check">
                            <span class="align-middle fw-bold">Mobility and Stretching
                                in Pool</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-4')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr24-option-1-check">
                            <span class="align-middle fw-bold">Massage</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
                <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-5')">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                        <label class="form-check-label text-center" for="hr24-option-1-check">
                            <span class="align-middle fw-bold">Recovery Pump
                                Trousers</span>
                        </label>
                    </div>
                    <hr class="bg-dark">
                </div>
            </div>
        </div>
    </div>
    _END;

    $depr = <<<_END
    <h1 class="fs-1 text-center py-5 bg-white poppins-font fw-bold shadow" style="color: var(--mineshaft);border-radius:25px;">
        A. Match Day - Carbohydrate Fueling Plan.
    </h1>
    <hr class="text-white">
    <div class="text-center">
        <img src="../media/assets/body_charts/carbohydrate fueling plan.jpeg" alt="carbohydrate fueling plan template" class="img-fluid my-4 shadow" style="border-radius: 25px;">
        <div id="fueling-plan-decription">
            <p>Description here.</p>
        </div>
    </div>
    <hr class="text-white">
    <h1 class="fs-1 text-center py-5 bg-white poppins-font fw-bold shadow" style="color: var(--mineshaft);border-radius:25px;">
        B. Post-Match Recovery Chart.
    </h1>
    <hr class="text-white">
    <div class="recovery-chart">
        <h5 class="fs-1 my-4 py-0 text-center p-4 comfortaa-font">
            WITHIN 30 MINUTES
        </h5>
        <hr class="text-white">
        <p class="fw-bold text-center">CHOOSE AT LEAST ONE WHITE BOX OPTION</p>
        <input type="number" value="0" class="form-control" id="min30-selection-count" readonly hidden>
        <div class="grid-container my-4 py-5">
            <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                <span class="align-middle fw-bold">Carbohydrate / Protein Recovery
                    Drink
                    <hr class="bg-white">
                </span>
            </div>
            <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                <span class="align-middle fw-bold">Carbohydrate Food
                    <hr class="bg-white">
                </span>
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('30min','option-1')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="min30-option-1-check">
                        <span class="align-middle fw-bold">Light Exercise / Stretch
                            Cool Down</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('30min','option-2')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="min30-option-2-check">
                        <span class="align-middle fw-bold">Cold Water Immersion - 10
                            Minutes</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
        </div>
        <hr class="text-white">
        <h5 class="fs-1 my-4 py-0 text-center p-4 comfortaa-font">
            WITHIN 1 HOUR
        </h5>
        <hr class="text-white">
        <p class="fw-bold text-center">CHOOSE AT LEAST ONE WHITE BOX OPTION</p>
        <input type="number" value="0" class="form-control" id="hr1-selection-count" readonly hidden>
        <div class="grid-container my-4 py-5">
            <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                <span class="align-middle fw-bold">1 X 500ML Rehydrate Drink</span>
                <hr class="bg-white">
            </div>
            <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                <span class="align-middle fw-bold">Carbohydrate Food</span>
                <hr class="bg-white">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('1hr','option-1')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr1-option-1-check">
                        <span class="align-middle fw-bold">Lower Limb Massage</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('1hr','option-2')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr1-option-2-check">
                        <span class="align-middle fw-bold">Compression Tights Until
                            Bed</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
        </div>
        <hr class="text-white">
        <h5 class="fs-1 my-4 py-0 text-center p-4 comfortaa-font">
            WITHIN 24 MINUTES
        </h5>
        <hr class="text-white">
        <p class="fw-bold text-center">CHOOSE AT LEAST THREE WHITE BOX OPTION</p>
        <input type="number" value="0" class="form-control" id="hr24-selection-count" readonly hidden>
        <div class="grid-container my-4 py-5">
            <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center d-inline" style="height: 200px; background: #343434; color: #fff;">
                <span class="align-middle fw-bold">2 X 500ML Rehydrate Drink</span>
                <hr class="bg-white">
            </div>
            <div class="grid-tile w-100 content-panel-border-style p-4 shadow text-center" style="height: 200px; background: #343434; color: #fff;">
                <span class="align-middle fw-bold">Rest - Aim for 8 Hours
                    Sleep</span>
                <hr class="bg-white">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-1')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr24-option-1-check">
                        <span class="align-middle fw-bold">Light Exercise and Foam
                            Roll</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-2')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr24-option-1-check">
                        <span class="align-middle fw-bold">Contrast Bath - 2 Minutes
                            Hot / 2 Minutes Cold X 4</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-3')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr24-option-1-check">
                        <span class="align-middle fw-bold">Mobility and Stretching
                            in Pool</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-4')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr24-option-1-check">
                        <span class="align-middle fw-bold">Massage</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
            <div class="grid-tile w-100 content-panel-border-style onefit-buttons-style-light p-4 shadow text-center" style="height: 200px;" onclick="toggleRecoverySelection('24hr','option-5')">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" value="" id="hr24-option-1-check">
                    <label class="form-check-label text-center" for="hr24-option-1-check">
                        <span class="align-middle fw-bold">Recovery Pump
                            Trousers</span>
                    </label>
                </div>
                <hr class="bg-dark">
            </div>
        </div>
    </div>
    _END;
} else {
    echo "return: No POST request received";
}
