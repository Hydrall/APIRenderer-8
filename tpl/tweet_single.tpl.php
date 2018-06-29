<?php
/**
 * @file
 * Theme implementation for Twitter tweets.
 *
 * Available variables:
 * - $retweeted_status_class
 * - $retweet_count
 * - $screen_name
 * - $avatar
 * - $name
 * - $quotedstatus, $quoteddate, $quotedmessage, $quotedscreen_name, $quoteduser
 * - $message
 * - $tweet_id
 * - $fav_count
 *
 */
?>
<div class="row tweet-item <?php print $retweeted_status_class ?>">
	<div class="col-md-12">
		<?php if(!empty($retweeted_status_class)): ?>
			<p class="retweet_status"><span class="fa fa-retweet"></span> <a href="https://twitter.com/<?php print $screen_name ?>">@<?php print $screen_name ?></a> Retweeted </p>
		<?php endif ?>
    	<div class="col-xs-2 avatar">
      		<img src="<?php print $avatar ?>" alt="" />
    	</div>
   		<div class="col-xs-10 user-info">
      		<strong><?php print $name ?></strong><br />
			<a href="https://twitter.com/statuses/<?php print $tweet_id ?>" target="_blank">@<?php print $screen_name ?></a><span class="date"> <?php print $date ?></span><br /><br />
			<div class="<?php print $retweeted_status_class ?>">
			<?php if(!empty($quotedstatus)): ?>
				<p class="twitter-message"><?php print $message ?></p>
				<div class="quoted">
					<strong><?php print $quoteduser ?> </strong><a href="https://twitter.com/<?php print $quotedscreen_name?>">@<?php print $quotedscreen_name ?></a><span class="date"> <?php print $quoteddate ?></span><br />
					<p><?php print $quotedmessage ?></p>
				</div>
			<?php else : ?>
				<p class="twitter-message"><?php print $message ?></p>
			<?php endif ?>
			</div>
			<div class="utilbar row col-md-6 col-sm-12">
				<span class="respond"><a href="https://twitter.com/statuses/<?php print $tweet_id ?>" target="_blank"><span class="fa fa-reply"></span></a></span>
				<span class="retweets"><a href="https://twitter.com/statuses/<?php print $tweet_id ?>" target="_blank"><span class="fa fa-retweet"></span> <?php print $retweet_count ?></a></span>
				<span class="favs"><span class="fa fa-heart"></span> <?php print $fav_count ?></span>
			</div>
		</div>
	</div>
</div>
