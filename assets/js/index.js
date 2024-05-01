const URL = "https://api.adviceslip.com/advice";
const adviceNumber = document.querySelector(".app-counter");
const randomButton = document.querySelector(".app-button");
const adviceMsg = document.querySelector(".app-msg");
const dice = document.querySelector(".app-dice");

// Animation parameters
const deg = ["rotate(0deg)", "rotate(180deg)"];

// Animation for the dice
randomButton.addEventListener("mouseover", () => {
  dice.style.transform = deg[1];
});

randomButton.addEventListener("mouseout", () => {
  dice.style.transform = deg[0];
});
