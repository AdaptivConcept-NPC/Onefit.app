<?php
session_start();
require("../../../../../config.php");
require_once("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['uid'])) {
    // declare variables
    $muscle_group_card_template = <<<_END
    <li class="list-group-item">
        <div class="row">
            <div class="col-xlg">
                <h5 class="fs-2 fw-bold"><span class="badge text-dark bg-white rounded-2 align-middle">A.</span> Muscle Group Title</h5>
                <p>Affected muscles:</p>
                <ul class="list-group list-group-flush list-group-horizontalz muscles-horiz-list w-100 mb-4">
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_1-id">
                        <label class="form-check-label" for="muscle-name_1-id">Muscle name 1</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_2-id">
                        <label class="form-check-label" for="muscle-name_2-id">Muscle name 2</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_3-id">
                        <label class="form-check-label" for="muscle-name_3-id">Muscle name 3</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_4-id">
                        <label class="form-check-label" for="muscle-name_4-id">Muscle name 4</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_5-id">
                        <label class="form-check-label" for="muscle-name_5-id">Muscle name 5</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_6-id">
                        <label class="form-check-label" for="muscle-name_6-id">Muscle name 6</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_7-id">
                        <label class="form-check-label" for="muscle-name_7-id">Muscle name 7</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_8-id">
                        <label class="form-check-label" for="muscle-name_8-id">Muscle name 8</label>
                    </li>
                    <li class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_9-id">
                        <label class="form-check-label" for="muscle-name_9-id">Muscle name 9</label>
                    </li>
                </ul>
            </div>
            <div class="col-xlg">
                <p class="fs-5 fw-bold">Pain Intensity</p>
                <img src="../media/assets/Muscle Sorness Rating Scale.png" alt="Muscle Soreness Rating Scale" class="img-fluid" style="filter: invert(0);">
                <p>Rate your Muscle Soreness according to the scale above</p>
                <div class="input-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity1" value="Intensity-1">
                        <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity2" value="Intensity-2">
                        <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity3" value="Intensity-3">
                        <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity4" value="Intensity-4">
                        <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity5" value="Intensity-5">
                        <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity5">5</label>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="fs-5 fw-bold">Body Temp Reading (°C)</p>
                    <input type="text" name="" id="" class="onefit-inputs-style rounded-pill shadow" placeholder="Temperature (°C)">
                </div>
            </div>
        </div>
    </li>
    _END;
    $muscle_group_card_list_items = null;

    // for ($i = 0; $i <= 5; $i++) {
    //     $muscle_group_card_list_items .= $muscle_group_card_template;
    // }

    // function to get muscle group names from mysql
    function get_muscle_group_names($dbconn)
    {
        $query = "SELECT * FROM muscle_groups ORDER BY muscle_group_id DESC";
        $result = $dbconn->query($query);
        if (!$result) die("Fatal Error");

        $rows = $result->num_rows;
        $muscle_group_names = array();

        for ($i = 0; $i < $rows; $i++) {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            array_push($muscle_group_names, ucwords_str($row['sub_muscle_group'])); // calling ucwords_str function from functions.php
        }

        return $muscle_group_names;
    }

    // call get_muscle_group_names($dbconn) function and create a foreach loop with the returned array
    $muscle_group_names = null;
    $muscle_group_names = get_muscle_group_names($dbconn);

    foreach ($muscle_group_names as $key => $muscle_name) {
        // get letter of the alphabet for the muscle group
        $letter = chr(65 + $key);

        $muscle_group_card_list_items .= <<<_END
        <li class="list-group-item list-group-item-action text-white pt-4" style="background-color:var(--mineshaft);">
            <div class="row">
                <div class="col-xlg">
                    <h5 class="fs-2 fw-bold"><span class="badge text-dark bg-white rounded-2 align-middle">$letter.</span> $muscle_name</h5>
                    
                    <ul class="list-group list-group-flush list-group-horizontalz muscles-horiz-list w-100 mb-4 rounded-4">
                        <li class="list-group-item" style=" background-color: var(--tahitigold);color: var(--mineshaft);">
                            <p class="fs-5 m-0 fw-boldz">Affected muscles:</p>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_2-id" checked>
                            <label class="form-check-label" for="muscle-name_2-id">Muscle name 2</label>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_3-id" checked>
                            <label class="form-check-label" for="muscle-name_3-id">Muscle name 3</label>
                        </li>
                        <li class="list-group-item">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_4-id" checked>
                            <label class="form-check-label" for="muscle-name_4-id">Muscle name 4</label>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_5-id" checked>
                            <label class="form-check-label" for="muscle-name_5-id">Muscle name 5</label>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_6-id" checked>
                            <label class="form-check-label" for="muscle-name_6-id">Muscle name 6</label>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_7-id" checked>
                            <label class="form-check-label" for="muscle-name_7-id">Muscle name 7</label>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_8-id" checked>
                            <label class="form-check-label" for="muscle-name_8-id">Muscle name 8</label>
                        </li>
                        <li class="list-group-item list-group-item-action">
                            <input class="form-check-input me-1" type="checkbox" value="" id="muscle-name_9-id" checked>
                            <label class="form-check-label" for="muscle-name_9-id">Muscle name 9</label>
                        </li>
                    </ul>
                    <hr>
                </div>
                <div class="col-xlg">
                    <p class="fs-5 fw-bold">Pain Intensity</p>
                    <img src="../media/assets/Muscle Sorness Rating Scale.png" alt="Muscle Soreness Rating Scale" class="img-fluid" style="filter: invert(0);">
                    <p>Rate your Muscle Soreness according to the scale above</p>
                    <div class="input-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity1" value="Intensity-1" checked>
                            <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity2" value="Intensity-2">
                            <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity3" value="Intensity-3">
                            <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity4" value="Intensity-4">
                            <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input me-4" type="radio" name="inlineRadioMuscleIntensity[]" id="inlineRadioMuscleIntensity5" value="Intensity-5">
                            <label class="form-check-label fs-5" for="inlineRadioMuscleIntensity5">5</label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="fs-5 fw-bold">Body Temp Reading (°C)</p>
                        <input type="number" name="" id="" min="30" max="41" value="36.5" class="onefit-inputs-style rounded-pill shadow" oninput="validity.valid||(value='');" placeholder="Temperature (°C)">
                        <article>
                            <p class="fs-5">Temprature classifications:</p>
                            <b>Hypothermia</b>	<35.0 °C (95.0 °F) <br>
                            <b>Normal</b>	    36.5–37.5 °C (97.7–99.5 °F) <br>
                            <b>Fever</b>	    >37.5 or 38.3 °C (99.5 or 100.9 °F) <br>
                            <b>Hyperthermia</b>	>37.5 or 38.3 °C (99.5 or 100.9 °F) <br>
                            <b>Hyperpyrexia</b>	>40.0 or 41.0 °C (104.0 or 105.8 °F) <br>
                            <br>
                            <small>Note: The difference between fever and hyperthermia is the underlying mechanism. Different sources have different cut-offs for fever, hyperthermia and hyperpyrexia.<small> <br>
                            <a href="https://en.wikipedia.org/wiki/Human_body_temperature">source</a>
                        </article>
                    </div>
                    <hr class="mb-0">
                </div>
            </div>
        </li>
        _END;
    }

    echo <<<_END
    <div class="modal-body w3-animate-top rounded-5 top-down-grad-tahiti px-4 py-5">
        <div class="row align-items-center text-white mb-4">
            <div class="col-md-2 text-center" style="overflow-x:hidden;">
                <span class="material-icons material-icons-round align-middle" style="font-size:200px!important;color: var(--mineshaft);">personal_injury</span>
            </div>
            <div class="col-md top-down-grad-dark p-4 rounded-5">
                <h1 class="fs-1">
                    Post Activity Physical Assessment.
                </h1>        
                <p class="fs-5">Identification of pain on body chart - Select Areas where pain is being experienced</p>
                <p class="fs-5">Themographic Body Chart - Trainer will enter temperature data in a capturing form.</p>
            </div>
        </div>
        <div id="3dViewer" class="mb-4">
            <iframe src="localhost:3000" frameborder="0" style="height:50vh;width:100%;border-radius:25px;"></iframe>
        </div>
        <div class="row align-items-start">
            <div class="image-map-container col-md no-sroller top-down-grad-dark text-center mb-5" style="overflow-x:auto;border-top-right-radius: 0px !important;">
                <h5 class="fs-3 text-end px-4">Front.</h5>
                <img id="image-map-front" src="../media/assets/body_charts/muscle-men-body-map-front.jpg" alt="male body map - front" class="img-fluidz map image-map-male-front" style="border-radius: 25px; cursor: pointer; filter: invert(0);" usemap="#image-map-male-front-indi".>
                <map id="map-area-front" name="image-map-male-front-indi">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Head')" target="" alt="Male-Front-Head " title="Male-Front-Head " coords="249,98,221,109,218,145,210,143,212,156,220,166,221,177,232,190,241,230,246,232,250,237,255,232,258,225,265,192,276,178,279,165,286,156,286,143,280,138,280,122,270,105" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Pectoralis-Major-Left')" target="" alt="Male-Front-Pectoralis-Major-Left" title="Male-Front-Pectoralis-Major-Left" coords="253,305,254,256,265,235,289,236,302,241,317,244,325,257,328,270,319,269,315,282,309,300,295,311,272,314" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Pectoralis-Major-Right')" target="" alt="Male-Front-Pectoralis-Major-Right" title="Male-Front-Pectoralis-Major-Right" coords="246,303,245,254,235,235,211,235,194,241,177,245,173,259,170,274,181,265,184,279,185,293,194,305,213,315,238,310" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Trapezius-Left')" target="" alt="Male-Front-Trapezius-Left" title="Male-Front-Trapezius-Left" coords="275,182,266,195,258,236,276,232,305,226,284,213,274,203" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Trapezius-Right')" target="" alt="Male-Front-Trapezius-Right" title="Male-Front-Trapezius-Right" coords="224,184,230,192,235,213,241,234,231,233,209,230,196,225,214,215,226,207" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Adominalis-Upper-Left')" target="" alt="Male-Front-Adominalis-Upper-Left" title="Male-Front-Adominalis-Upper-Left" coords="250,312,250,369,287,373,286,315,272,315,257,308" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Adominalis-Upper-Right')" target="" alt="Male-Front-Adominalis-Upper-Right" title="Male-Front-Adominalis-Upper-Right" coords="247,310,248,367,213,373,213,317,224,314" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Adominalis-Lower-Left')" target="" alt="Male-Front-Adominalis-Lower-Left" title="Male-Front-Adominalis-Lower-Left" coords="251,374,250,448,253,485,265,485,284,430,287,376,263,373" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Adominalis-Lower-Right')" target="" alt="Male-Front-Adominalis-Lower-Right" title="Male-Front-Adominalis-Lower-Right" coords="230,371,250,374,247,439,246,486,233,484,215,426,215,376" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-External_Oblique-Left')" target="" alt="Male-Front-External_Oblique-Left" title="Male-Front-External_Oblique-Left" coords="290,314,288,379,287,431,291,447,301,435,312,430,316,429,311,386,310,368,314,355,304,334,300,322" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-External_Oblique-Right')" target="" alt="Male-Front-External_Oblique-Right" title="Male-Front-External_Oblique-Right" coords="212,442,213,426,209,395,210,365,211,316,196,329,185,345,192,376,183,423,196,433,205,442" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Serratus_Anterior-Left')" target="" alt="Male-Front-Serratus_Anterior-Left" title="Male-Front-Serratus_Anterior-Left" coords="291,312,300,319,308,340,314,349,318,321,323,327,323,292,326,270,321,269,310,301" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Serratus_Anterior-Right')" target="" alt="Male-Front-Serratus_Anterior-Right" title="Male-Front-Serratus_Anterior-Right" coords="210,315,194,330,184,343,181,320,177,326,176,294,175,270,180,268,184,299,194,307" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Deltoid-Left')" target="" alt="Male-Front-Deltoid-Left" title="Male-Front-Deltoid-Left" coords="357,301,359,268,352,244,327,224,313,224,293,236,320,244,328,257,330,276" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Deltoid-Right')" target="" alt="Male-Front-Deltoid-Right" title="Male-Front-Deltoid-Right" coords="144,298,141,269,145,246,167,227,188,225,206,235,174,244,168,279" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Bicep_Long_Head-Left')" target="" alt="Male-Front-Bicep_Long_Head-Left" title="Male-Front-Bicep_Long_Head-Left" coords="362,365,366,346,363,335,364,320,357,303,331,276,344,302,354,323" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Bicep_Long_Head-Right')" target="" alt="Male-Front-Bicep_Long_Head-Right" title="Male-Front-Bicep_Long_Head-Right" coords="139,362,132,346,135,336,139,315,145,299,170,277,154,305,147,321,142,344" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Bicep_Short_Head-Left')" target="" alt="Male-Front-Bicep_Short_Head-Left" title="Male-Front-Bicep_Short_Head-Left" coords="362,366,346,356,337,333,336,355,324,329,326,273,332,281,352,320,358,348" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Bicep_Short_Head-Right')" target="" alt="Male-Front-Bicep_Short_Head-Right" title="Male-Front-Bicep_Short_Head-Right" coords="138,369,152,357,164,339,165,357,177,326,175,272,164,292,151,315,144,336" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Brachioradialis-Left')" target="" alt="Male-Front-Brachioradialis-Left" title="Male-Front-Brachioradialis-Left" coords="407,451,397,464,384,465,359,420,347,395,338,379,336,366,337,354,338,337,345,349,346,354,363,366,367,345,379,361,387,391,393,414,397,428" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Brachioradialis-Right')" target="" alt="Male-Front-Brachioradialis-Right" title="Male-Front-Brachioradialis-Right" coords="117,465,105,464,94,453,111,408,117,378,131,349,138,358,139,372,152,355,156,346,163,343,163,377,143,419,127,441" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Hand-Lef')" target="" alt="Male-Front-Hand-Left" title="Male-Front-Hand-Left" coords="384,468,397,467,408,454,449,494,441,529,432,543,419,544,401,535,384,491" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Hand-Right')" target="" alt="Male-Front-Hand-Right" title="Male-Front-Hand-Right" coords="94,455,103,465,116,469,101,536,82,543,67,541,58,526,52,491,82,462" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Sartorius-Left')" target="" alt="Male-Front-Sartorius-Left" title="Male-Front-Sartorius-Left" coords="310,432,308,454,305,471,299,495,287,536,278,563,273,603,273,622,285,658,276,642,272,628,269,610,266,590,268,571,268,557,279,515,285,487,292,477,298,453" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Sartorius-Right')" target="" alt="Male-Front-Sartorius-Right" title="Male-Front-Sartorius-Right" coords="189,434,190,447,191,459,197,480,205,513,212,536,223,569,226,599,225,625,220,641,215,655,224,643,227,616,230,603,231,577,231,546,220,511,215,496,211,483,206,475,202,453" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Abductor-Left')" target="" alt="Male-Front-Abductor-Left" title="Male-Front-Abductor-Left" coords="257,502,266,488,275,471,304,437,291,473,281,498,276,522,267,558,267,575,265,588,257,559,256,534,253,520" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Abductor-Right')" target="" alt="Male-Front-Abductor-Right" title="Male-Front-Abductor-Right" coords="245,510,246,523,245,538,242,557,232,597,231,543,213,482,205,469,200,447,191,432,208,453,216,461,227,475,235,493" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Vastus_Medialis-Left')" target="" alt="Male-Front-Vastus_Medialis-Left" title="Male-Front-Vastus_Medialis-Left" coords="287,538,279,562,274,603,273,620,279,629,289,634,297,624,294,595,286,569" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Vastus_Medialis-Right')" target="" alt="Male-Front-Vastus_Medialis-Right" title="Male-Front-Vastus_Medialis-Right" coords="226,631,215,639,205,630,204,610,212,582,215,554,214,545,221,568,225,599" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Vastus_Laterialis-Left')" target="" alt="Male-Front-Vastus_Laterialis-Left" title="Male-Front-Vastus_Laterialis-Left" coords="317,482,326,501,329,537,328,572,324,594,320,608,319,628,311,626,307,611,311,595,319,576,323,538,321,509" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Vastus_Laterialis-Right')" target="" alt="Male-Front-Vastus_Laterialis-Right" title="Male-Front-Vastus_Laterialis-Right" coords="184,480,174,503,171,536,172,572,174,592,179,607,180,621,184,626,190,619,193,608,187,593,179,566,178,524,182,497" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Tensor_Fasciae_Latae-Left')" target="" alt="Male-Front-Tensor_Fasciae_Latae-Left" title="Male-Front-Tensor_Fasciae_Latae-Left" coords="317,427,323,451,324,480,329,505,313,476,310,451,312,434" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Tensor_Fasciae_Latae-Right')" target="" alt="Male-Front-Tensor_Fasciae_Latae-Right" title="Male-Front-Tensor_Fasciae_Latae-Right" coords="183,426,188,434,189,454,185,472,173,506,177,462,178,445" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Tibialis_Anterior-Left')" target="" alt="Male-Front-Tibialis_Anterior-Left" title="Male-Front-Tibialis_Anterior-Left" coords="316,655,317,677,320,713,320,735,309,773,308,827,303,827,306,749,307,702,308,673" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Tibialis_Anterior-Right')" target="" alt="Male-Front-Tibialis_Anterior-Right" title="Male-Front-Tibialis_Anterior-Right" coords="182,657,179,717,179,733,184,750,190,773,191,824,197,825,194,732,191,698,190,678,189,664" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Extensor_Digitorum_Longus-Left')" target="" alt="Male-Front-Extensor_Digitorum_Longus-Left" title="Male-Front-Extensor_Digitorum_Longus-Left" coords="320,716,326,723,325,731,317,775,317,823,309,827,309,775,321,735" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Extensor_Digitorum_Longus-Right')" target="" alt="Male-Front-Extensor_Digitorum_Longus-Right" title="Male-Front-Extensor_Digitorum_Longus-Right" coords="179,720,175,723,173,734,181,773,182,803,183,820,190,825,189,773,178,731" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Peroneus_Longus-Left')" target="" alt="Male-Front-Peroneus_Longus-Left" title="Male-Front-Peroneus_Longus-Left" coords="318,656,325,667,329,698,327,722,321,713" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Peroneus_Longus-Right')" target="" alt="Male-Front-Peroneus_Longus-Right" title="Male-Front-Peroneus_Longus-Right" coords="180,655,174,667,171,702,173,727,178,717,179,690" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Gastrocnemius-Left')" target="" alt="Male-Front-Gastrocnemius-Left" title="Male-Front-Gastrocnemius-Left" coords="282,676,295,702,295,737,287,749,285,760,277,736,278,703" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Gastrocnemius-Right')" target="" alt="Male-Front-Gastrocnemius-Right" title="Male-Front-Gastrocnemius-Right" coords="217,673,205,697,203,738,210,745,215,761,221,737,221,703" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Soleus-Left')" target="" alt="Male-Front-Soleus-Left" title="Male-Front-Soleus-Left" coords="294,826,295,740,288,750,285,761,292,789" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Soleus-Right')" target="" alt="Male-Front-Soleus-Right" title="Male-Front-Soleus-Right" coords="205,825,203,741,209,747,215,764,207,794" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Patella-Left')" target="" alt="Male-Front-Patella-Left" title="Male-Front-Patella-Left" coords="301,646,17" shape="circle">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Patella-Right')" target="" alt="Male-Front-Patella-Right" title="Male-Front-Patella-Right" coords="195,645,17" shape="circle">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Tibia-Left')" target="" alt="Male-Front-Tibia-Left" title="Male-Front-Tibia-Left" coords="301,826,296,825,297,700,283,676,279,654,292,663,302,665,311,662,306,675,306,719" shape="poly">
                    <area data-maphilight="{&quot;strokeColor&quot;:&quot;0000ff&quot;,&quot;strokeWidth&quot;:5,&quot;fillColor&quot;:&quot;00ff00&quot;,&quot;fillOpacity&quot;:0.6}" onclick="toggleMapSelection('Male-Front-Tibia-Right')" target="" alt="Male-Front-Tibia-Right" title="Male-Front-Tibia-Right" coords="204,826,197,827,195,730,191,665,202,662,210,655,215,660,217,669,204,694,203,712,201,739" shape="poly">
                </map>
            </div>
            <div class="col-md no-sroller top-down-grad-dark text-center mb-5" style="overflow-x:auto;border-top-left-radius: 0px !important;">
                <h5 class="fs-3 text-end px-4">Back.</h5>
                <img  id="image-map-back" src="../media/assets/body_charts/muscle-men-body-map-back.jpg" alt="male body map - back" style="border-radius: 25px; cursor: pointer; filter: invert(0);" class="img-fluidz" usemap="#image-map-male-back-indi">
            </div>
            <div class="col-md-4 text-white">
                <h5 class="fs-3 text-center top-down-grad-dark rounded-4 m-0 py-4">Muscle groups.</h5>
                <ul class="list-group list-group-flush light-scroller" style="border-radius: 25px !important;height:992px;overflow-y:auto">
                    $muscle_group_card_list_items
                </ul>
            </div>
        </div>
    </div>
    _END;
} else {
    echo "return: No POST request received";
}