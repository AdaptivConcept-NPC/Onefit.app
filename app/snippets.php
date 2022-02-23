<?php

// get the other profile details
$outputSocialItems = getUserSocials();
$outputProfileUserSubsGroupsList = getUserGroups();
$outputProfileUsersPostsList = getUserUpdates();
$outputProfileUsersResourcesList = getUserResources();
$outputProfileUsersProgramsList = getUserProgSubs();
$outputProfileUserFriendsList = getUserFriends();
$outputProfileUsersFavesList = getUserSaves();
$outputProfileUserMediaList = getUserMedia();
$outputProfileUserNotifications = getUserNotifications();
$outputProfileUserChats = getUserChats();
$outputProfileUserPref = getUserPref();
$outputProfileUserChallenges = getUserChallenges();

// get the community content
$outputCommunityGroups = getCommunityGroups();
$outputCommunityNews = getCommunityNews();
$outputCommunityResources = getCommunityResources();
$outputCommunityUpdates = getCommunityUpdates();

// get the discovery content
$discoveryAllUsersList = getAllUsers();
$discoveryFitProgsIndi = getFitProgramsIndi();
$discoveryFitProgsTeams = getFitProgramsTeams();
$discoveryAllTrainees = getAllTrainees();
$discoveryAllTrainers = getAllTrainers();

//Declaring Variables
//getUserChats
$convo_conversationid = $convo_secondaryuser = $secondaryuser_name = $secondaryuser_surname = $communicationUserMessages =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $convo_conversationid, $convo_secondaryuser, $secondaryuser_name, $secondaryuser_surname, $communicationUserMessages, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserFriends
$friendid = $friendUsername = $friendName = $friendSurname = $profileUserFriendsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $friendid, $friendUsername, $friendName, $friendSurname, $profileUserFriendsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $profileUserSubsGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $grps_groupid, $grps_refcode, $grps_name, $grps_description, $grps_category, $grps_privacy, $grps_createdby, $grps_createdate, $profileUserSubsGroupsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserMedia
$fileList = $profileUserMediaList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $fileList, $profileUserMediaList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserNotifications
$notif_id = $notif_title = $notif_message = $notif_date = $communicationUserNotifications =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $notif_id, $notif_title, $notif_message, $notif_date, $communicationUserNotifications, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserPref

//getUserProgSubs
$programs_progid = $programs_refcode = $programs_title = $programs_description = $programs_duration = $programs_category = $programs_privacy = $programs_creator = $programs_active = $profileUsersProgramsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $programs_progid, $programs_refcode, $programs_title, $programs_description, $programs_duration, $programs_category, $programs_privacy, $programs_creator, $programs_active, $profileUsersProgramsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserResources
$usrresources_resourceid = $usrresources_title= $usrresources_description = $usrresources_type = $usrresources_link= $usrresources_sharedate = $usrresources_sharename= $usrresources_sharesurname = $profileUsersResourcesList= $dbconn= $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $usrresources_resourceid , $usrresources_title, $usrresources_description, $usrresources_type, $usrresources_link, $usrresources_sharedate, $usrresources_sharename, $usrresources_sharesurname, $profileUsersResourcesList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserSaves
$fave_id = $fave_ref = $fave_date = $post_id = $post_date = $post_msg = $mod_date = $poster_name = $poster_surname = $poster_username = $profileUsersFavesList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $fave_id, $fave_ref, $fave_date, $post_id, $post_date, $post_msg, $mod_date, $poster_name, $poster_surname, $poster_username, $profileUsersFavesList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserSocials
$usr_socialnet = $usr_socialhandle = $usr_sociallink = $socialNetworkIcon = $socialItems =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $usr_socialnet, $usr_socialhandle, $usr_sociallink, $socialNetworkIcon, $socialItems, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getUserUpdates
$usrposts_postid = $usrposts_postdate = $usrposts_message = $usrposts_user = $usrposts_faveref  = $usrposts_name = $usrposts_surname = $profileUsersPostsList =  $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $usrposts_postid, $usrposts_postdate, $usrposts_message, $usrposts_user, $usrposts_faveref , $usrposts_name, $usrposts_surname, $profileUsersPostsList, $dbconn, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getCommunityGroups
$grps_groupid = $grps_refcode = $grps_name = $grps_description = $grps_category = $grps_privacy = $grps_createdby = $grps_createdate = $discoverGroupsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $grps_groupid, $grps_refcode, $grps_name, $grps_description, $grps_category, $grps_privacy, $grps_createdby, $grps_createdate, $discoverGroupsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getCommunityNews
$news_id = $news_title = $news_content = $news_createdby = $news_date = $news_poster_name = $news_poster_surname = $communicationNews = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $news_id, $news_title, $news_content, $news_createdby, $news_date, $news_poster_name, $news_poster_surname, $communicationNews, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getCommunityResources
$resourceid = $resource_title = $resource_descr = $resource_type = $resource_link = $sharedbyUsername = $sharedate = $openlinkbtn = $outputCommunityResources = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $resourceid, $resource_title, $resource_descr, $resource_type, $resource_link, $sharedbyUsername, $sharedate, $openlinkbtn, $outputCommunityResources, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getCommunityUpdates
$commpost_postid = $commpost_postdate = $commpost_message = $commpost_user = $commpost_faveref = $commpost_usr_name = $commpost_usr_surname = $communityPosts = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $commpost_postid, $commpost_postdate, $commpost_message, $commpost_user, $commpost_faveref, $commpost_usr_name, $commpost_usr_surname, $communityPosts, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getAllUsers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $usrs_prof_acctype = $discoverPeopleList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $usrs_prof_acctype, $discoverPeopleList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getFitProgramsIndi
$indi_programs_progid = $indi_programs_refcode = $indi_programs_title = $indi_programs_description = $indi_programs_duration = $indi_programs_category = $indi_programs_privacy = $indi_programs_creator = $indi_programs_active = $discoverIndiProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $indi_programs_progid, $indi_programs_refcode, $indi_programs_title, $indi_programs_description, $indi_programs_duration, $indi_programs_category, $indi_programs_privacy, $indi_programs_creator, $indi_programs_active, $discoverIndiProgramsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getFitProgramsTeams
$team_programs_progid = $team_programs_refcode = $team_programs_title = $team_programs_description = $team_programs_duration = $team_programs_category = $team_programs_privacy = $team_programs_creator = $team_programs_active = $discoverteamProgramsList = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $team_programs_progid, $team_programs_refcode, $team_programs_title, $team_programs_description, $team_programs_duration, $team_programs_category, $team_programs_privacy, $team_programs_creator, $team_programs_active, $discoverTeamProgramsList, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getAllTrainees
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTraineesList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTraineesList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;

//getAllTrainers
$usrs_userid = $usrs_username = $usrs_name = $usrs_surname = $usrs_idnumber = $usrs_email = $usrs_contact = $usrs_dob = $usrs_gender = $usrs_race = $usrs_nationality = $usrs_acc_active = $activitiesTrainersList = $usrs_prof_acctype = $currentUser_Usrnm = $output = $output_msg = $app_err_msg = "";

global $dbconn, $usrs_userid, $usrs_username, $usrs_name, $usrs_surname, $usrs_idnumber, $usrs_email, $usrs_contact, $usrs_dob, $usrs_gender, $usrs_race, $usrs_nationality, $usrs_acc_active, $activitiesTrainersList, $usrs_prof_acctype, $currentUser_Usrnm, $output, $output_msg, $app_err_msg;


?>



