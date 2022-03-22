function apiFootball() {
  const data = null;

  const xhr = new XMLHttpRequest();
  xhr.withCredentials = true;

  xhr.addEventListener("readystatechange", function () {
    if (this.readyState === this.DONE) {
      console.log(this.responseText);
    }
  });

  xhr.open("GET", "https://api-football-v1.p.rapidapi.com/v3/timezone");
  xhr.setRequestHeader("x-rapidapi-host", "api-football-v1.p.rapidapi.com");
  xhr.setRequestHeader("x-rapidapi-key", "ab458ebd29mshf31e41b9a91c946p1c5e4ejsn143351859245");

  xhr.send(data);
}

function freeNBAUnofficial() {
  const data = null;

  const xhr = new XMLHttpRequest();
  xhr.withCredentials = true;

  xhr.addEventListener("readystatechange", function () {
    if (this.readyState === this.DONE) {
      console.log(this.responseText);
    }
  });

  xhr.open("GET", "https://free-nba.p.rapidapi.com/stats?page=0&per_page=25");
  xhr.setRequestHeader("x-rapidapi-host", "free-nba.p.rapidapi.com");
  xhr.setRequestHeader("x-rapidapi-key", "ab458ebd29mshf31e41b9a91c946p1c5e4ejsn143351859245");

  xhr.send(data);
}