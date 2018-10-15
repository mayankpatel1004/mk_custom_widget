<?php
/**
 * Plugin Name: MK Widget Plugin
 * Plugin URI: http://www.mayankpatel104.blogspot.in/
 * Description: Find Widget on Admin -> Appariance -> Widget and Find MK Widget and drag to your sidebar.
 * Version: 1.0
 * Author: Mayank Patel
 * Author URI: http://www.mayankpatel104.blogspot.in/
 * License: A "mk_custom_widget"
 */
 
define( 'PLUGIN_HTTP_PATH' , WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__) , "" , plugin_basename(__FILE__) ) );
define( 'PLUGIN_ABSPATH' , WP_PLUGIN_DIR . '/' . str_replace(basename( __FILE__) , "" , plugin_basename(__FILE__) ) );

//****************************************** Widget code start ********************************////
class mk_custom_widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct('mk_custom_widget',__('MK Widget', 'mk_custom_widget_domain'), array( 'description' => __( 'MK Widget By Mayank Patel', 'mk_custom_widget_description' ),));
	}
	
	/*public function __construct() {
		parent::__construct(
	 		'mk_widget', // Base ID
			'Image Upload Widget', // Name
 
			array( 'description' => __( 'A widget to upload image', 'iuw' ), ) // Args
		);
	}*/

	public function widget($args,$instance)
	{
		$title = apply_filters('widget_title',$instance['title']);
		$description = apply_filters('widget_description',$instance['description']);
		$url = apply_filters('widget_url',$instance['url']);
		echo $args['before_widget'];
		if(!empty($title))
		{
			echo $args['before_title'] . $title . $args['after_title'];
		}
		if(!empty($description))
		{
			echo $description . $args['after_title'];
		}
		if(!empty($url))
		{
			echo "<br /><a href='".$url."' target='_blank'>".$url."</a>";
		}
		
		//echo $args['after_widget'];
		$image_uri = apply_filters( 'widget_image_uri', $instance['image_uri'] );
		echo $before_widget; ?>
        <a href="<?php echo esc_url($url); ?>" target="_blank"><img src="<?php echo esc_url($instance['image_uri']); ?>" /></a>
        
    <?php
	echo $args['after_widget'];
	}
	
	public function form($instance)
	{
		$description = "";
		$url = "";
		$title = "";
		if(isset($instance['description']))
		{
			$description = $instance['description'];
		}
		if(isset($instance['url']))
		{
			$url = $instance['url'];
		}
		if(isset($instance['title']))
		{
			$title = $instance['title'];
		}
		else
		{
			$title = __('New title','mk_custom_widget_description');
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'Description' ); ?>"><?php _e( 'Description:' ); ?></label> 
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr( $description ); ?></textarea>
		</p>
         <p>
      <label for="<?php echo $this->get_field_id('image_uri'); ?>">Image</label><br />
        <img class="custom_media_image" src="<?php echo $image_uri; ?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
        <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image_uri; ?>">
       </p>
       <p>
        <input type="button" value="<?php _e( 'Upload Image', 'iuw' ); ?>" class="button custom_media_upload" id="custom_image_uploader"/>
    </p>
	<?php 
	}
	public function update($new_instance,$old_instance)
	{
		$instance = array();
		$instance['title'] = (!empty($new_instance['title']))?strip_tags($new_instance['title']):'';
		$instance['description'] = (!empty($new_instance['description']))?strip_tags($new_instance['description']):'';
		$instance['url'] = (!empty($new_instance['url']))?strip_tags($new_instance['url']):'';
		$instance['image_uri'] = ( ! empty( $new_instance['image_uri'] ) ) ? strip_tags( $new_instance['image_uri'] ) : '';
		return $instance;
	}
}

function wpb_load_widget()
{
	register_widget( 'mk_custom_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

add_action( 'widgets_init', create_function( '', 'register_widget( "mk_custom_widget" );' ) );
function iuw_wdScript(){
  wp_enqueue_media();
  wp_enqueue_script('adsScript', plugins_url( '/js/image-upload-widget.js' , __FILE__ ));
}
add_action('admin_enqueue_scripts', 'iuw_wdScript');
//****************************************** Widget code over ********************************////
?>