<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

$title_tag = 'h1';

?>
<article class="node-<?php print $node->nid; ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
    <header>
      <?php print render($title_prefix); ?>
      <?php if (!$page && $title): ?>
        <<?php print $title_tag; ?><?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></<?php print $title_tag; ?>>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($display_submitted): ?>
        <p class="submitted">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </p>
      <?php endif; ?>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <?php
  // We hide the comments and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);

  // print render($content);
  print render($content['field_latest_news_image']);
  if ( ($title_prefix || $title_suffix || $display_submitted || $unpublished || $title ) && node_is_page( $node ) ): ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <<?php print $title_tag; ?><?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></<?php print $title_tag; ?>>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
  <?php endif; 
  print render($content['body']);
  ?>
  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</article>
