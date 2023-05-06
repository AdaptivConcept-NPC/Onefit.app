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

        // re-initialize app content (depr)
        // initializeContent("init", "init");

        // add .my-pulse-animation-light class and remove .shadow class from #main-app-refresh-btn
        document.getElementById('main-app-refresh-btn').classList.remove('shadow');
        document.getElementById('main-app-refresh-btn').classList.add('my-pulse-animation-light');
        // $('#main-app-refresh-btn').removeClass('shadow');
        // $('#main-app-refresh-btn').addClass('my-pulse-animation-light');

    }
}

// form validation
// .needs-validation
// (https://getbootstrap.com/docs/5.3/forms/validation/#server-side) Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()

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

// *** date functions
// use moment.js to get an array of dates (this week; last week or next weeks dates need to get a modifier that subtracts or adds 7 days to the functions loop cycle???)
// source: https://stackoverflow.com/questions/52108938/how-to-get-last-3-weeks-date-range-using-moment#52109339
function getWeekRange(week = 0) {
    var weekStart = moment().add(week, 'weeks').startOf('week');
    var days = [];
    for (var i = 1; i <= 7; i++) { //start the iteration from 1 (monday) not 0 (sunday), add <= to make sure it iterates a total of 7 times
        days.push(weekStart.clone().add(i, 'day').format('YYYY-MM-DD'));
    }
    return days;
}


function getSpecificWeekRange(dateStr = new Date()) {
    var dateStr = new Date(dateStr);
    var weekStart = moment(dateStr).startOf('week');
    var days = [];
    for (var i = 1; i <= 7; i++) { //start the iteration from 1 (monday) not 0 (sunday), add <= to make sure it iterates a total of 7 times
        days.push(weekStart.clone().add(i, 'day').format('YYYY-MM-DD'));
    }
    return days;
}

// function to get dates day name
// source: http://stackoverflow.com/questions/24998624/ddg#45464959
function getDayName(dateStr, locale) {
    var date = new Date(dateStr);
    return date.toLocaleDateString(locale, { weekday: 'long' });
}
// *** date functions (end)

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

// capitalize the first letter of passed string
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// formation & tactics functions
function tacticalPlanModification(action, playerId) {
    // params: 'action-','player_id'
}

function modifyFormationPlayerRecord(changeReq, playerId) {
    // params: 'change-requested', 'player_id'
    // changeReq can be: 'position', ???
    switch (changeReq) {
        case 'position':
            // we want to show the position modification modal
            document.getElementById("modifyPlayerDataModalLabel").innerHTML = "Change Player Position (" + playerId + ")";

            // show the modifyPlayerDataModal by clicking the toggle-modifyPlayerDataModal-btn
            document.getElementById("toggle-modifyPlayerDataModal-btn").click();

            break;

        default:
            break;
    }
}

// js cookie functions - https://www.w3schools.com/js/js_cookies.asp
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie(cookieName) {
    let reqCookie = getCookie(cookieName);
    if (reqCookie != "") {
        console.log("checkCookie -> cookie exists: " + reqCookie);
        return true;
    } else {
        console.log("checkCookie -> cookie does not exists: " + reqCookie);
        return false;
    }
}