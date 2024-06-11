<?php

declare(strict_types=1);

namespace App\Json;

/**
 * Set the class that will make the connection the external API 'slip advice' whose URL is: https://api.adviceslip.com/advice
 */

class SlipAdvice
{
  private const API_URL = "https://api.adviceslip.com/advice";
  private $ch;

  /**
   * Initializes the connection to the API 'Slip Advices' and returns the "CurlHandler" of the connection
   * 
   * @return curlHandler
   */
  private function connect_api(string $string): object
  {
    $this->ch = curl_init($string);
    return $this->ch;
  }

  /**
   * Closes the connection of the API
   * 
   * @return void
   */
  private function close_api_connection(object $curlHandler)
  {
    curl_close($curlHandler);
  }

  /**
   * Retrieves data from the API connection and returns it.
   * 
   * @return string
   */
  public function get_api_data()
  {
    // Initializes the connection
    $this->connect_api(self::API_URL);

    // Set cURL options and transfer
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

    // Executes the cURL and save data into '$files' decoded from JSON to ASSOC_ARRAY
    $files = json_decode(curl_exec($this->ch), true);

    // Closes cURL connection
    $this->close_api_connection($this->ch);

    return $files;
  }
}
