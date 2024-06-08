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

//todo: Use JWT authentication for: Registered users, Admins, and Guests users, and apply different app management for each of them.
# Getting HTTP headers
$headersRequests = apache_request_headers();

# Handling the GET request for the advice
/* switch (true) {
  case !isset($headersRequests["Authorization"]) && $requestsMade > 10:
    header("Authorization: null");
    header("Reason: No Authorization header provided");
    http_response_code(401);
    break;
} */
JSONhandler::display_api_data($_SERVER['REQUEST_METHOD'], $advice);
