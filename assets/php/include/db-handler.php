<?php

require_once __DIR__ . "/../variables.php";

# Establishing the connection using 'PDO'
try {
  $pdo = new PDO(DSN, USERNAME, PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // echo "Connection established: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
