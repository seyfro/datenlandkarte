<?php get_header(); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
        <div class="art-layout-cell art-content">
			<?php 
			  get_sidebar('top'); 
			  
			  global $post;
			  if (have_posts()){
				
				$post = $posts[0];
				ob_start();
				if (is_category()){
				
					echo '<h4>'. single_cat_title( '', false ) . '</h4>';
					echo category_description();
					
				} elseif( is_tag() ) {
				
					echo '<h4>'. single_tag_title('', false) . '</h4>';
					
				} elseif( is_day() ) {
				
					echo '<h4>'. sprintf(__('Daily Archives: <span>%s</span>', THEME_NS), get_the_date()) . '</h4>';
					
				} elseif( is_month() ) {
				
					echo '<h4>'. sprintf(__('Monthly Archives: <span>%s</span>', THEME_NS), get_the_date('F Y')) . '</h4>';
					
				} elseif( is_year() ) {
				
					echo '<h4>'. sprintf(__('Yearly Archives: <span>%s</span>', THEME_NS), get_the_date('Y')) . '</h4>';
					
				} elseif( is_author() ) {
				
					the_post();
					echo '<div class="avatar">'.get_avatar(get_the_author_meta('user_email')) . '</div>';
					echo '<h4>'. get_the_author() . '</h4>';
					$desc = get_the_author_meta('description');
					if ($desc) echo '<div>' . $desc . '</div>';
					rewind_posts();
					
				} elseif( isset($_GET['paged']) && !empty($_GET['paged']) ) {
				
					 echo '<h4>'. __('Blog Archives', THEME_NS) . '</h4>';
					 
				}
				art_post_wrapper(array('content' => ob_get_clean(), 'class' => 'breadcrumbs'));
				
				if (art_get_option('art_top_posts_navigation')) {
					art_page_navigation();// previous_posts_link | next_posts_link
				}
				
				while (have_posts())  
				{
					the_post();
					art_post_wrapper(
						array(
								'id' => art_get_post_id(), 
								'class' => art_get_post_class(),
								'thumbnail' => art_get_post_thumbnail(),
								'title' => '<a href="'.get_permalink($post->ID).'" rel="bookmark" title="'.get_the_title().'">'.get_the_title().'</a>', 
								'before' => art_get_metadata_icons('date,author,edit', 'header'),
								'content' => art_get_excerpt(), // 'content' => 'My post content',
								'after' => art_get_metadata_icons('category,tag,comments', 'footer')
						)
					);
				}
				
				if (art_get_option('art_bottom_posts_navigation')) {
					art_page_navigation();// previous_posts_link | next_posts_link
				}
				
			  } else {  
			  
				art_404_content();
				
			  } 
			  
			  get_sidebar('bottom'); 
			?>
          <div class="cleared"></div>
        </div>
        <div class="art-layout-cell art-sidebar1">
          <?php get_sidebar('default'); ?>
          <div class="cleared"></div>
        </div>
    </div>
</div>
<div class="cleared"></div>
<?php get_footer();
