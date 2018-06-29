<?php 
/**
 * @file
 * Default theme implementation to format individual events for the eventbrite block.
 *
 * Available variables: 
 * - $contentError: error messages, if any
 * - $contentEvents: List of events.
 * 
 */
?>

<div class="container event_box">
	<h2 style="margin-top: 0;">Events</h2>
	<?php print $contentEvents ?>
</div>