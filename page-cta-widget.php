<?php
/*
Plugin Name: Rim Page CTA Widget
Description: Insert CTA button linking to a page as a widget
Version: 1.0
Author: admiralchip
Author URI: http://github.com/admiralchip
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


class Rim_Pagecta_Widget extends WP_Widget {

    public function __construct() {
		
		//Define constructor
		
		$options = array(
        'classname' => 'rim_pagecta_widget',
        'description' => 'Rim Page Call to Action (CTA) Widget: Insert CTA button linking to a page as a widget',
    );

    parent::__construct(
        'rim_pagecta_widget', 'Rim Page CTA Widget', $options
    );
	
    }

    public function widget( $args, $instance ) {
        // Define the widget
		$button_text = $instance['button_text'];
		$page_link = get_page_link($instance['page_id']);
		echo $args['before_widget'];

		echo  '<p class="rim-pagecta"><a href=" ' . $page_link . '">' . $button_text . '</a></p>';
		

		echo $args['after_widget'];
    }
	
	// Widget Backend 
public function form( $instance ) {
// Widget admin form
if(isset($instance['button_text'])) {
	$button_text = $instance['button_text'];
} else {
	$button_text = __('Button text', 'rim');
}
?>
<p>
	<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Page:' ); ?></label> 
		<select id="<?php echo $this->get_field_id( 'page_id' ); ?>" name="<?php echo $this->get_field_name( 'page_id' ); ?>"> 
                <?php           
                    $pages = get_pages();
                    $selected = $instance['page_id'];
                    foreach ( $pages as $page ) {
                        $onlyID =  $page->ID ;
                        $onlyName = $page->post_title;
                        if ($selected == $onlyID) {
                            echo '<option selected="selected" value="' . $onlyID . '">'.$onlyName.'</option>';
                        } else {
                            echo '<option  value="' . $onlyID . '">'.$onlyName.'</option>';
                        }
                    }
                ?>
        </select>
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Text on button ' ); ?></label>
		<input type="text" name="<?php echo $this->get_field_name( 'button_text' ); ?>" id="<?php echo $this->get_field_id( 'button_text' ); ?>" value="<?php echo $button_text; ?>">
</p>
<?php 
}
     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
  
        $instance['page_id'] = stripslashes($new_instance['page_id']);
		$instance['button_text'] = stripslashes($new_instance['button_text']);

        return $instance;
    }
}

// Register the widget
function register_rimpagecta_widget() {
    register_widget( 'Rim_Pagecta_Widget' );
}
add_action( 'widgets_init', 'register_rimpagecta_widget' );

?>
