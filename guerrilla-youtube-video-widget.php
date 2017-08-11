<?php
/*
Plugin Name: Guerrilla's Youtube Video Widget
Plugin URI: http://madebyguerrilla.com
Description: This is a plugin that adds a widget you can use to display a responsive Youtube video in the sidebar of your WordPress powered website.
Version: 1.1
Author: Mike Smith
Author URI: http://www.madebyguerrilla.com
*/

/*  Copyright 2013-2016  Mike Smith (email : hi@madebyguerrilla.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class YoutubeVideoWidget extends WP_Widget
{
    function YoutubeVideoWidget(){
		$widget_ops = array('description' => 'Displays A Youtube Video');
		$control_ops = array('width' => 300, 'height' => 300);
		parent::WP_Widget(false,$name='Youtube Video Widget',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$YoutubeID = empty($instance['YoutubeID']) ? '' : $instance['YoutubeID'];
		$Width = empty($instance['Width']) ? '' : $instance['Width'];
		$Height = empty($instance['Height']) ? '' : $instance['Height'];
		$ShowSuggested = empty($instance['ShowSuggested']) ? '' : $instance['ShowSuggested'];
		$ShowControls = empty($instance['ShowControls']) ? '' : $instance['ShowControls'];
		$ShowInfo = empty($instance['ShowInfo']) ? '' : $instance['ShowInfo'];

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>
  
<div class="video-container">
	<iframe width="<?php echo($Width); ?>" height="<?php echo($Height); ?>" src="https://www.youtube.com/embed/<?php echo($YoutubeID); ?>?<?php if( $ShowSuggested == 'on') { echo'rel=0'; } else {}; ?><?php if( $ShowControls == 'on') { echo'&amp;controls=0'; } else {}; ?><?php if( $ShowInfo == 'on') { echo'&amp;showinfo=0'; } else {}; ?>" frameborder="0" allowfullscreen></iframe>

</div>

<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['YoutubeID'] = stripslashes($new_instance['YoutubeID']);
		$instance['Width'] = stripslashes($new_instance['Width']);
		$instance['Height'] = stripslashes($new_instance['Height']);
		$instance['ShowSuggested'] = stripslashes($new_instance['ShowSuggested']);
		$instance['ShowControls'] = stripslashes($new_instance['ShowControls']);
		$instance['ShowInfo'] = stripslashes($new_instance['ShowInfo']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array(
			'title'=>'',
			'YoutubeID'=>'',
			'Width'=>'480',
			'Height'=>'270',
			'ShowSuggested'=>'',
			'ShowControls'=>'',
			'ShowInfo'=>'',
		) );

		$title = htmlspecialchars($instance['title']);
		$YoutubeID = htmlspecialchars($instance['YoutubeID']);
		$Width = htmlspecialchars($instance['Width']);
		$Height = htmlspecialchars($instance['Height']);
		$ShowSuggested = htmlspecialchars($instance['ShowSuggested']);
		$ShowControls = htmlspecialchars($instance['ShowControls']);
		$ShowInfo = htmlspecialchars($instance['ShowInfo']);

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Youtube ID
		echo '<p><label for="' . $this->get_field_id('YoutubeID') . '">' . 'Youtube Video ID (ie: sdGX5t8TCWc):' . '</label><input class="widefat" id="' . $this->get_field_id('YoutubeID') . '" name="' . $this->get_field_name('YoutubeID') . '" type="text" value="' . $YoutubeID . '" /></p>';
		
	{ ?>

	    <p><input class="checkbox" type="checkbox" <?php checked($ShowSuggested, 'on'); ?> id="<?php echo $ShowSuggested; ?>" name="<?php echo $this->get_field_name('ShowSuggested'); ?>" /> <label for="<?php echo $ShowSuggested; ?>">Hide Suggested Videos?</label></p>

	    <p><input class="checkbox" type="checkbox" <?php checked($ShowControls, 'on'); ?> id="<?php echo $ShowControls; ?>" name="<?php echo $this->get_field_name('ShowControls'); ?>" /> <label for="<?php echo $ShowControls; ?>">Hide Video Controls?</label></p>

	    <p><input class="checkbox" type="checkbox" <?php checked($ShowInfo, 'on'); ?> id="<?php echo $ShowInfo; ?>" name="<?php echo $this->get_field_name('ShowInfo'); ?>" /> <label for="<?php echo $ShowInfo; ?>">Hide Video Info?</label></p>

	<?php }

		# Video Width
		echo '<p><label for="' . $this->get_field_id('Width') . '">' . 'Width (ie: 480):' . '</label><input class="widefat" id="' . $this->get_field_id('Width') . '" name="' . $this->get_field_name('Width') . '" type="text" value="' . $Width . '" /></p>';
		# Video Height
		echo '<p><label for="' . $this->get_field_id('Height') . '">' . 'Height (ie: 320):' . '</label><input class="widefat" id="' . $this->get_field_id('Height') . '" name="' . $this->get_field_name('Height') . '" type="text" value="' . $Height . '" /></p>';
	}

}// end YoutubeVideoWidget class

function YoutubeVideoWidgetInit() {
  register_widget('YoutubeVideoWidget');
}
add_action('widgets_init', 'YoutubeVideoWidgetInit');

/* This code adds the youtube video widget stylesheet to your website */
function guerrilla_youtube_video_style()
{
	// Register the style like this for a plugin:
	wp_register_style( 'guerrilla-youtube-video', plugins_url( '/style.css', __FILE__ ), array(), '20160203', 'all' );
	// For either a plugin or a theme, you can then enqueue the style:
	wp_enqueue_style( 'guerrilla-youtube-video' );
}

add_action( 'wp_enqueue_scripts', 'guerrilla_youtube_video_style' );

?>