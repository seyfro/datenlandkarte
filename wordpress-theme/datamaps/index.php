<?php get_header(); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
        <div class="art-layout-cell art-content">
			<?php 
			  get_sidebar('top'); 
			  
			  global $post;
			  if (have_posts()){
			  	
				if (art_get_option('art_' . (art_is_home() ? 'home_' : '') . 'top_posts_navigation')) {
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