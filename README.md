# Watson API
The Watson API module utilizes the PHP Watson API Bridge PHP class (https://github.com/findbrok/php-watson-api-bridge) to make interacting with the IBM Watson API straight forward.

API: https://watson-api-explorer.mybluemix.net/
API Explorer: https://watson-api-explorer.mybluemix.net/

## Dependencies
* Key Module - https://www.drupal.org/project/key `composer require drupal/key`
* PHP Watson API Bridge - Works best if you are user a Composer based approach for managing Drupal and contributed modules. `composer require findbrok/php-watson-api-bridge`

## Configuration

### Create Watson API Credentials

Be sure to create API credentials for the endpoint you are implementing. For example, if you are using `text-to-speech`, make sure the API username and password are created for for `text-to-speech`.

### Drupal configuration

1. Create a Key
   1. Visit /admin/config/system/keys/add
   2. ![Key Settings](https://www.evernote.com/l/AMk1S4TubeBN7LfaqfpiOJc78_ZZo28LsFQB/image.png)
   3. If you go the preferred file route for the password, please make sure there is no white space in the file!
2. Configure API Settings
   1. Visit /admin/config/watsonapi
   2. Add your API Username, the API base url + endpoint you are implementing and reference the password created in step #1
   3. ![Watson API Settings]( https://www.evernote.com/l/AMl03zOPu9dJWo5q5N5dBr_7En_ZHqY-DxAB/image.png)

## Usage

This module provides a `watson_api.client` service that can be used in Drupal hooks or in Classes using Dependency Injection.

You may use either the `get` or `post` methods defined by `findbrok/php-watson-api-bridge`.

See https://github.com/findbrok/php-watson-api-bridge/blob/1.1/src/Bridge.php.

### Drupal hook_ example:

```
/**
 * Implements hook_ENTITY_TYPE_presave().
 */
function hook_node_presave(EntityInterface $entity) {
  // Create an audio file using Watson's text-to-speech on node_presave.
  if ($entity->isNew()) {
    // Options: https://www.ibm.com/watson/developercloud/doc/text-to-speech/http.shtml.

    $query_params = [
      'accept' => 'audio/wav',
      'voice' => 'en-US_AllisonVoice',
      'text' => $entity->field_text->getString(),
    ];

    // Guzzle response has an exception.
    try {
      $watson = Drupal::service('watson_api.client');
      $result = $watson->get('v1/synthesize', $query_params);
    }
    catch (\Exception $e) {
      Drupal::logger('my_module')->error('Exception. The audio file could not be created.');
      return FALSE;
    }

    // Note: Directory and filename can be dynamic or anything you want them to be.
    $file = file_save_data($result->getBody(), 'public://' . $directory . '/' . $filename, FILE_EXISTS_REPLACE);

    // Save created audio file to node.
    $entity->field_audio->setValue(['target_id' => $file->id()]);
  }
}
```
