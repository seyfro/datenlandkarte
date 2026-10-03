<?php get_header(); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
        <div class="art-layout-cell art-content">
			<?php 
			  get_sidebar('top'); 
			  global $post;
			  if (have_posts()){
			  	
			  	if (art_get_option('art_top_single_navigation')) {
			  		// previous_post_link | next_post_link
					art_page_navigation(
						array(
							'next_link' => art_get_previous_post_link('&laquo; %link'),
							'prev_link' => art_get_next_post_link('%link &raquo;')
						)
					);
				}
				
				while (have_posts())  
				{
					the_post();
					art_post_wrapper(
						array(
								'id' => art_get_post_id(), 
								'class' => art_get_post_class(),
								//'thumbnail' => art_get_post_thumbnail(),
								'title' => art_get_meta_option($post->ID, 'art_show_post_title') ? get_the_title() : '',  
								'before' => art_get_metadata_icons('date,author,edit', 'header'),
								'content' => art_get_content(), // 'content' => 'My post content',
								'after' => art_get_metadata_icons('category,tag', 'footer')
						)
					);
					comments_template();
				}
				
				
				if (art_get_option('art_bottom_single_navigation')) {
			  		// previous_post_link | next_post_link
					art_page_navigation(
						array(
							'next_link' => art_get_previous_post_link('&laquo; %link'),
							'prev_link' => art_get_next_post_link('%link &raquo;')
						)
					);
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