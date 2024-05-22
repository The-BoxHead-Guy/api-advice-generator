<?php

declare(strict_types=1);

# Getting needed files
spl_autoload_register('auto_loader');

function auto_loader(string $className)
{
  # Replace namespace with path
  $className = str_replace("\\", "/", $className);

  # Get url from the client (Request)
  $url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

  # Set relative path from 'includes' folder
  $relativePath = pathinfo(__FILE__, PATHINFO_DIRNAME);

  error_log("{$className} - {$url} - {$relativePath}");

  # Set path depending on file summoning
  if (strpos($url, "includes") !== false || strpos($relativePath, "includes") !== false) {
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
