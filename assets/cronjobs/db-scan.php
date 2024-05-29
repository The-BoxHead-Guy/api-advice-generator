<?php

declare(strict_types=1);

require_once __DIR__ . "/../includes/autoload.inc.php";

use DB\Dbscan;
use JSON\SlipAdvice;

# Initializing objects for further use
$DBscan = new Dbscan();
$SlipAdvice = new SlipAdvice();

# Retrieving data from the API
$data = $SlipAdvice->get_api_data();

# Setting advice string from the API
$advice = $data["slip"]["advice"];

# Saving all the texts of the pieces of advices existent in the DB
$list_advice_texts = $DBscan->get_advice_text();
/* foreach ($list_advice_texts as $key => $text) {
  # code...
  echo "ID " . ($key + 1) . ": " . $text["advice_text"] . PHP_EOL;
} */

# Counting how many pieces of advice existent in the DB
$data_amount = $DBscan->get_data_amount();
echo "Data amount: " . $data_amount . PHP_EOL;

# Inserting the data into the DB and logging it into the log file
$DBscan->insert_data($advice, $list_advice_texts);
