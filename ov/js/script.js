/*code for displaying notifications*/
function showNotification() {
  const notification = new Notification("New message from Thabang!", {
    body: "Welcome to the onefit web app. Powered by One-On-One Fitness Network® and AdaptivConcept®(Media) © 2021",
    icon: "../media/assets/One-Symbol-Logo-Two-Tone.svg",
  });

  notification.onclick = (e) => {
    window.location.href = "";
  };
}

//default, granted, denied
console.log(Notification.permission);

if (Notification.permission === "granted") {
  showNotification;
} else if (Notification.permission !== "denied") {
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
      showNotification();
    }
  });
}
/*end - code for displaying notifications*/
