<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
    <!--fontawesome-->
    <script src="https://kit.fontawesome.com/a2763a58b1.js"></script>

    <link rel="stylesheet" href="../../styles_depracated.css" />

    <title>Profile Setup | onefit&trade; &copy; 2021 AdaptivConcept</title>

    <style>
        .proceed-btn-container {
            position: fixed;
            z-index: 1110;
            bottom: 0;
            right: 0;
        }
    </style>
</head>
<body class="fitness-bg h-100">
    <div class="proceed-btn-container p-4">
        <button class="menu-toggle p-4" type="button" data-toggle="modal" data-target="#navigationModal">
            <i class="fas fa-save"></i> Save my profile <i class="fas fa-arrow-right"></i>
        </button>
    </div>

    <nav class="navbar text-white sticky-top m-0" style="background: #333">
      <a class="navbar-brand align-items-center" href="../../../registration/index.html">
        <img src="../../../media/assets/One-Symbol-Logo-Two-Tone.png" class="d-inline-block align-top" alt="onefit logo" style="height: 50px; width: auto" />
      </a>
      <h1 class="light-h-text">one<span style="color: #ffa500 !important">fit</span><span style="font-size: 10px">&trade;</span></h1>
      <button class="menu-toggle" type="button" data-toggle="modal" data-target="#navigationModal">
        <i class="fas fa-fingerprint m-4"></i>
      </button>
    </nav>
    <div class="container -fluid dark-grad-fade-panel border-bottom border-dark" style="height: 80%; border-radius: 0 0 25px 25px; overflow-y: auto">
        <h1 class="text-center mt-4">Setup your profile | <span style="color: #ffa500">@username</span></h1>

        <div class="row my-4">
            <div class="col-md-4">
                <h5>Account details</h5>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Name</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Surname</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Gender</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Race</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Email address</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Contact number</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> ID/Passport number</li>
                    <li class="list-group-item bg-transparent rounded-pill shadow my-2"><i class="fas fa-edit" style="color: #ffa500; font-size: 25px"></i> Residential address</li>
                </ul>
            </div>
            <div class="col-md-8">
                <h5>Profile details</h5>
                
                <div class="container-fluid">
                    <div class="row align-items-center tunnel-bg m-4 py-2" style="border-radius: 25px">
                        <div class="col-lg -4 text-center center-container" style="overflow: hidden">
                            <div class="profile-img-container center-container">
                                <img src="../../../media/images/fitness/photo-1574680096145-d05b474e2155.jpg" class="" id="" alt="" />
                            </div>
                        </div>
                        <div class="col-lg -8">
                            <div class="text-center" style="font-size: 50px; font-family: 'MuseoModerno', cursive"><!--<?php echo $usrprof_name.' '.$usrprof_surname.' <span id="" class="profile-username-tag" style="font-size: 25px">@'.$usrprof_username.'</span>' ;?>--></div>
                            <hr class="bg-white">
                            <div class="text-center">
                                <ul class="list-group list-group-horizontal-lg justify-content-center">
                                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                                        <p class="font-weight-bold" style="color: #ffa500"><u>About</u></p class="font-weight-bold" style="color: #ffa500">
                                        <div class="text-wrap">
                                        <!--<?php echo $usr_about;?>-->
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                                        <p class="font-weight-bold" style="color: #ffa500"><u>Mutual</u></p class="font-weight-bold" style="color: #ffa500">
                                        <div class="">
                                        
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                                        <p class="font-weight-bold" style="color: #ffa500"><u>Achievements</u></p class="font-weight-bold" style="color: #ffa500">
                                        <div class="">
                                        
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-transparent border-0 py-0 pl-0 pr-2">
                                        <p class="font-weight-bold" style="color: #ffa500"><u>Social</u></p class="font-weight-bold" style="color: #ffa500">
                                        <div class="">
                                        
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>