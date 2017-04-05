<?php

namespace Drupal\watson_api\Form;

use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {

  public function getFormId() {
    return 'watson_api_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->getConfig();

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Watson API Username'),
      '#default_value' => $config->get('username'),
      '#description' => $this->t('The username attached to the specific IBM Watson API.'),
    ];

    $form['base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Watson API Base URL'),
      '#default_value' => $config->get('base_url'),
      '#description' => $this->t('Include trailing slash.'),
    ];

    $form['password_id'] = [
      '#type' => 'key_select',
      '#title' => $this->t('Watson Password Key'),
      '#default_value' => $config->get('password_id'),
    ];

    return parent::buildForm($form, $form_state);
  }

}
