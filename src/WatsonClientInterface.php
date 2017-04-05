<?php

namespace Drupal\watson_api;

interface WatsonClientInterface {

  /**
   * Simple get request
   * https://github.com/findbrok/php-watson-api-bridge
   *
   * @param $uri
   *   A URI from the Watson Explorer https://watson-api-explorer.mybluemix.net/
   * @param $query_params
   *   Array of options applicable to the Watson API URI being called.
   * @return object
   *   \GuzzleHttp\Psr7\Response
   */
   public function get($uri, $query_params);

  /**
   * Simple post request
   * https://github.com/findbrok/php-watson-api-bridge
   *
   * @param $uri
   *   A URI from the Watson Explorer https://watson-api-explorer.mybluemix.net/
   * @param $data_to_post
   *   Array of options applicable to the Watson API URI being called.
   * @return object
   *   \GuzzleHttp\Psr7\Response
   */
   public function post($uri, $data_to_post, $format = 'json');
}
