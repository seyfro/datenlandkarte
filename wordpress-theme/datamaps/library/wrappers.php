<?php
// $style = 'post' or 'block' or 'vmenu' or 'simple'
function art_wrapper($style, $args){
	$func_name = "art_{$style}_wrapper";
	if (function_exists($func_name)) {
		call_user_func($func_name, $args);
	} else {
		art_block_wrapper($args);
	}
}

function art_post_wrapper($args = '') {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'thumbnail' => '',
			'before' => '',
			'content' => '',
			'after' => ''
		)
	);
	extract($args);
	if (art_is_empty_html($title) && art_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}
	?>
<div class="art-post<?php echo $class; ?>"<?php echo $id; ?>>
	    <div class="art-post-body">
	            <div class="art-post-inner art-article">
	            <?php
	                echo $thumbnail;
	                if (!art_is_empty_html($title)){
	                    echo '<h2 class="art-postheader">'.$title.'</h2>';
	                }
	                 echo $before;?>
	                <div class="art-postcontent">
	                    <!-- article-content -->
	                    <?php echo $content; ?>
	                    <!-- /article-content -->
	                </div>
	                <div class="cleared"></div>
	                <?php
	                ob_start();
	                    echo $after;
	                $meta = ob_get_clean();    
	                if (strlen($meta) > 0) {
	                    echo '<div class="art-postmetadatafooter">'.$meta.'</div>';
	                }
	                
	            ?>
	            </div>
			<div class="cleared"></div>
	    </div>
	</div>
	
	<?php
}

function art_simple_wrapper($args = '') {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'content' => '',
		)
	);
	extract($args);
	if (art_is_empty_html($title) && art_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}
	echo "<div class=\"art-widget{$class}\"{$id}>";
	if ( !art_is_empty_html($title)) echo '<h5  class="art-widget-title">' . $title . '</h5>';
	echo '<div class="art-widget-content">' . $content . '</div>';
	echo '</div>';
}

function art_block_wrapper($args) {
	$args = wp_parse_args($args, 
		array(
			'id' => '',
			'class' => '',
			'title' => '',
			'content' => '',
		)
	);
	extract($args);
	if (art_is_empty_html($title) && art_is_empty_html($content)) return;
	if ($id) {
		$id = ' id="' . $id . '"';
	}
	if ($class) {
		$class = ' ' . $class; 
	}

	$begin = <<<EOL
<div class="art-block{$class}"{$id}>
    <div class="art-block-tl"></div>
    <div class="art-block-tr"></div>
    <div class="art-block-bl"></div>
    <div class="art-block-br"></div>
    <div class="art-block-tc"></div>
    <div class="art-block-bc"></div>
    <div class="art-block-cl"></div>
    <div class="art-block-cr"></div>
    <div class="art-block-cc"></div>
    <div class="art-block-body">
EOL;
	$begin_title  = <<<EOL
<div class="art-blockheader">
    <div class="l"></div>
    <div class="r"></div>
    <h3 class="t">
EOL;
	$end_title = <<<EOL
</h3>
</div>
EOL;
	$begin_content = <<<EOL
<div class="art-blockcontent">
    <div class="art-blockcontent-body">
EOL;
	$end_content = <<<EOL
		<div class="cleared"></div>
    </div>
</div>
EOL;
	$end = <<<EOL
		<div class="cleared"></div>
    </div>
</div>
EOL;
	echo $begin;
	if ($begin_title && $end_title && !art_is_empty_html($title)) {
		echo $begin_title . $title . $end_title;
	}
	echo $begin_content;
	echo $content;
	echo $end_content;
	echo $end;	
}
