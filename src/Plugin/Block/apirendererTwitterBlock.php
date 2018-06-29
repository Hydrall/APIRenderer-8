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
        $html = 'test';
        $tweetlist = '';
        $data = \Drupal::state()->get('apirenderer.twitterData') ?: FALSE;
        if ($data) {
            foreach ($data as $tweet) {
                $type = 'twitter';
                $icon = $tweet['user']['profile_image_url_https'];
                $name = $tweet['user']['screen_name'];
                $id = $tweet['id_str'];
                $content = $this->formattedTweet($tweet['text']);
                $url = "https://twitter.com/statuses/$id";
                $date = time_elapsed_string('@'. strtotime($tweet['created_at']));
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
                print_r($extras);
            }
        }
        else {
            $html .= 'oh noooo';
        }
        return array('#markup' => $html);
    }
    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $max_items = \Drupal::config('apirenderer.settings')->get('apirenderer_twitter_count');
        $config = $this->getConfiguration();
        //Add a select box of numbers from 1 to $max_items
        $form['apirenderer_twitter_block_num'] = array(
            '#type' => 'select',
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
     * APIRENDERER TWITTER CONTENT
     * 
     * Generates block contents for the Twitter block.
     * 
     * Returns the formatted HTML.
     */
    function apirenderer_twitter_content() {
        $html = '';
        $tweetlist = '';
        $data = \Drupal::state()->get('apirenderer.twitterData');
        if ($data) {
            foreach ($data as $tweets) {
                $date = '@'. strtotime($tweets['created_at']);
                $message = formattedTweet($tweets['text']);
                $quoted = !empty($tweets['quoted_status']) ? ($tweets['quoted_status']) : NULL;
                $quoteduser = $quoted['user']['name'];
                $quotedscreen_name = $quoted['user']['screen_name'];
                $quotedmessage = formattedTweet($quoted['text']);
                $quoteddate = '';
                if ($quoted) {
                    $quoteddate = '@' . strtotime($quoted['created_at']);
                }
                // @FIXME
    // theme() has been renamed to _theme() and should NEVER be called directly.
    // Calling _theme() directly can alter the expected output and potentially
    // introduce security issues (see https://www.drupal.org/node/2195739). You
    // should use renderable arrays instead.
    // 
    // 
    // @see https://www.drupal.org/node/2195739
    // $tweetlist .= theme(
    // 				'apirenderer_twitter_single',
    // 				array(
    // 					'tweet_id' => $tweets['id_str'],
    // 					'avatar' => $tweets['user']['profile_image_url_https'],
    // 					'name' => $tweets['user']['name'],
    // 					'screen_name' => $tweets['user']['screen_name'],
    // 					'message' => $message,
    // 					'date' => time_elapsed_string($date),
    // 					'fav_count' => $tweets['favorite_count'],
    // 					//retweet variables //
    // 					'retweet_count'=>$tweets['retweet_count'],
    // 					'retweeted_status_class' => !empty($tweets['retweeted_status'])?'retweeted':'',
    // 					'quotedstatus' => $quoted,
    // 					'quoteduser' => $quoteduser,
    // 					'quotedmessage' => $quotedmessage,
    // 					'quotedscreen_name' => $quotedscreen_name,
    // 					'quoteddate' => time_elapsed_string($quoteddate),
    // 				)
    // 			);

            };
            // @FIXME
    // theme() has been renamed to _theme() and should NEVER be called directly.
    // Calling _theme() directly can alter the expected output and potentially
    // introduce security issues (see https://www.drupal.org/node/2195739). You
    // should use renderable arrays instead.
    // 
    // 
    // @see https://www.drupal.org/node/2195739
    // $html = theme(
    // 			'apirenderer_twitter_feed',
    // 			array(
    // 				'avatar' => $data[0]['user']['profile_image_url_https'],
    // 				'name' => $data[0]['user']['name'],
    // 				'screen_name' => $data[0]['user']['screen_name'],
    // 				'content' => $tweetlist,
    // 			)
    // 		);

        }
        else {
            // @FIXME
    // theme() has been renamed to _theme() and should NEVER be called directly.
    // Calling _theme() directly can alter the expected output and potentially
    // introduce security issues (see https://www.drupal.org/node/2195739). You
    // should use renderable arrays instead.
    // 
    // 
    // @see https://www.drupal.org/node/2195739
    // $html = theme(
    // 			'apirenderer_error',
    // 			array(
    // 				'message' => 'No Twitter data was found! Please check your twitter app settings under the Api Renderer config screen.'
    // 			)
    // 		);

        }
        return $html;
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