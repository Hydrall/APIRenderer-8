<?php 
/**
 * @file
 * Default theme implementation to format individual events for the eventbrite block.
 *
 * Available variables: 
 * - $url, $img, $free, $date, $title, $location
 * 
 */
?>
<a href="<?php print $url ?>">
	<div class="event">
		<div class="col-md-4 leftColumn">
			<div class="row text-center">
				<img class="eventImg" src="<?php print $img ?>">
			</div>
			<div class="row text-center <?php print $free ?>">
				<?php print $free ?>
			</div>
		</div>
		<div class="col-md-6 rightColumn">
			<div class="row formattedDate">
				<?php print $date ?>
			</div>
			<div class="row titlehead">
				<?php print $title ?>
			</div>
			<div class="row location">
				<?php print $location ?>
			</div>
			<div class="row text-center">
				&nbsp;
			</div>
		</div>
	</div>
</a>