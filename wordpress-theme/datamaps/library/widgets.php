<?php
// widget extra options
global $art_widgets_style;
$art_widgets_style = array('default' => 'sidebar default','block' => 'block', 'post' => 'post', 'simple' => 'simple text');

function art_get_widget_style($id, $style = null)
{
	$result = art_get_meta_option($id, 'art_widget_styles');
	global $art_widgets_style;
	if (!in_array($result, array_keys($art_widgets_style)))  
	{
		$result = 'default'; 
	}
	if ($style != null) {
		if (!in_array($style,array('block', 'post', 'simple'))) {
			$style = 'block';		
		}
		if($result == 'default') { 
			$result = $style;
		}
	}
	return $result;
}

function art_set_widget_style($id, $style)
{
	global $art_widgets_style;
	if (!in_array($style, array_keys($art_widgets_style)))  
	{
		$style = 'default'; 
	}
	art_set_meta_option($id, 'art_widget_styles', $style);
}

function art_widget_expand_control($id)
{
  global $wp_registered_widget_controls;
  $controls = &$wp_registered_widget_controls[$id];
  $controls['params'][] = $id;
  if (isset($controls['callback'])){
	$controls['callback_redirect']=$controls['callback'];
  }
  $controls['callback']='art_widget_extra_control';
}

function art_widget_process_control()
{
  global $wp_registered_widget_controls;
  if ('post' == strtolower($_SERVER['REQUEST_METHOD']) && isset($_POST['widget-id']) )
  {
	$id = $_POST['widget-id'];
	$id_disp = 'widget-style';
	if (isset($_POST[$id_disp])){
	  art_set_widget_style($id, $_POST[$id_disp]);
	}
	art_widget_expand_control($id);
	return;
  } 
  foreach ( $wp_registered_widget_controls as $id => $widget )
  {
	art_widget_expand_control($id);
  }
}

function art_widget_extra_control()
{
  global $wp_registered_widget_controls, $art_widgets_style;
  $params = func_get_args();
  $id = $params[count($params)-1];
  $id_disp = 'widget-style';
  $val = art_get_widget_style($id);
  $widget_controls = art_get_array_value($wp_registered_widget_controls, $id, array());
  if (isset($widget_controls['callback_redirect'])){
	  $callback = $widget_controls['callback_redirect'];
	  if (is_callable($callback))
	  {
		call_user_func_array($callback, $params);
	  }
	}
?>	
<h3 style="margin-bottom:3px;"><?php _e('Theme Options'); ?></h3>
<p>
  <label for="<?php echo $id_disp; ?>"><?php echo __('Appearance') . ':'; ?></label><br />
  <select class="widefat" id="<?php echo $id_disp; ?>" name="<?php echo $id_disp; ?>">
<?php
  foreach ( $art_widgets_style as $key => $option ) {
	$selected = ($val == $key ? ' selected="selected"' : '');
	echo '<option'. $selected .' value="'. $key .'">'. __($option) .'</option>';
  }
?>
  </select>
</p>
<?php
}

// widgets

class VMenuWidget extends WP_Widget {

	// PHP 4 style constructors are no longer called since PHP 8.0
	function __construct() {
		$widget_ops = array('classname' => 'vmenu', 'description' => __('Use this widget to add one of your custom menus as a widget.', THEME_NS) );
		parent::__construct( false , __('Vertical Menu'), $widget_ops );
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Navigation Menu' ) : $instance['title'], $instance, $this->id_base);
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo art_get_menu(array(
					'source' => $instance['source'],
					'depth' => art_get_option('art_vmenu_depth'),
					'menu' => wp_get_nav_menu_object($instance['nav_menu']),
					'class' => ''
				));
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['source'] = $new_instance['source'];
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'source' => 'Pages', 'nav_menu' => '') );
		$title = esc_attr( $instance['title'] );
		$source = $instance['source'];
		$nav_menu = $instance['nav_menu'];

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		$sources = array('Pages', 'Categories', 'Custom Menu');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('source'); ?>"><?php echo __('Source') . ':'; ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('source'); ?>" name="<?php echo $this->get_field_name('source'); ?>" onchange="var s = jQuery('.p-<?php echo $this->get_field_id('nav_menu');?>'); if (this.value == 'Custom Menu') s.show(); else s.hide();">
		<?php
			
			foreach ( $sources as $s ) {
				$selected = ($source == $s ? ' selected="selected"' : '');
				echo '<option'. $selected .' value="'. $s .'">'. __($s) .'</option>';
			}
		?>
			</select>
		</p>
		<p class="p-<?php echo $this->get_field_id('nav_menu'); ?>" <?php if ($source !== 'Custom Menu') echo ' style="display:none"'?>>
		
		<?php // If no menus exists, direct the user to go and create some.
			if ( !$menus ) {
				?>
				<p class="p-<?php echo $this->get_field_id('nav_menu'); ?>" <?php if ($source !== 'Custom Menu') echo ' style="display:none"'?>>
				<?php
				printf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') );
				?>
				</p>
				<?php
			} else { ?>
		
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label><br />
			<select class="widefat" id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
			
		<?php 
			}
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}

class LoginWidget extends WP_Widget{

	function __construct(){
	  $widget_ops = array('classname' => 'login', 'description' => __( 'Login form') );
	  parent::__construct(false, __('Login'), $widget_ops);
	}

	function widget($args, $instance){

		global $user_ID, $user_identity, $user_level, $user_email, $user_login;
		extract($args);
		echo $before_widget;
		echo $before_title;
		if ($user_ID):
			echo $user_identity;
			echo $after_title; ?>

			<div class="avatar">
				<a href="<?php bloginfo('wpurl') ?>/wp-admin/profile.php"><?php echo get_avatar($user_email, 64); ?></a>
			</div>

			<ul class="alignleft">
				<li><a href="<?php bloginfo('wpurl') ?>/wp-admin/"><?php _e('Dashboard'); ?></a></li>
				<?php if ($user_level >= 1): ?>
				<li><a href="<?php bloginfo('wpurl') ?>/wp-admin/post-new.php"><?php _e('Publish'); ?></a></li>
				<li><a href="<?php bloginfo('wpurl') ?>/wp-admin/edit-comments.php"><?php _e('Comments'); ?></a></li>
				<?php endif; ?>
				<li><a href="<?php echo wp_logout_url() ?>&amp;redirect_to=<?php echo urlencode(art_get_current_url()); ?>"><?php _e("Log out"); ?></a></li>
			</ul>

	  	<?php else:
			_e('Log In');
			echo $after_title; ?>

			<form action="<?php bloginfo('wpurl') ?>/wp-login.php" method="post">
				<label for="log"><?php _e('Username') ?></label><br /><input type="text" name="log" id="log" value="<?php echo esc_attr(stripslashes((string)$user_login)) ?>" size="20" /><br />
				<label for="pwd"><?php _e("Password"); ?></label><br /><input type="password" name="pwd" id="pwd" size="20" /><br />
				<span class="art-button-wrapper">
					<span class="art-button-l"> </span>
					<span class="art-button-r"> </span>
					<input class="art-button" type="submit" name="submit" value="<?php echo esc_attr(__('Log In')); ?>" class="button" />
				</span>	
				<br />
				<label for="rememberme"><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /><?php _e('Remember Me'); ?></label><br />
				<input type="hidden" name="redirect_to" value="<?php echo art_get_current_url(); ?>"/>
			</form>
			<ul>
				<?php if (get_option('users_can_register')) { ?><li><a href="<?php bloginfo('wpurl') ?>/wp-register.php"><?php _e("Register"); ?></a></li><?php } ?>
				<li><a href="<?php bloginfo('wpurl') ?>/wp-login.php?action=lostpassword"><?php _e("Lost your password?"); ?></a></li>
			</ul>
		<?php endif; ?>

	  <?php
	  echo $after_widget;
	}
}

// init widgets
function artWidgetsInit(){
		register_widget('VMenuWidget');
		register_widget('LoginWidget');
}
add_action('widgets_init', 'artWidgetsInit');