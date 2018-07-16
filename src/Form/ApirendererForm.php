<?php

/**
 * @file
 * Contains \Drupal\apirenderer\Form\ApirendererForm.
 */

namespace Drupal\apirenderer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class ApirendererForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'apirenderer_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('apirenderer.settings');
    foreach ($form_state->getValues() as $key => $value) {
      $config->set($key, $value);
    }
    $config->save();
    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }
    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['apirenderer.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = 'apirenderer/js';
    $form['apirenderer_proxy'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Proxy Address'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_proxy'),
      '#size' => '20',
      '#description' => 'If the server is set up to require a proxy address, enter it here.',
      '#maxlength' => '40',
      '#required' => '0',
    ];
    //PROPUBLICA ADMIN FORM
    $form['apirenderer_propublica'] = [
      '#collapsed' => '0',
      '#type' => 'fieldset',
      '#collapsible' => '1',
      '#title' => $this->t('Pro Publica API Settings'),
    ];
    $form['apirenderer_propublica']['apirenderer_propublica_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ID'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_propublica_id'),
      '#size' => '20',
      '#description' => 'This should be the same as the congressperson\'s ID. Case sensitive.',
      '#maxlength' => '20',
      '#required' => '0',
    ];
    $form['apirenderer_propublica']['apirenderer_propublica_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Access Key'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_propublica_key'),
      '#size' => '60',
      '#description' => 'Enter only the Access Key for the Pro Publica API. Case sensitive.',
      '#maxlength' => '300',
      '#required' => '0',
    ];
    $form['apirenderer_propublica']['apirenderer_propublica_default_results'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Results Per Page'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_propublica_default_results'),
      '#size' => '2',
      '#description' => 'Max: 50',
      '#max' => 50,
      '#min' => 1,
      '#required' => '0',
    ];
    //EVENTBRITE ADMIN FORM
    $form['apirenderer_eventbrite'] = [
      '#collapsed' => '0',
      '#type' => 'fieldset',
      '#collapsible' => '1',
      '#title' => $this->t('Eventbrite API Settings'),
    ];
    $form['apirenderer_eventbrite']['apirenderer_eventbrite_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Key for Eventbrite API.'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_eventbrite_key'),
      '#size' => '60',
      '#description' => 'Enter only the Access Key for the eventbrite API. Case sensitive.',
      '#maxlength' => '300',
      '#required' => '0',
    ];
    $form['apirenderer_eventbrite']['apirenderer_eventbrite_noevents'] = [
      '#type' => 'textfield',
      '#title' => $this->t('No Events Message'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_eventbrite_noevents'),
      '#size' => '60',
      '#description' => 'Enter the message to be displayed when no events are found.',
      '#maxlength' => '240',
      '#required' => '0',
    ];
    //INSTAGRAM ADMIN FORM
    $form['apirenderer_instagram'] = [
      '#collapsed' => '0',
      '#type' => 'fieldset',
      '#collapsible' => '1',
      '#title' => $this->t('Instagram Photo Gallery API Settings'),
    ];
    $form['apirenderer_instagram']['apirenderer_instagram_gallery_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Access Token for the Instagram Gallery API block.'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_instagram_gallery_token'),
      '#size' => '60',
      '#description' => ('An access token is required to pull Instagram data. If this field is blank, click <a href="" class="APIRendererTokenLink">here</a>.'),
      '#maxlength' => '300',
      '#required' => '0',
    ];
    $form['apirenderer_instagram']['apirenderer_instagram_gallery_short_default_results'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Results Per Page'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_instagram_gallery_short_default_results'),
      '#size' => '2',
      '#description' => 'How many results you would prefer on the short / sidebar-sized instagram API display. Max: 20.',
      '#max' => 20,
      '#min' => 1,
      '#required' => '0',
    ];
    $form['apirenderer_instagram']['apirenderer_instagram_gallery_short_main_node'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Main Node ID'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_instagram_gallery_short_main_node'),
      '#size' => '2',
      '#description' => 'Enter the Node ID of the main Instagram Gallery page here. Allows short version of the block to have a Read More link. This can be found by editing the page on which the main gallery is located, if you do not know it.',
      '#maxlength' => '20',
      '#required' => '0',
    ];
    //FACEBOOK ADMIN FORM
    $form['apirenderer_facebook'] = [
      '#collapsed' => '0',
      '#type' => 'fieldset',
      '#collapsible' => '1',
      '#title' => $this->t('Facebook Graphs API Settings'),
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facebook ID for API.'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_id'),
      '#size' => '20',
      '#description' => 'Use <a href="https://findmyfbid.com/">this site</a> to get your ID number, if you cannot find it.',
      '#maxlength' => '20',
      '#required' => '0',
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Access Token for the Facebook Graph blocks.'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_token'),
      '#size' => '60',
      '#description' => 'An access token is required to pull Facebook data.',
      '#maxlength' => '300',
      '#required' => '0',
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_album_short_default_results'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Results Per Page (Albums)'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_album_short_default_results'),
      '#size' => '2',
      '#description' => 'How many results you would prefer on the short / sidebar-sized Facebook Graph Albums API display. Max: 20.',
      '#max' => 20,
      '#min' => 1,
      '#required' => '0',
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_album_short_main_node'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Main Node ID (Albums)'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_album_short_main_node'),
      '#size' => '20',
      '#description' => 'Optional. Enter the Node ID of the main Facebook Graph Album Gallery page here. Allows short version of the block to have a Read More link. This can be found by editing the page on which the main gallery is located, if you do not know it.',
      '#maxlength' => '20',
      '#required' => '0',
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_feed_short_default_results'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Results Per Page (Feed)'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_feed_short_default_results'),
      '#size' => '2',
      '#description' => 'How many results you would prefer on the short / sidebar-sized Facebook Graph Feed API display. Max: 20.',
      '#max' => 20,
      '#min' => 1,
      '#required' => '0',
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_feed_short_message_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Facebook Post Max Length'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_feed_short_message_length'),
      '#size' => '2',
      '#description' => 'How long would you like facebook posts to be in length, at most?',
      '#max' => 500,
      '#min' => 1,
      '#required' => '0',
    ];
    $form['apirenderer_facebook']['apirenderer_facebook_feed_short_main_node'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Main Node ID (Feed)'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_facebook_feed_short_main_node'),
      '#size' => '20',
      '#description' => 'Optional. Enter the Node ID of the main Facebook Graph Feed page here. Allows short version of the block to have a Read More link. This can be found by editing the page on which the main gallery is located, if you do not know it.',
      '#maxlength' => '20',
      '#required' => '0',
    ];
    //TWITTER ADMIN FORM
    $form['apirenderer_twitter'] = [
      '#collapsed' => '0',
      '#type' => 'fieldset',
      '#collapsible' => '1',
      '#title' => $this->t('Twitter API Settings'),
      '#description' => 'Visit <a href="https://apps.twitter.com/">apps.twitter.com</a> to create your twitter developer account and obtain your consumer keys',
    ];
    $form['apirenderer_twitter']['apirenderer_twitter_consumer_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter Consumer Key (API KEY).'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_twitter_consumer_key'),
      '#size' => '50',
      '#description' => 'Consumer Token',
      '#maxlength' => '150',
      '#required' => '0',
    ];
    $form['apirenderer_twitter']['apirenderer_twitter_consumer_key_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter Secret Consumer Key (API KEY).'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_twitter_consumer_key_secret'),
      '#size' => '150',
      '#description' => 'Consumer Secret Key',
      '#maxlength' => '150',
      '#required' => '0',
    ];
    $form['apirenderer_twitter']['apirenderer_twitter_oauth_access_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter Oauth Access Token.'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_twitter_oauth_access_token'),
      '#size' => '150',
      '#description' => 'Twitter Oauth Token',
      '#maxlength' => '300',
      '#required' => '0',
    ];
    $form['apirenderer_twitter']['apirenderer_twitter_oauth_access_token_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter Oauth Access Token Secret.'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_twitter_oauth_access_token_secret'),
      '#size' => '50',
      '#description' => 'Twitter Oauth Secret Token',
      '#maxlength' => '50',
      '#required' => '0',
    ];
    $form['apirenderer_twitter']['apirenderer_twitter_user_timeline'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter Account/timeline'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_twitter_user_timeline'),
      '#size' => '20',
      '#description' => 'Twitter username',
      '#maxlength' => '20',
      '#required' => '0',
    ];

    $form['apirenderer_twitter']['apirenderer_twitter_count'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of Tweets'),
      '#default_value' => $this->config('apirenderer.settings')->get('apirenderer_twitter_count'),
      '#size' => '3',
      '#description' => 'Max number of tweets to show in your timeline',
      '#maxlength' => '3',
      '#max' => 20,
      '#min' => 1,
      '#required' => '0',
    ];
    //$form['#attached']['js'] = [
      //drupal_get_path('module', 'apirenderer') . '/js/apirenderer.js'
      //];
    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $proxy_address = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_proxy'])));
    $propublica_key = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_propublica_key'])));
    $propublica_id = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_propublica_id'])));
    $propublica_results = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_propublica_default_results'])));
    $eventbrite_key = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_eventbrite_key'])));
    $eventbrite_noEvents = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_eventbrite_noevents'])));
    $instagram_token = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_instagram_gallery_token'])));
    $instagram_results = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_instagram_gallery_short_default_results'])));
    $facebook_token = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_facebook_token'])));
    $facebook_id = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_facebook_id'])));
    $facebook_results = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_facebook_album_short_default_results'])));
    $facebook_mlength = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_facebook_feed_short_message_length'])));
    $twitter_consumer_key = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_twitter_consumer_key'])));
    $twitter_consumer_key_secret = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_twitter_consumer_key_secret'])));
    $twitter_oauth_access_token = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_twitter_oauth_access_token'])));
    $twitter_oauth_access_token_secret = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_twitter_oauth_access_token_secret'])));
    $twitter_user_timeline = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_twitter_user_timeline'])));
    $twitter_count = \Drupal\Component\Utility\Html::escape(trim($form_state->getValue(['apirenderer_twitter_count'])));

    //Now that the variables are pulled in, this will validate each in turn.
    //Validate PROXY
    if (!empty($proxy_address)) {
      \Drupal::configFactory()->getEditable('apirenderer.settings')->set('apirenderer_proxy', $proxy_address)->save();
    }
    //Validate PROPUBLICA
    if (!empty($propublica_key) && !empty($propublica_id)) {
      if (!is_numeric($propublica_results) || $propublica_results <= 0 || $propublica_results > 50) {
        $form_state->setErrorByName('apirenderer_propublica_default_results', $this->t('Please enter a valid number.'));
      }
      else {
        $dataResult = getDataPropublica($propublica_key, $propublica_id);
        if ($dataResult !== TRUE) {
          $form_state->setErrorByName('apirenderer_propublica', $this->t("Propublica Error: $dataResult"));
        }
      }
    }
    //Validate EVENTBRITE
    if (!empty($eventbrite_key)) {
      $dataResult = getDataEventbrite($eventbrite_key, $eventbrite_noEvents);
      if ($dataResult !== TRUE) {
        $form_state->setErrorByName('apirenderer_eventbrite', $this->t("Eventbrite Error: $dataResult"));
      }
    }
    //Validate Instagram
    if (!empty($instagram_token)) {
      if (!is_numeric($instagram_results) || $instagram_results <= 0 || $instagram_results > 20) {
        $form_state->setErrorByName('apirenderer_instagram_gallery_short_default_results', $this->t("Please enter a valid number."));
      }
      else {
        $dataResult = getDataInstagram($instagram_token);
        if ($dataResult !== TRUE) {
          $form_state->setErrorByName('apirenderer_instagram', $this->t("Instagram Error: $dataResult"));
        }
      }
    }
    //Validate FACEBOOK
    if (!empty($facebook_token) && !empty($facebook_id)) {
      if (!is_numeric($facebook_results) || $facebook_results <= 0 || $facebook_results > 20 || !is_numeric($facebook_mlength) || $facebook_mlength <= 0) {
        $form_state->setErrorByName('apirenderer_facebook_album_short_default_results', $this->t("Please enter a valid number."));
      }
      else {
        //$dataResultAl = getDataFacebook($facebook_token, $facebook_id, 'albums');
			//if ($dataResultAl !== true) {
			//	form_set_error('apirenderer_facebook', $this->t("Facebook Album Error: $dataResultAl"));
			//}
        $dataResultFe = getDataFacebook($facebook_token, $facebook_id, 'feed');
        if ($dataResultFe !== TRUE) {
          $form_state->setErrorByName('apirenderer_facebook', $this->t("Facebook Feed Error: $dataResultFe"));
        }
      }
    }
    //Validate TWITTER
    if (!empty($twitter_consumer_key) && !empty($twitter_consumer_key_secret) && !empty($twitter_oauth_access_token) && !empty($twitter_oauth_access_token_secret) && !empty($twitter_user_timeline) && !empty($twitter_count)) {
      if (!is_numeric($twitter_count) || $twitter_count <= 0 || $twitter_count > 20) {
        $form_state->setErrorByName('apirenderer_twitter_count', $this->t("Please enter a valid number."));
      }
      else {
        $dataResultTwitter = getDataTwitter($twitter_oauth_access_token, $twitter_oauth_access_token_secret, $twitter_consumer_key, $twitter_consumer_key_secret, $twitter_user_timeline, $twitter_count);
        if ($dataResultTwitter !== TRUE) {
          $form_state->setErrorByName('apirenderer_twitter', $this->t("Twitter Feed Error: $dataResultTwitter"));
        }
      }
    }
  }
}
?>
