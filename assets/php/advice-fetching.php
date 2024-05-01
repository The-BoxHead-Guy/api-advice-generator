<?php

const URL = 'https://api.adviceslip.com/advice';

$data = "";
$id = "";
$advice = "";

function callApi()
{
    global $data, $id, $advice;

    $data = file_get_contents(URL, true);
    $data = json_decode($data, true);

    /**
     * Ready variables for use 
     */

    $id = $data['slip']['id'];
    $advice = $data['slip']['advice'];
}

callApi();

$q = $_REQUEST["q"];

if ($q === 'sent') {
    callApi();
    echo $advice;
    echo $id;
}

/**
 * Resetting API data and HTML items display
 */
