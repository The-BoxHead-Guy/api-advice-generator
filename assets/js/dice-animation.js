/**
 * Dice animation after hovering
 */
const randomButton = document.querySelector(".app-button");
const dice = document.querySelector(".app-dice");

// Animation parameters
const deg = ["rotate(0deg)", "rotate(180deg)"];

// After the hover of the dice button, its animation will be triggered
randomButton.addEventListener("mouseover", () => {
  dice.style.transform = deg[1];
});

randomButton.addEventListener("mouseout", () => {
  dice.style.transform = deg[0];
});
