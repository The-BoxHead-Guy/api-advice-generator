<?php

include "../assets/php/advice-fetching.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- displays site properly based on user's device -->

  <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon-32x32.png" />

  <!-- Initializing inner files -->

  <link rel="stylesheet" href="/assets/css/normalize.css" />
  <link rel="stylesheet" href="/assets/css/index.css" />
  <script src="/assets/js/index.js" defer></script>
  <script src="/assets/js/prevent.js" async></script>

  <title>Advice generator app</title>
</head>

<body>
  <main class="app">
    <!-- Advice title -->
    <div class="container">
      <h3 id="title" class="app-title">
        Advice <span class="app-counter">
          <?= "#" . $id; ?>
        </span>
      </h3>
    </div>

    <!-- Advice Message -->
    <div class="container">
      <p id="app-msg" class="app-msg">
        <!-- PHP code injection -->
        <?= $advice; ?>
      </p>
    </div>

    <!-- Divider -->
    <picture class="container">
      <source media="(min-width: 768px)" srcset="./images/pattern-divider-desktop.svg" alt="" class="app-divider" />
      <img src="./images/pattern-divider-mobile.svg" alt="" class="app-divider" />
    </picture>

    <!-- Advice button -->
    <form class="container" id="advice-form">
      <button class="app-button">
        <img src="./images/icon-dice.svg" alt="dice" class="app-dice" />
      </button>
    </form>
  </main>
</body>

</html>