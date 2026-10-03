<?php

function art_print_options() {
	global $art_options;
?>
<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2><?php _e('Theme Options'); ?></h2>
<?php 
	if ( isset($_REQUEST['Submit']) )	{ 
		foreach ($art_options as $value) {
			$id = art_get_array_value($value, 'id');
			$val = stripslashes(art_get_array_value($_REQUEST, $id));
			$type = art_get_array_value($value, 'type');
			switch($type){
				case 'checkbox':
					$val = ($val  ? 1 : 0);
				break;
				case 'numeric':
					$val = (int) $val;
				break;
			}
			update_option( $id, $val); 
		}
		echo '<div id="message" class="updated fade"><p><strong>'. __('Settings saved.') .'</strong></p></div>'.BR; 
	} 
	if ( isset($_REQUEST['Reset']) )	{ 
	foreach ($art_options as $value) {
		delete_option(art_get_array_value($value, 'id')); 
	}
	echo '<div id="message" class="updated fade"><p><strong>'. __('Settings restored.') . '</strong></p></div>'.BR;
	} 
	echo '<form method="post">'.BR;
	$in_form_table = false;
	foreach ($art_options as $op) {
		$type = art_get_array_value($op, 'type');
		$name = art_get_array_value($op, 'name');
		$desc = art_get_array_value($op, 'desc');
		if ($type == 'heading'){
			if ($in_form_table) {
				echo '</table>'.BR;
				$in_form_table = false;
			}
			echo '<h3>'.$name.'</h3>'.BR;
			if ($desc) {
				echo BR.'<p class="description">'.$desc.'</p>'.BR;
			}
		} else {
			if (!$in_form_table) {
				echo '<table class="form-table">'.BR;
				$in_form_table = true;
			}
			echo '<tr valign="top">'.BR;
			echo '<th scope="row">'.$name.'</th>'.BR;
			echo '<td>'.BR;
			$id = art_get_array_value($op, 'id');
			$val = art_get_option($id);
			art_print_option_control($op, $val);
			if ($desc) {
			echo '<span class="description">'.$desc.'</span>'.BR;
			}
			echo '</td>'.BR;
			echo '</tr>'.BR;
		}
	}
	if ($in_form_table) {
	echo '</table>'.BR;
	}
?>
	<p class="submit">
		<input name="Submit" type="submit" class="button-primary" value="<?php echo esc_attr(__('Save Changes')) ?>" />
		<input name="Reset" type="submit" class="button-secondary" value="<?php echo esc_attr(__('Reset to Default')) ?>" />
	</p>
	</form>
	</div>
<?php
}


function art_print_option_control($op, $val){
	$id = art_get_array_value($op, 'id');
	$type = art_get_array_value($op, 'type');
	$options = art_get_array_value($op, 'options');
	switch ( $type) {
		case 'numeric':
		echo '<input	name="'.$id.'" id="'.$id.'" type="text" value="'.absint($val).'" class="small-text" />'.BR;
		break;
		case 'select':
		echo '<select name="'.$id.'" id="'.$id.'">'.BR;
			foreach ($op['options'] as $key	=>	$option) { 
				$selected = ($val == $key ? ' selected="selected"' : '');
				echo '<option'.$selected.' value="'.$key.'">'.esc_html(__($option)).'</option>'.BR; 
			}
		echo '</select>'.BR;
		break;
		case 'textarea':
		echo '<textarea name="'.$id.'" id="'.$id.'" rows="10" cols="50" class="large-text code">'.esc_html($val).'</textarea><br />'.BR;
		break;
		case "radio":
			foreach ($op['options'] as $key=>$option) {
				$checked = ( $key == $val ? 'checked="checked"' : '');
				echo '<input type="radio" name="'.$id.'" id="'.$id.'" value="'.esc_attr($key).'" '.$checked.'/>'.esc_html($option).'<br />'.BR;
			}
		break;
		case "checkbox":
			$checked =	($val ? 'checked="checked" ' : ''); 
			echo '<input type="checkbox" name="'.$id.'" id="'.$id.'" value="1" '.$checked.'/>'.BR;
		break;
		default:
		$class = 'regular-text';
		if ($type == 'numeric'){
			$type = 'text';
			$class = 'small-text';
			$val = absint($val);
		}
		if ($type == 'widetext') {
			$class = 'large-text';
		}
		echo '<input	name="'.$id.'" id="'.$id.'" type="'.$type.'" value="'.esc_attr($val).'" class="'.$class.'" />'.BR;
		break;
	}
}

// Not support old wp version
if (WP_VERSION < 3.0) return;
 


function art_add_meta_boxes() {
    add_meta_box( 'art_meta_box',
                  __('Theme Options', THEME_NS),
                  'art_print_page_meta_box',
                  'page',
                  'side',
                  'low'
                 );
    add_meta_box( 'art_meta_box',
                  __('Theme Options', THEME_NS),
                  'art_print_post_meta_box',
                  'post',
                  'side',
                  'low'
                 );
}

/* Prints meta box content */
function art_print_page_meta_box($post) {
	global $art_page_meta_options;
	art_print_meta_box($post, $art_page_meta_options);
}

function art_print_post_meta_box($post) {
	global $art_post_meta_options;
	art_print_meta_box($post, $art_post_meta_options);
}

function art_print_meta_box($post, $meta_options) {
    // Use nonce for verification
    wp_nonce_field('art_meta_options', 'art_meta_noncename');
	if (!isset($post)) return;
	foreach ($meta_options as $option) {
		$id = art_get_array_value($option, 'id');
		$name = art_get_array_value($option, 'name');
		$desc = art_get_array_value($option, 'desc');
		$value = art_get_meta_option($post->ID, $id);
		$necessary = art_get_array_value($option, 'necessary');
		if ($necessary && !current_user_can($necessary)) continue;
        echo '<p class="meta-options"><label class="selectit" for="'.$id.'"><strong>'.$name .'</strong></label><br />';
		art_print_option_control($option, $value);
		if ($desc) {
			echo '<em>'.$desc.'</em>';
		}
		echo'</p>';
    }
}



// post metadata
/* When the post is saved, saves our data */
function art_save_post($post_id) {
	global $art_post_meta_options, $art_page_meta_options;
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if (!isset($_POST['art_meta_noncename']) || !wp_verify_nonce($_POST['art_meta_noncename'], 'art_meta_options' )) {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
    // to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
	
	$meta_options = null;//posts
	if ( 'page' == $_POST['post_type']) {
		// Check permissions
		if (!current_user_can( 'edit_page', $post_id ) ){
			return $post_id;
		}
		$meta_options = $art_page_meta_options;
	}
	
	if ( 'post' == $_POST['post_type']) {
		$meta_options = $art_post_meta_options;
	}
	
	if (!$meta_options) return $post_id;
	// OK, we're authenticated: we need to find and save the data
	foreach ($meta_options as $value) {
		$id = art_get_array_value($value, 'id');
		$val = stripslashes(art_get_array_value($_REQUEST, $id));
		$type = art_get_array_value($value, 'type');
		$necessary = art_get_array_value($value, 'necessary');
		if ($necessary && !current_user_can($necessary)) continue;
		switch($type){
			case 'checkbox':
				$val = ($val  ? 1 : 0);
			break;
			case 'numeric':
				$val = (int) $val;
			break;
		}
		art_set_meta_option($post_id, $id, $val); 
	}
	return $post_id;
}