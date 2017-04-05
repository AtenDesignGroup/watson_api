<?php

namespace Drupal\watson_api\Client;

use \FindBrok\WatsonBridge\Bridge;
use Drupal\Core\Config\ConfigFactory;
use Drupal\key\KeyRepositoryInterface;
use Drupal\watson_api\WatsonClientInterface;

class WatsonClient implements WatsonClientInterface {

  /**
   * Watson Bridge Instance.
   *
   * @var FindBrok\WatsonBridge\Bridge
   */
  protected $bridge;

  /**
   * Constructor.
   */
  public function __construct(KeyRepositoryInterface $key_repo, ConfigFactory $config_factory) {
    $config = $config_factory->get('watson_api.settings');
    $username = $config->get('username');
    $password_id = $config->get('password_id');
    $base_url = $config->get('base_url');
    $this->connect($username, $key_repo->getKey($password_id)->getKeyValue(), $base_url);
  }

  /**
   * Handles authentication to the Watson API.
   */
  public function connect($username, $password, $base_url) {
    $this->bridge = new Bridge($username, $password, $base_url);
  }

  /**
   * { @inheritdoc }
   */
   public function get($uri, $query_params) {
     $response = $this->bridge->get($uri, $query_params);
     return $response;
   }

  /**
   * { @inheritdoc }
   */
   public function post($uri, $data_to_post, $format = 'json') {
     $response = $this->bridge->post($uri, $data_to_post, $format);
     return $response;
   }

}
