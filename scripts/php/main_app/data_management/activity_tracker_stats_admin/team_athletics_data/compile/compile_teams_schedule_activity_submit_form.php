<?php
session_start();
require("../../../../../config.php");
require("../../../../../functions.php");

//test connection - if fail then die
if ($dbconn->connect_error) die("Fatal Error");

if (isset($_GET['day']) && isset($_GET['gref'])) {
    // declaring variables
    $getDay = $getGrpRef = $workout_activities_list = "";

    // execute query
    $getDay = sanitizeMySQL($dbconn, $_GET['day']);
    $getGrpRef = sanitizeMySQL($dbconn, $_GET['gref']);

    if (isset($_GET['when'])) $when = sanitizeMySQL($dbconn, $_GET['when']); // this / last / next
    else $when = 'this';

    $dayNum = date("N", strtotime("$getDay $when week"));

    $dayDateThisWeek = date('Y-m-d', strtotime("$getDay $when week"));

    // echo "dayDateThisWeek: $dayDateThisWeek <br/>";

    if ($getGrpRef == "editbar") {
        # compile a form for editing the title and rpe and bars overall

    } else {
        # compile a form for eding new activities/exercises to the bar

        // try to compile the modal body html
        try {
            // declare variables
            // tws vars
            $teams_weekly_schedule_id = $schedule_title = $schedule_rpe = $schedule_day = $schedule_date = $color_code = $ccs_color = $groups_group_ref_code = null;
            // twa vars
            $teams_activity_id = $activity_title = $activity_description = $activity_icon = $teams_weekly_schedules_teams_weekly_schedule_id = $exercises_exercise_id = null;
            // compilation & output vars
            $activities_bar_content = $inner_activities_bar_content = $currentActivityItem =  $workout_activities_list = $formHTML = null;

            //code to compile the teams daily activities in the daily activities chart bars
            $query = "SELECT tws.teams_weekly_schedule_id, tws.schedule_title, tws.schedule_rpe, tws.schedule_day, tws.schedule_date, tws.color_code, tws.groups_group_ref_code
            FROM teams_weekly_schedules tws 
            WHERE tws.groups_group_ref_code = '$getGrpRef' AND tws.schedule_day = '$getDay' AND tws.schedule_date = '$dayDateThisWeek'";

            // echo $query;

            $result = $dbconn->query($query);

            if (!$result) die("An error occurred while trying to save your details. [compile teams daily activities Submit Error_01 - " . $dbconn->error . "]");

            $rows = $result->num_rows;
            // echo "rows: $rows\n";

            if ($rows <= 0) {
                //there is no existing schedule for this day
                // return / echo the full schedule creation form


                // tws
                $teams_weekly_schedule_id = 0;
                $schedule_title = "Capture Title";
                $schedule_rpe = 0;
                $schedule_day = $getDay; //ucfirst($row["schedule_day"]);
                $schedule_date = date("d/m/Y", strtotime("$getDay this week"));
                $groups_group_ref_code = $getGrpRef;

                $form_html = <<<_END
                <form id="add-new-schedule-form" class="text-start d-grid gap-2 comfortaa-font fs-5" style="border-radius: 25px;" method="post" action="../scripts/php/main_app/compile_content/fitness_insights_tab/activity_calender/add_to_teams_training_schedule.php" autocomplete="off">
                    <h5 class="fs-2 p-4 fw-bold text-center comfortaa-font shadow my-4 border-5 border-start border-end" style="border-radius:25px;">
                        Capture New Activity.
                    </h5>
                    <hr class="text-white">
                    <div class="output-container my-2" id="output-container">
                        <!---->
                    </div>
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-title-value" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);">Team
                            select:</label>
                        <select class="custom-select form-control-select-input p-4 team-selection-list" name="add-to-calender-team-select" id="add-to-calender-team-select" placeholder="Select your Team." required=""><option value="noselection" selected="">🏅 Switch Teams.</option><option value="tst_grp_0001" grp-category="teams"> Test Group - Teams </option><option value="tst_grp_0003" grp-category="pro"> Test Group - Pro Community </option></select>
                    </div>
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-title-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">1.
                            Title:</label>
                        <input class="form-control-text-input p-4" type="text" name="add-to-calender-activity-title-value" id="add-to-calender-activity-title-value" placeholder="Title" required="">
                    </div>
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-rpe-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">2.
                            RPE
                            (Auto)</label>
                        <input class="form-control-text-input p-4" type="number" value="0" name="add-to-calender-activity-rpe-value" id="add-to-calender-activity-rpe-value" placeholder="RPE" required="" readonly="">
                    </div>
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-day-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">3.
                            Day:</label>
                        <input class="form-control-text-input p-4" type="text" name="add-to-calender-activity-day-value" id="add-to-calender-activity-day-value" placeholder="Day" required="" readonly="">
                    </div>
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-date-value" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);">4.
                            Date:</label>
                        <input class="form-control-text-input p-4" onchange="changeSelDateValues(this.value)" type="date" name="add-to-calender-activity-date-value" id="add-to-calender-activity-date-value" placeholder="Date" required="">
                    </div>
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-colorcode-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">
                            5. Assign color code:
                        </label>
                        <select class="custom-select form-control-select-input p-4" onchange="toggleCustomColorSelection(this.value)" name="add-to-calender-activity-colorcode-value" id="add-to-calender-activity-colorcode-value" placeholder="Select a color code" required="">
                            <!-- MATCH DAYS    OFF DAYS     TRAINING DAYS   FRIENDLY GAMES    RECOVERY -->
                            <option value="off_day[greenyellow]" style="color: greenyellow;">Off
                                day
                            </option>
                            <option value="recovery_day[blue]" style="color: blue;">Recovery day
                            </option>
                            <option value="training_day[green]" style="color: green;">Training
                                day
                            </option>
                            <option value="friendly_game[purple]" style="color: purple;">
                                Friendly
                                game</option>
                            <option value="match_day[red]" style="color: red;">Match day
                            </option>
                            <option value="custom">Custom color code</option>
                        </select>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div id="custom-color-selection" class="col-md-8 border-1 border-end w3-animate-left" style="display: none;">
                            <div class="form-group my-4 px-2">
                                <label for="add-to-calender-activity-custom-colorcode-value" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);">5.1.
                                    Custom Color Code:</label>
                                <div class="d-flex gap-4 align-items-end justify-content-center">
                                    <div class="d-grid gap-1">
                                        <label for="add-to-calender-activity-custom-colorcode-title-value" class="poppins-font form-check-label text-center pt-2" style="font-size:10px;">
                                            Please provide a title to identify what the selected
                                            color code tag means.
                                        </label>
                                        <input class="form-control-text-input p-4" type="text" value="color_tag" name="add-to-calender-activity-custom-colorcode-title-value" id="add-to-calender-activity-custom-colorcode-title-value" placeholder="Please provide a title to identify what the selected color code means">
                                    </div>
                                    <div class="d-grid gap-1 text-center">
                                        <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                                            format_color_fill
                                        </span>
                                        <input class="rounded-pill p-3" type="color" name="add-to-calender-activity-custom-colorcode-value" id="add-to-calender-activity-custom-colorcode-value" oninput="toggleCustomColorSelection(this.value,true)" placeholder="select a custom color" value="#ffffff" style="width:50px;height:50px;">
                                    </div>
                                    <div class="form-check d-flex gap-2 text-center justify-content-center">
                                        <input class="form-check-input" type="checkbox" id="add-to-calender-activity-custom-colorcode-save-tag">
                                        <label for="add-to-calender-activity-custom-colorcode-save-tag" class="poppins-font form-check-label text-center pt-2">Save?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-grid text-center">
                            <span id="color-preview" class="p-4 shadow align-middle text-truncate text-dark shadow" style="background-color: greenyellow; border-radius: 25px;">
                                <span class="material-icons material-icons-round align-middle" style="color: var(--secondary-color);">
                                    palette
                                </span>
                            </span>
                        </div>
                    </div>
                    <!-- we will have a two-col row elem: left col is for either selecting existing activities to push them to the listbox on the right col / using a textarea field to type in activities to push them to the listbox on the right col --> 
                    <!-- question 6 actvities selection -->
                    <div id="question-6-activities" style="display: none;">
                        <h5 class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color) !important">6. Add Activities</h5>
                        <div class="row align-items-center">
                            <div class="col-md d-grid">
                                <!-- select an existing exercise activity -->
                                <div class="form-group d-grid gap-2">
                                    <label for="add-to-calender-activity-selection" class="poppins-font fs-4 add-to-calender-activity-selection" style="color: var(--primary-color);">Exercises &amp;
                                        Activities.</label>
                                    <select class="custom-select form-control-select-input p-2 light-scroller" id="add-to-calender-activity-selection" style="border-radius:25px;height:290px;" multiple="multiple" rows="20"><option value="49"> 001. Test exercise  X[4]P RPE[2]R  </option><option value="50"> 001. Test exercise  X[4]P RPE[2]R  </option><option value="51"> 002. Test exercise  X[5]P RPE[2]R  </option><option value="52"> 002. Test exercise  X[5]P RPE[2]R  </option><option value="53"> 003. Test exercise  X[7]P RPE[0]R  </option><option value="54"> 003. Test exercise  X[7]P RPE[0]R  </option><option value="55"> 004. Another Test  X[3]P RPE[0]R  </option><option value="56"> 004. Another Test  X[3]P RPE[0]R  </option><option value="57"> 005. 97TYUTYT  X[8]P RPE[0]R  </option><option value="58"> 005. 97TYUTYT  X[8]P RPE[0]R  </option><option value="59"> 006. ITYUTY  X[8]P RPE[8]R  </option><option value="60"> 006. ITYUTY  X[8]P RPE[8]R  </option><option value="63"> 007. uitruufyufy  X[3]P RPE[0]R  </option><option value="64"> 007. uitruufyufy  X[3]P RPE[0]R  </option><option value="40"> 90/90 spiral with rotation (At-Home - Back Exercises - Cooldowns)  X[10]P RPE[1]R  </option><option value="35"> Bent-over double delt raises (At-Home - Back Exercises - Standing movements)  X[15]P RPE[2]R  </option><option value="36"> Bent-over row with resistance band (At-Home - Back Exercises - Standing movements)  X[10]P RPE[1]R  </option><option value="29"> Bird dog (At-Home - Back Exercises - Floor movements)  X[8]P RPE[1]R  </option><option value="2"> Cable crossover  X[75]P RPE[10]R  </option><option value="26"> Cat-Cow (At-Home - Back Exercises - Warmups)  X[6]P RPE[1]R  </option><option value="1"> Chest dip  X[45]P RPE[5]R  </option><option value="12"> Chest press (Upper-body bulk and sculpt)  X[48]P RPE[5]R  </option><option value="23"> Chest press (Upper-body tone and tighten)  X[45]P RPE[5]R  </option><option value="3"> Decline bench press  X[39]P RPE[4]R  </option><option value="24"> Deltoid raises (Upper-body tone and tighten)  X[45]P RPE[5]R  </option><option value="18"> Diamond pushups (Upper-body tone and tighten)  X[30]P RPE[3]R  </option><option value="20"> Dumbbell curls (Upper-body tone and tighten)  X[45]P RPE[5]R  </option><option value="25"> Dumbbell front raises (Upper-body tone and tighten)  X[45]P RPE[5]R  </option><option value="37"> Extend rotate At-Home - Back Exercises - (Standing movements)  X[10]P RPE[1]R  </option><option value="43"> false  X[9]P RPE[5]R  </option><option value="44"> false  X[9]P RPE[5]R  </option><option value="45"> false  X[9]P RPE[5]R  </option><option value="46"> false  X[9]P RPE[5]R  </option><option value="47"> false  X[9]P RPE[3]R  </option><option value="48"> false  X[9]P RPE[3]R  </option><option value="28"> Hammock (At-Home - Back Exercises - Warmups)  X[4]P RPE[0]R  </option><option value="19"> Hand release pushup (Upper-body tone and tighten)  X[30]P RPE[3]R  </option><option value="33"> Hip hinges (At-Home - Back Exercises - Standing movements)  X[20]P RPE[2]R  </option><option value="13"> Incline dumbbell flies (Upper-body bulk and sculpt)  X[48]P RPE[5]R  </option><option value="14"> Incline dumbbell triceps extension (Upper-body bulk and sculpt)  X[48]P RPE[5]R  </option><option value="4"> Incline push up  X[50]P RPE[5]R  </option><option value="61"> ioyugfjh  X[7]P RPE[0]R  </option><option value="62"> ioyugfjh  X[7]P RPE[0]R  </option><option value="34"> Isometric hip hinges (At-Home - Back Exercises - Standing movements)  X[3]P RPE[0]R  </option><option value="39"> Isometric neck extension (At-Home - Back Exercises - Chair exercises)  X[5]P RPE[1]R  </option><option value="27"> Lateral Wheel (At-Home - Back Exercises - Warmups)  X[3]P RPE[0]R  </option><option value="30"> Lunge rotate (At-Home - Back Exercises - Floor movements)  X[50]P RPE[5]R  </option><option value="17"> Mountain climbers (Upper-body tone and tighten)  X[60]P RPE[6]R  </option><option value="10"> Overhead dumbbell press (Upper-body bulk and sculpt)  X[40]P RPE[4]R  </option><option value="6"> Parallel Bar Dips (Upper-body bulk and sculpt)  X[36]P RPE[4]R  </option><option value="31"> Plank with lateral arm raise (At-Home - Back Exercises - Floor movements)  X[20]P RPE[2]R  </option><option value="8"> Plyometric Push-ups (Upper-body bulk and sculpt)  X[36]P RPE[4]R  </option><option value="7"> Push-ups (Upper-body bulk and sculpt)  X[36]P RPE[4]R  </option><option value="5"> Seated machine fly  X[90]P RPE[10]R  </option><option value="38"> Shoulder squeeze (At-Home - Back Exercises - Chair exercises)  X[5]P RPE[1]R  </option><option value="11"> Standing dumbbell upright row (Upper-body bulk and sculpt)  X[40]P RPE[4]R  </option><option value="32"> Superman (At-Home - Back Exercises - Floor movements)  X[10]P RPE[1]R  </option><option value="42"> Supine twist (At-Home - Back Exercises - Cooldowns)  X[2]P RPE[0]R  </option><option value="15"> Triceps dips (Upper-body tone and tighten)  X[45]P RPE[5]R  </option><option value="21"> Triceps kickbacks (Upper-body tone and tighten)  X[45]P RPE[5]R  </option><option value="22"> Two-arm dumbbell row (Upper-body tone and tighten)  X[36]P RPE[4]R  </option><option value="9"> Walking plank (Upper-body bulk and sculpt)  X[36]P RPE[4]R  </option><option value="16"> Wall angels (Upper-body tone and tighten)  X[60]P RPE[6]R  </option><option value="41"> Wind-relieving pose (At-Home - Back Exercises - Cooldowns)  X[2]P RPE[0]R  </option></select>
                                    <button type="button" id="add-selection-to-activities-selectlist-btn" class="onefit-buttons-style-light p-4">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">
                                            keyboard_double_arrow_down
                                        </span>
                                        add.
                                    </button>
                                </div>
                                <!-- ./ select an existing exercise activity -->
                            </div>
                            <div class="col-md-2 py-4">
                                <div class="d-grid justify-content-center text-center">
                                    <button type="button" class="onefit-buttons-style-tahiti p-3 d-grid collapsed" data-bs-toggle="collapse" data-bs-target="#new-exercise-activity-container" aria-expanded="false" aria-controls="new-exercise-activity-container">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">
                                            playlist_add
                                        </span>
                                        <span style="font-size:10px!important;" class="text-truncate">
                                            New Exercise/Activity.
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div id="new-exercise-activity-container" class="col-md-5 gap-4 collapse w3-animate-right">
                                <!-- Textarea for typing out the exercises -->
                                <div class="form-group d-grid gap-2">
                                    <label for="add-to-calender-activity-specify-title" class="poppins-font fs-4" style="color: var(--primary-color);">Create
                                        New
                                        Activities:</label>
                                    <br>

                                    <label for="add-to-calender-activity-specify-xp" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Exercise /
                                        activity
                                        name:</label>
                                    <input class="form-control-text-input p-4" type="text" name="add-to-calender-activity-specify-title" id="add-to-calender-activity-specify-title" placeholder="Exercise / activity name." style="border-radius:25px;font-size:12px!important;">

                                    <!-- icon selection -->
                                    <div class="input-group gap-2 chart-col-bar-item" style="transform: scale(1,1) !important;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-cycling" value="../media/assets/icons/cycling.png">
                                            <label class="form-check-label" for="activity-icon-cycling">
                                                <img src="../media/assets/icons/cycling.png" alt="cycling/spinning" style="height: 50px; width: auto; filter: invert(0);">
                                                Cycling / Spinning
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-strength" value="../media/assets/icons/bodybuilder.png">
                                            <label class="form-check-label" for="activity-icon-strength">
                                                <img src="../media/assets/icons/bodybuilder.png" alt="strength" style="height: 50px; width: auto; filter: invert(0);">
                                                Strength
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-icebath" value="../media/assets/icons/bath-tub.png">
                                            <label class="form-check-label" for="activity-icon-icebath">
                                                <img src="../media/assets/icons/bath-tub.png" alt="ice bath" style="height: 50px; width: auto; filter: invert(0);">
                                                Ice bath
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-running" value="../media/assets/icons/running.png">
                                            <label class="form-check-label" for="activity-icon-running">
                                                <img src="../media/assets/icons/running.png" alt="running" style="height: 50px; width: auto; filter: invert(0);">
                                                Running
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-tactics" value="../media/assets/icons/thinking.png">
                                            <label class="form-check-label" for="activity-icon-tactics">
                                                <img src="../media/assets/icons/thinking.png" alt="tactics" style="height: 50px; width: auto; filter: invert(0);">
                                                Tactics
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-kickoff" value="../media/assets/icons/soccer-ball.png">
                                            <label class="form-check-label" for="activity-icon-kickoff">
                                                <img src="../media/assets/icons/soccer-ball.png" alt="kick-off" style="height: 50px; width: auto; filter: invert(0);">
                                                Kick-off
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input me-2" type="radio" name="activity-icon" id="activity-icon-multidir" value="../media/assets/icons/directions.png">
                                            <label class="form-check-label" for="activity-icon-multidir">
                                                <img src="../media/assets/icons/directions.png" alt="multi-directional" style="height: 50px; width: auto; filter: invert(0);">
                                                Multi-directional
                                            </label>
                                        </div>
                                    </div>
                                    <!-- ./ icon selection -->
                                    <label for="add-to-calender-activity-specify-xp" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Allocate xp pts
                                        (1 -
                                        10):</label>
                                    <input class="form-control-text-input p-4" type="number" oninput="validity.valid||(value='');" min="1" max="10" name="add-to-calender-activity-specify-xp" id="add-to-calender-activity-specify-xp" placeholder="How much XP? 10xp max." style="border-radius:25px;">
                                    <div class="form-group">
                                        <label for="sets-reps-rests" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Select the
                                            Sets,
                                            Reps &amp; Rests:</label>
                                        <div class="row" id="sets-reps-rests">
                                            <div class="col-md">
                                                <input class="form-control-text-input p-4 onefit-input-grad-white-dark border-0" type="number" oninput="validity.valid||(value='');" min="1" max="10" value="1" name="add-to-calender-activity-specify-sets" id="add-to-calender-activity-specify-sets" placeholder="How many Sets? 10 max sets." style="border-radius:25px;">
                                            </div>
                                            <div class="col-md">
                                                <input class="form-control-text-input p-4 onefit-input-grad-white-dark border-0" type="number" oninput="validity.valid||(value='');" min="1" max="100" value="1" name="add-to-calender-activity-specify-reps" id="add-to-calender-activity-specify-reps" placeholder="How many Sets? 10 max reps." style="border-radius:25px;">
                                            </div>
                                            <div class="col-md">
                                                <input class="form-control-text-input p-4 onefit-input-grad-white-dark border-0" type="number" oninput="validity.valid||(value='');" min="0" max="10" value="0" name="add-to-calender-activity-specify-rests" id="add-to-calender-activity-specify-rests" placeholder="How many Sets? 5 max sets." style="border-radius:25px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="add-to-calender-activity-specify-new-description" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Please
                                            provide
                                            the Description &amp; Guidelines/Instructions of
                                            this
                                            Exercise/Activty:</label>
                                        <textarea class="form-control-text-input p-2 text-dark light-scroller" rows="3" type="text" name="add-to-calender-activity-specify-new-description" id="add-to-calender-activity-specify-new-description" placeholder="Description..." style="border-radius:25px;font-size:12px!important;"></textarea>

                                        <textarea class="form-control-text-input p-2 text-dark light-scroller" rows="3" type="text" name="add-to-calender-activity-specify-new-guidelines" id="add-to-calender-activity-specify-new-guidelines" placeholder="Guidelines / Instructions..." style="border-radius:25px;font-size:12px!important;"></textarea>
                                    </div>
                                    <label for="add-to-calender-specify-training-phase" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Select the
                                        Training
                                        level (L1 - L3):</label>
                                    <select class="custom-select form-control-select-input p-2 light-scroller" id="add-to-calender-specify-training-phase" name="add-to-calender-specify-training-phase" style="border-radius:25px;">
                                        <option value="beginner" selected="">Beginner (L1).
                                        </option>
                                        <option value="intermediate">Intermediate (L2).</option>
                                        <option value="advanced">Advanced (L3).</option>
                                    </select>
                                    <button type="button" id="add-selection-to-activities-textinput-btn" class="onefit-buttons-style-light p-4">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">
                                            add
                                        </span>
                                        save.
                                    </button>
                                </div>
                                <!-- ./ Textarea for typing out the exercises -->
                            </div>
                        </div>
                        <div>
                            <hr class="text-white">
                            <label for="select-workout-exercises-selected" class="mb-2">
                                <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                                    queue
                                </span>
                                <span class="align-middle"> Activities Added.</span>
                            </label>
                            <!-- move items function buttons -->
                            <div class="d-flex justify-content-between gap-2 mb-2">
                                <div class="d-grid">
                                    <h1 id="selected-xp-counter" class="fs-5" style="color: var(--primary-color);">Total xp: 0 | 0
                                        activities.</h1>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" id="remove-selection-from-selected-activities-list-btn" class="onefit-buttons-style-light p-2">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">
                                            remove
                                        </span>
                                        <span style="font-size:10px!important;">
                                            Remove selected.
                                        </span>
                                    </button>
                                    <button type="button" id="remove-all-from-selected-activities-list-btn" class="onefit-buttons-style-danger p-2">
                                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">
                                            restart_alt
                                        </span>
                                        <span style="font-size:10px!important;">
                                            Remove all selected.
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <!-- listbox on the right col is the listbox that will be submitted on form submit -->
                            <select id="select-workout-exercises-selected" name="select-workout-exercises-selected[]" class="form-control light-scroller" multiple="multiple" rows="50" style="min-height:200px;border-radius:25px;"></select>
                        </div>
                    </div>
                    <!-- ./ question 6 actvities selection -->
                    <!-- submit btn -->
                    <button id="single-submit-add-new-schedule-data-form" class="onefit-buttons-style-tahiti p-4 mt-4 shadow d-grid" type="submit" value="Save">
                        <span class="material-icons material-icons-outlined align-middle">
                            event_available
                        </span>
                        <span class="align-middle">Save.</span>
                    </button>
                    <!-- hidden="" aria-hidden="true" -->
                </form>
                _END;

                echo $form_html;
            } else {

                for ($j = 0; $j < $rows; ++$j) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    // tws
                    $teams_weekly_schedule_id = $row["teams_weekly_schedule_id"];
                    $schedule_title = $row["schedule_title"];
                    $schedule_rpe = $row["schedule_rpe"];
                    $schedule_day = ucfirst($row["schedule_day"]);
                    $schedule_date = date("d/m/Y", strtotime($row["schedule_date"]));
                    $color_code = $row["color_code"];
                    $groups_group_ref_code = $row["groups_group_ref_code"];

                    // get value between [ and ] from $color_code
                    $ccs_color = get_string_between($color_code, "[", "]");
                }

                // call to compile exercise list
                $workout_activities_list = compileSelectInputExerciseList();

                $form_html = <<<_END
                <form id="new-exercise-activity-form" class="col-md-5 gap-4 w3-animate-right collapse show" style="">
                    <!-- $teams_weekly_schedule_id -->
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-title-value" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);">Team selected</label>
                        <input class="form-control-text-input p-4" value="$groups_group_ref_code" readonly name="add-to-calender-team-select" id="add-to-calender-team-select" placeholder="Team GRCode." required="">
                    </div>
                    <!--  -->
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-title-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">1.
                            Title:</label>
                        <input class="form-control-text-input p-4" value="$schedule_title" type="text" readonly name="add-to-calender-activity-title-value" id="add-to-calender-activity-title-value" placeholder="Title" required="">
                    </div>
                    <!--  -->
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-rpe-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">2. RPE
                            (Auto)</label>
                        <input class="form-control-text-input p-4" value="$schedule_rpe" type="number" readonly value="0" name="add-to-calender-activity-rpe-value" id="add-to-calender-activity-rpe-value" placeholder="RPE" required="">
                    </div>
                    <!--  -->
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-day-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">3.
                            Day:</label>
                        <input class="form-control-text-input p-4" value="$schedule_day" type="text" readonly name="add-to-calender-activity-day-value" id="add-to-calender-activity-day-value" placeholder="Day" required="">
                    </div>
                    <!--  -->
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-date-value" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);">4. Date:</label>
                        <input class="form-control-text-input p-4" value="$schedule_date" readonly onchange="changeSelDateValues(this.value)" type="date" name="add-to-calender-activity-date-value" id="add-to-calender-activity-date-value" placeholder="Date" required="">
                    </div>
                    <!--  -->
                    <div class="form-group my-4">
                        <label for="add-to-calender-activity-colorcode-value" class="poppins-font fs-4 fw-bold mb-4" style="color: var(--primary-color);">
                            5. Color code:
                        </label>
                        <select class="custom-select form-control-select-input p-4 d-none" onchange="toggleCustomColorSelection(this.value)" name="add-to-calender-activity-colorcode-value" id="add-to-calender-activity-colorcode-value" placeholder="Select a color code" required="">
                            <!-- MATCH DAYS    OFF DAYS     TRAINING DAYS   FRIENDLY GAMES    RECOVERY -->
                            <option value="off_day[greenyellow]" style="color: greenyellow;">Off day
                            </option>
                            <option value="recovery_day[blue]" style="color: blue;">Recovery day
                            </option>
                            <option value="training_day[green]" style="color: green;">Training day
                            </option>
                            <option value="friendly_game[purple]" style="color: purple;">Friendly
                                game</option>
                            <option value="match_day[red]" style="color: red;">Match day</option>
                            <option value="custom">Custom color code</option>
                        </select>
                        <!-- color code preview -->
                        <div class="row justify-content-center align-items-center">
                            <div id="custom-color-selection" class="col-md-8 border-1 border-end w3-animate-left" style="display: none;">
                                <div class="form-group my-4 px-2">
                                    <label for="add-to-calender-activity-custom-colorcode-value" class="poppins-font fs-4 mb-4" style="color: var(--primary-color);">5.1.
                                        Custom Color Code:</label>
                                    <div class="d-flex gap-4 align-items-end justify-content-center">
                                        <div class="d-grid gap-1">
                                            <label for="add-to-calender-activity-custom-colorcode-title-value" class="poppins-font form-check-label text-center pt-2" style="font-size:10px;">
                                                Please provide a title to identify what the selected
                                                color code tag means.
                                            </label>
                                            <input class="form-control-text-input p-4" type="text" value="color_tag" name="add-to-calender-activity-custom-colorcode-title-value" id="add-to-calender-activity-custom-colorcode-title-value" placeholder="Please provide a title to identify what the selected color code means">
                                        </div>
                                        <div class="d-grid gap-1 text-center">
                                            <span class="material-icons material-icons-outlined align-middle" style="font-size:20px!important;">
                                                format_color_fill
                                            </span>
                                            <input class="rounded-pill p-3" type="color" name="add-to-calender-activity-custom-colorcode-value" id="add-to-calender-activity-custom-colorcode-value" oninput="toggleCustomColorSelection(this.value,true)" placeholder="select a custom color" value="#ffffff" style="width:50px;height:50px;">
                                        </div>
                                        <div class="form-check d-flex gap-2 text-center justify-content-center">
                                            <input class="form-check-input" type="checkbox" id="add-to-calender-activity-custom-colorcode-save-tag">
                                            <label for="add-to-calender-activity-custom-colorcode-save-tag" class="poppins-font form-check-label text-center pt-2">Save?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-grid text-center">
                                <span id="color-preview" class="p-4 shadow align-middle text-truncate text-dark shadow" style="background-color:  $ccs_color; border-radius: 25px;">
                                    <span class="material-icons material-icons-round align-middle" style="color: var(--secondary-color);">
                                        palette
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-grid gap-2">
                        <label for="add-to-calender-activity-specify-title" class="poppins-font fs-4" style="color: var(--primary-color);">Create New
                            Activities:
                        </label>
                        <!-- existing exercise select -->
                        <div class="form-group d-grid gap-2">
                            <label for="add-to-calender-activity-selection" class="poppins-font fs-4 add-to-calender-activity-selection" style="color: var(--primary-color);">Select or create a new Exercises / Activity.</label>
                            <select class="custom-select form-control-select-input p-2 light-scroller" id="add-to-calender-activity-selection" onchange="autopopulateExerciseInfo(this.id)" style="border-radius:25px;height:290px;" multiple="multiple" rows="20">
                                <option value="new_item" selected> + New exercise </option>
                                $workout_activities_list
                            </select>
                        </div>
                        <input class="form-control-text-input p-4" type="text" name="add-to-calender-activity-specify-title" id="add-to-calender-activity-specify-title" placeholder="Exercise / activity title." style="border-radius:25px;font-size:12px!important;">
                        <label for="add-to-calender-activity-specify-xp" class="poppins-font" style="color: var(--primary-color);font-size:12px;">
                            Allocate xp pts (1 - 10):
                        </label>
                        <input class="form-control-text-input p-4" type="number" oninput="validity.valid||(value='');" min="1" max="10" name="add-to-calender-activity-specify-xp" id="add-to-calender-activity-specify-xp" placeholder="How much XP? 10xp max." style="border-radius:25px;">
                        <div class="form-group">
                            <label for="sets-reps-rests" class="poppins-font" style="color: var(--primary-color);font-size:12px;">
                                Select the Sets, Reps &amp; Rests:
                            </label>
                            <div class="row" id="sets-reps-rests">
                                <div class="col-md">
                                    <input class="form-control-text-input p-4 onefit-input-grad-white-dark border-0" type="number" oninput="validity.valid||(value='');" min="1" max="10" value="1" name="add-to-calender-activity-specify-sets" id="add-to-calender-activity-specify-sets" placeholder="How many Sets? 10 max sets." style="border-radius:25px;">
                                </div>
                                <div class="col-md">
                                    <input class="form-control-text-input p-4 onefit-input-grad-white-dark border-0" type="number" oninput="validity.valid||(value='');" min="1" max="100" value="1" name="add-to-calender-activity-specify-reps" id="add-to-calender-activity-specify-reps" placeholder="How many Sets? 10 max reps." style="border-radius:25px;">
                                </div>
                                <div class="col-md">
                                    <input class="form-control-text-input p-4 onefit-input-grad-white-dark border-0" type="number" oninput="validity.valid||(value='');" min="0" max="10" value="0" name="add-to-calender-activity-specify-rests" id="add-to-calender-activity-specify-rests" placeholder="How many Sets? 5 max sets." style="border-radius:25px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add-to-calender-activity-specify-new-description" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Please provide
                                the Description &amp; Guidelines/Instructions of this
                                Exercise/Activty:</label>
                            <textarea class="form-control-text-input p-2 text-dark light-scroller" rows="3" type="text" name="add-to-calender-activity-specify-new-description" id="add-to-calender-activity-specify-new-description" placeholder="Description..." style="border-radius:25px;font-size:12px!important;"></textarea>
                            <br/>
                            <textarea class="form-control-text-input p-2 text-dark light-scroller" rows="3" type="text" name="add-to-calender-activity-specify-new-guidelines" id="add-to-calender-activity-specify-new-guidelines" placeholder="Guidelines / Instructions..." style="border-radius:25px;font-size:12px!important;"></textarea>
                        </div>
                        <label for="add-to-calender-specify-training-phase" class="poppins-font" style="color: var(--primary-color);font-size:12px;">Select the Training
                            level (L1 - L3):</label>
                        <select class="custom-select form-control-select-input p-2 light-scroller" id="add-to-calender-specify-training-phase" name="add-to-calender-specify-training-phase" style="border-radius:25px;">
                            <option value="beginner" selected="">Beginner (L1).</option>
                            <option value="intermediate">Intermediate (L2).</option>
                            <option value="advanced">Advanced (L3).</option>
                        </select>
                    </div>
                    <!-- ./ Textarea for typing out the exercises -->
                    <!-- submit btn -->
                    <button type="submit" id="add-selection-to-activities-textinput-btn" class="onefit-buttons-style-light p-4" disabled>
                        <span class="material-icons material-icons-round align-middle" style="font-size: 30px!important;">
                            add
                        </span>
                        save.
                    </button>
                </form>
                _END;

                echo $formHTML;

                // echo $activities_bar_content;
                // $result = null;
                $result = null;
                $dbconn->close();
            }
        } catch (\Throwable $th) {
            //throw $th;
            die("exception error: [indi edit-add new activity] " . $th->getMessage);
        }
    }
} else {
    die("Error: No day or grcode provided");
}
