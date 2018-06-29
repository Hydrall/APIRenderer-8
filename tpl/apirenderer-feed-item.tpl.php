<?php
/**
 * @file
 * Default theme implementation to format photo-gallery item
 *
 * Available variables:
 * - $id, $name, $permalink, $message, $link, $picture, $icon
 *
 */
?>
<div class="feed-item facebookitem clearfix" id="feed-<?php print $id ?>">
	<div class="facebook-icon-box col-md-2">
		<a href="<?php print $permalink ?>">
				<img src="<?php print $icon ?>" alt="Profile Picture" class="facebook-icon" />
		</a>
	</div>
	<div class="facebook-message-box col-md-10">
		<div class="facebook-identity-box">
			<div class="facebook-name">
				<a href="<?php print $permalink ?>" class="facebook-name-link">
					<?php print $name ?>
				</a>
			</div>
			<a href="<?php print $permalink ?>" class="facebook-time-link">
				<?php print $time ?>
			</a>
		</div>
		<div class="facebook-message">
			<p class="facebook-story"><?php print $story ?></p>
			<p><?php print $message ?><?php if ($readMore == true): ?>...<?php endif; ?></p>
			<?php if ($readMore == true): ?>
				<p><a class="readmore" href="<?php print $permalink ?>">Read More</a></p>
			<?php endif; ?>
		</div>
		<?php if ($extras == true): ?>
			<div class="facebook-extras-box">
				<?php if ($link != ''): ?>
					<a href="<?php print $link ?>" class="facebook-extras-link">
				<?php endif; ?>
					<?php if ($picture != ''): ?>
						<img src="<?php print $picture ?>" class="facebook-extras-picture" />
					<?php endif; ?>
					<?php if ($caption != ''): ?>
						<div class="facebook-caption"><?php print $caption ?></div>
					<?php endif; ?>
				<?php if ($link != ''): ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

</div>
