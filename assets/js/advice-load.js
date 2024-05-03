/**
 * "advice-load.js" comprehends the loading of the advice after fetching and connection
 * with the backend API (PHP)
 */

// Selects the form where the advice is
const adviceForm = document.getElementById("advice-form");
const adviceElement = document.querySelector("#app-msg");
const messageElement = document.querySelector(".app-counter");
// console.log(adviceForm);

/**
 * Handles the advice by making an AJAX request to the server and updating the UI.
 * @param {event} value - The value to be passed to the server.
 * @return {string} - The response from the server.
 */
function adviceHandler(value) {
  // console.log("working inside");

  const xmlHttp = new XMLHttpRequest();
  xmlHttp.onload = function () {
    if (this.status === 200) {
      return updateUI(this.responseText);
    }
  };
  xmlHttp.open("GET", "./assets/php/advice-fetching.php?q=" + "sent", true);
  xmlHttp.send();
}

/**
 * Updates the UI with the provided value from the server.
 * @param {string} value - The value containing the advice and id.
 */
function updateUI(value) {
  // Convert the value to JSON for object parsing
  const response = JSON.parse(value);

  adviceElement.innerHTML = response.advice;
  messageElement.innerHTML = `#${response.id}`;
}

// Handles the form submission and prevents its default behavior.
adviceForm.addEventListener("submit", (event) => {
  event.preventDefault();
  adviceHandler();
});
