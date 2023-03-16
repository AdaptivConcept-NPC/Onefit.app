// *** Vanilla JS
function checkConnection() {
    console.log("Initially " + (window.navigator.onLine ? "on" : "off") + "line");

    window.addEventListener('online', () => isOffline(false));
    window.addEventListener('offline', () => isOffline(true));
}

function isOffline(state) {
    if (state) {
        // true - show curtain
        console.log('Is Offline');
        document.getElementById('offline-curtain').style.display = 'block';
    } else {
        // false - hide curtain
        console.log('Is Online');
        document.getElementById('offline-curtain').style.display = 'none';
    }
}

function loadUserProfile() {
    //Declaring variables
    var contentContainerProfile = document.getElementById("profile-panel-container");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
            contentContainerProfile.innerHTML = output;
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_profile.php", true);
    xhttp.send();
}

function loadUserSocials() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/", true);
    xhttp.send();
}

function loadUserChallenges() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_socials.php", true);
    xhttp.send();
}

function loadUserChat() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_chat.php", true);
    xhttp.send();
}

function loadUserFriends() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_friends.php", true);
    xhttp.send();
}

function loadUserGroups() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_groups.php", true);
    xhttp.send();
}

function loadUserMedia() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_media.php", true);
    xhttp.send();
}

function loadUserNotifications() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_notifications.php", true);
    xhttp.send();
}

function loadUserPref() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_pref.php", true);
    xhttp.send();
}

function loadUserSaves() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_saves.php", true);
    xhttp.send();
}

function loadUserGroups() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/userprofile/user_groups.php", true);
    xhttp.send();
}

function loadCommunityGroups() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_groups.php", true);
    xhttp.send();
}

function loadCommunityNews() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_news.php", true);
    xhttp.send();
}

function loadCommunityAchievements() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_achievements.php", true);
    xhttp.send();
}

function loadCommunityEvents() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_events.php", true);
    xhttp.send();
}

function loadCommunityMedia() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_media.php", true);
    xhttp.send();
}

function loadCommunityResources() {
    //Declaring variables
    var contentContainerResourceFeed = document.getElementById("v-pills-social-resfeed-content");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);

            contentContainerResourceFeed.innerHTML = output;
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_news.php", true);
    xhttp.send();
}

function loadCommunityRewards() {
    //Declaring variables
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            alert(output);
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_rewards.php", true);
    xhttp.send();
}

function loadCommunityUpdates() {
    //Declaring variables
    var contentContainerCommUpdatesA = document.getElementById("homeCommunityPosts");
    var contentContainerCommUpdatesB = document.getElementById("comm-updates-search-container");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");
    //// var contentContainer = document.getElementById("");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var output = this.responseText;
            //alert(output);

            contentContainerCommUpdatesA.innerHTML = output;
            contentContainerCommUpdatesB.innerHTML = output;
        }
    };
    xhttp.open("GET", "../scripts/php/main_app/community_sharing/community_updates.php", true);
    xhttp.send();
}

//Plyr.io JS Code
(function () {
    var video = document.querySelector('#player');

    if (Hls.isSupported()) {
        var hls = new Hls();
        hls.loadSource('https://content.jwplatform.com/manifests/vM7nH0Kl.m3u8');
        hls.attachMedia(video);
        hls.on(Hls.Events.MANIFEST_PARSED, function () {
            video.play();
        });
    }

    plyr.setup(video);
})();

//get twitter trends
/*var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    var output = this.responseText;
    alert(output);
  }
};
xhttp.open("GET", "https://api.twitter.com/1.1/trends/place.json?id=1", true);
xhttp.send();*/

function socialFunctions(action, origin) {
    alert("Action: " + action + " | Origin: " + origin);
}

//freeNBAUnofficial();

// *****snackbar scripting
function showSnackbar(message) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");

    // Add the "show" class to DIV
    x.className = "show";

    // pass the message into #snackbar
    x.innerHTML = message;

    // After 3 seconds, remove the show class from DIV
    setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
}

