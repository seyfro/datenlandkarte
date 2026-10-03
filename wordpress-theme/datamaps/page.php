<?php get_header(); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
        <div class="art-layout-cell art-content">
			<?php 
			get_sidebar('top'); 
			
			global $post;
			if (have_posts()){
			
				while (have_posts())  
				{
					the_post();
					art_post_wrapper(
						array(
								'id' => art_get_post_id(), 
								'class' => art_get_post_class(),
								//'thumbnail' => art_get_post_thumbnail(),
								'title' => art_get_meta_option($post->ID, 'art_show_page_title') ? get_the_title() : '', 
								'before' => art_get_metadata_icons('edit', 'header'),
								'content' => art_get_content(), // 'content' => 'My post content',
								)
							);
					comments_template();
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