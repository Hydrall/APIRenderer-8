<?php 

/**
 * @file
 * Default theme implementation to format photo-gallery item
 *
 * Available variables: 
 * - $title, $albumid, $cover, $count, $link, $colorbox, $target, $flickrembed
 * 
 */
 ?>
    <div class="feed-item col-xs-4 <?php print $type ?>" id="gallery-<?php print $albumid ?>">
      <div class="feed-item-thumbnail">
        <a href="<?php print $link ?>" class="<?php print $colorbox ?>" target="_blank"><img src="<?php print $cover ?>" alt="Photo Gallery Thumbnail" /></a>
      </div>
      <div class="feed-item-description">
        <h3 class="feed-item-title"><a href="<?php print $link ?>" class="<?php print $colorbox ?>" target="<?php print $target ?>"><?php print $title ?></a></h3>
        <div class="feed-item-summary"><?php print $summary ?></div>
      </div>
      <?php print $flickrembed ?>
    </div>