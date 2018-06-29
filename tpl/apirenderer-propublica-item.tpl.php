<?php 
/**
 * @file
 * Default theme implementation to format individual bills in the list.
 *
 * Available variables: 
 * - $url: congress.gov url
 * - $number: bill number
 * - $title: bill title
 * - $date: bill date
 * - $this: which table it is
 * - $congress: which congress it is from
 * 
 */
?>
 <tr class="result page<?php print $this ?> congress<?php print $congress ?><?php print $this ?> congress<?php print $congress ?>">
	<td>
		<a href="<?php print $url ?>"><?php print $number ?></a>
	</td>
	<td>
		<?php print $title ?>
	</td>
	<td>
		<?php print $date ?>
	</td>
</tr>

 