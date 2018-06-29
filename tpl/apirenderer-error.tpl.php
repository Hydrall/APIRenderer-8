<?php 
/**
 * @file
 * Theme implementation for error messages.
 *
 * Available variables: 
 * - $message: the error message.
 *
 */
?>
<div class="row" id="errorRow">
	<div class="alert alert-block alert-danger messages error">
		<?php print $message ?>
	</div>
</div>