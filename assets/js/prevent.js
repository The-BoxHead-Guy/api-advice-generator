const adviceForm = document.getElementById("advice-form");

console.log("working");

function adviceHandler(value) {
  console.log("working inside");

  const xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const advice = document.querySelector("#app-msg");
      const msg = document.querySelector(".app-counter");

      console.log(this);

      advice.innerHTML = this.responseText;
      //   msg.innerHTML = this
    }
  };
  xmlHttp.open("GET", "./assets/php/advice-fetching.php?q=" + "sent", true);
  xmlHttp.send();
}

adviceForm.addEventListener("submit", (event) => {
  event.preventDefault();
  adviceHandler();
});
/*  */