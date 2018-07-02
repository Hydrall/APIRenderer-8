<?php

namespace Drupal\apirenderer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a twitter feed block.
 *
 * @Block(
 *   id = "apirenderer_twitter_block",
 *   admin_label = @Translation("APIrenderer Twitter Feed Block"),
 *   category = @Translation("APIRenderer")
 * )
 */
class apirendererTwitterBlock extends BlockBase implements BlockPluginInterface {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $config = $this->getConfiguration();
        $return = 'test';
        $tweetlist = '';
        $data = \Drupal::state()->get('apirenderer.twitterData') ?: FALSE;
        if ($data) {
            if (array_key_exists('user', $data[0])) {
                $content = '';
                foreach ($data as $num => $tweet) {
                    $type = 'twitter';
                    $icon = $tweet['user']['profile_image_url_https'];
                    $name = $tweet['user']['screen_name'];
                    $id = $tweet['id_str'];
                    $message = $this->formattedTweet($tweet['text']);
                    $url = "https://twitter.com/statuses/$id";
                    $date = time_elapsed_string('@' . strtotime($tweet['created_at']));
                    $extras = array();
                    $quoted = !empty($tweet['quoted_status']) ? ($tweet['quoted_status']) : NULL;
                    if ($quoted) {
                        $extras = array(
                            'quotedStatus' => $quoted,
                            'quotedUser' => $quoted['user']['name'],
                            'quotedScreenName' => $quoted['user']['screen_name'],
                            'quotedMessage' => $this->formattedTweet($quoted['text']),
                            'quottedDate' => '@' . strtotime($quoted['created_at']),
                        );
                    }
                    $extras['realName'] = $tweet['user']['name'];
                    $extras['favCount'] = $tweet['favorite_count'];
                    $extras['retweetCount'] = $tweet['retweet_count'];
                    $extras['retweetedStatusClass'] = !empty($tweet['retweeted_status'])?'retweeted':'';
                    $renderable = [
                        '#theme' => 'apirenderer-post',
                        '#blocktype' => $type,
                        '#icon' => $icon,
                        '#name' => $name,
                        '#content' => $message,
                        '#url' => $url,
                        '#date' => $date,
                        '#extras' => $extras
                    ];
                    $content .= drupal_render($renderable);
                    if ($num == $config['apirenderer_twitter_block_num_to_show']) {
                        break;
                    }
                }
                $return = [
                    '#theme' => 'apirenderer-base-block',
                    '#blocktype' => 'twitter',
                    '#content' => $content,
                    '#name' => \Drupal::config('apirenderer.settings')->get('apirenderer_twitter_user_timeline'),
                    '#url' => "https://twitter.com/" . $data[0]['user']['screen_name']
                ];
            }
            else {
                $return = array('#markup' => $data[0]['code'] . ": " . $data[0]['message']);
            }
        }
        else {
            $return .= array('#markup' => 'Twitter data missing!');
        }
        return $return;
    }
    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $max_items = \Drupal::config('apirenderer.settings')->get('apirenderer_twitter_count');
        $config = $this->getConfiguration();
        //Add a select box of numbers from 1 to $max_items
        $form['apirenderer_twitter_block_num'] = array(
            '#blocktype' => 'select',
            '#title' => t('Tweets To Show'),
            '#default_value' => isset($config['apirenderer_twitter_block_num_to_show']) ? $config['apirenderer_twitter_block_num_to_show'] : 1,
            '#options' => array_combine(range(1, $max_items), range(1, $max_items)),
        );
        //The block should always pull the latest data from the database, so no cache.
        return $form;
    }
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['apirenderer_twitter_block_num_to_show'] = $form_state->getValue('apirenderer_twitter_block_num');
    }
    /**
     * FORMATTED TWEET FUNCTION
     *
     * Formats the tweet.
     *
     * Always returns text.
     */
    public function formattedTweet($text) {
        $text = preg_replace("/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/", "<a target=\"_blank\" href=\"$1\">$1</a>", $text);
        $text = preg_replace("/@([\p{L}\p{N}_]{1,15})/u", '<a class="tweet-action" href="https://twitter.com/$1">@$1</a>', $text);
        $text = preg_replace("/#([\p{L}]+[\p{N}]*)/u", '<a class="tweet-action" href="https://twitter.com/search?q=%23$1">#$1</a>',$text);
        return $text;
    }
}