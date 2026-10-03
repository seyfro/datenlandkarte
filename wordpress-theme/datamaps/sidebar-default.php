<?php
if ( !art_dynamic_sidebar( 'default' ) ) : ?>
<?php $style = art_get_option('art_sidebars_style_default'); ?>

<?php ob_start();?>
      <?php get_search_form(); ?> 
<?php art_wrapper($style, array('title' => __('Search'), 'content' => ob_get_clean())); ?>

<?php ob_start();?>
      <ul>
        <?php wp_list_categories('show_count=1&title_li='); ?>
      </ul>
<?php art_wrapper($style, array('title' => __('Categories'), 'content' => ob_get_clean())); ?>

<?php ob_start();?>
      <ul>
        <?php wp_get_archives('type=monthly&title_li='); ?>
      </ul>
<?php art_wrapper($style, array('title' => __('Archives'), 'content' => ob_get_clean())); ?>

<?php ob_start();?>
      <ul>
        <?php wp_list_bookmarks('orderby=rating&title_li=&categorize=0'); ?>
      </ul>
<?php art_wrapper($style, array('title' => __('Bookmarks'), 'content' => ob_get_clean())); ?>

<?php endif; ?>