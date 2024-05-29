<?php

declare(strict_types=1);

require_once __DIR__ . "/autoload.inc.php";

use DB\FetchAdvices;
use JSON\JSONhandler;

# Creating the object for fetching pieces of advice
$fetchAdvices = new FetchAdvices();

# Getting pieces of advice from DataBase and saving them into a variable.
$piecesOfAdvices = $fetchAdvices->get_pieces_of_advices();

# Getting the random advice after selection
$advice = $fetchAdvices->get_random_advice($piecesOfAdvices);

# Handling the GET request for the advice
JSONhandler::display_api_data($_SERVER['REQUEST_METHOD'], $advice);
