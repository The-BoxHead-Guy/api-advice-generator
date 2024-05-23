<?php

declare(strict_types=1);

# Getting needed files
spl_autoload_register('auto_loader');

function auto_loader(string $className)
{
  # Replace namespace with path
  $className = str_replace("\\", "/", $className);

  # Set relative path from 'includes' folder
  $relativePath = pathinfo(__FILE__, PATHINFO_DIRNAME);

  /**
   * Log errors
   * error_log("{$className} - {$relativePath}");
   */

  # Set path depending on file summoning
  if (strpos($relativePath, "includes") !== false) {
    $path = "../classes/";
  } else {
    $path = "assets/classes/";
  }

  $extension = ".class.php";
  $fullPath = $path . $className . $extension;

  try {
    if (!file_exists($fullPath)) {
      throw new Exception();
    }
  } catch (Exception $e) {
    die("{$fullPath} not found");
  }

  include_once $fullPath;
}
