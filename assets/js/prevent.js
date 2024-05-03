//todo: Document all the segments of the code for better comprehension
const adviceForm = document.getElementById("advice-form");

console.log("working");

function adviceHandler(value) {
  console.log("working inside");

  const xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const advice = document.querySelector("#app-msg");
      const msg = document.querySelector(".app-counter");

      const jsonObj = JSON.parse(this.responseText);

      let id = jsonObj.id;
      let pieceOfAdvice = jsonObj.advice;

      advice.innerHTML = pieceOfAdvice;
      msg.innerHTML = `#${id}`;
    }
  };
  xmlHttp.open("GET", "./assets/php/advice-fetching.php?q=" + "sent", true);
  xmlHttp.send();
}

adviceForm.addEventListener("submit", (event) => {
  event.preventDefault();
  adviceHandler();
});
