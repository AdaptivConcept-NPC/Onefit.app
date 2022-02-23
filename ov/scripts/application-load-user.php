<?php
    session_start();
    include("config.php");
    
    //Connection Test==============================================>
        // Check connection
        /*if ($db->connect_error) {
            die("<div class='p-4 alert alert-danger'>Connection failed: " . $db->connect_error) . "</div>";
        }
        echo "Connected successfully";*/
    //end of Connection Test============================================>

    $myusername = mysqli_real_escape_string($db,$_GET['usr']);

    //loading: Home tab
    //latest (community post, program, group post (for each group that the user is a member of),
    //overdue and pending activities,etc)
    
    //fitness resources (latest 50 resources)
    
    //community posts (latest 50 posts)

    //=====================================================================================>
    
    //loading: Dashboard

    //=====================================================================================>
    
    //loading: Profile
    //user profile pic url

    //name, surname, username

    //community and resource shares (latest 50 posts each)

    //users media items

    //subscriptions (programs)

    //Favourites

    //users friends list

    //groups that the user is a member of

    //=====================================================================================>

    //loading: Discover (load max of 50 records)
    //People
    $sql = "SELECT `username`, `user_name`, `user_surname` FROM `users`"; //WHERE `username` = '$myusername' OR `user_email` = '$myusername'";

    $discoverPeopleList = "";

    if($result = mysqli_query($db,$sql)){
        
        while($row = mysqli_fetch_assoc($result)){
            $username = $row["username"];
            $name = $row["user_name"];
            $surname = $row["user_surname"];

            $discoverPeopleList .= `<div class="basic-tile">
      <h1>$name $surname</h1>
      <p>@<span>$username</span></p>
    </div>`;
        }
    }

    //Posts (no query for this, it will only be done once the user performs a search)

    //groups

    //resources

    //activities

    //=====================================================================================>

    //loading: Activities
    //community pposts (latest 50 posts)

    //fitness programs (all)
    
    //trainers (max 50)

    //gym assist (all)

    //=====================================================================================>
?>