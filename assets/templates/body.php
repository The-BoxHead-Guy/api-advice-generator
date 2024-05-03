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