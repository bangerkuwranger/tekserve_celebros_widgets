<?php
//widget code for structure and includes for widget instances

class Tekserve_Celebros_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		parent::__construct(
			'tekserve_celebros_widget', // Base ID
			__( 'Celebros Related Items', 'tekserve_celebros_widgets' ), // Name
			array( 'description' => __( 'Displays Items (content or products) related to post as set in plugin\'s default settings or in the individual post', 'tekserve_celebros_widgets' ), ) // Args
		);
		
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		//enqueue js for content retrieval
		wp_enqueue_script( 'celebroswidgets', QWISER_URL . '/widgets.js', array('jquery'), '', true );
		
		//get post id, post title, default display options, and post display options
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		$this_post_id = $post_obj->ID;
		$this_post_title = $post_obj->post_title;
		$default_content_option = get_option('tekserve_celebros_content_display_option');
		$default_product_option = get_option('tekserve_celebros_product_display_option');
		$post_product_option = get_post_meta( $this_post_id, 'tekserve_celebros_product_display', true );
		$product_keywords = get_post_meta( $this_post_id, 'tekserve_celebros_product_keywords', false );
		$product_keywords = $product_keywords[0];
		$product_keywords_count = count( $product_keywords );
		if( $post_product_option == null || $post_product_option == '' || $post_product_option == 'default' ) {
			$post_product_option = $default_product_option;
		}
		$post_content_option = get_post_meta( $this_post_id, 'tekserve_celebros_content_display', true );
		$content_keywords = get_post_meta( $this_post_id, 'tekserve_celebros_content_keywords', false );
		$content_keywords = $content_keywords[0];
		$content_keywords_count = count( $content_keywords );
		if( $post_content_option == null || $post_content_option == '' || $post_content_option == 'default' ) {
			$post_content_option = $default_content_option;
		}

		
		//create title based on widget type
		$title = '';
		if( $instance['type'] == 'product' ) {
			$title .= 'Products ';
		}if( $instance['type'] == 'content' ) {
			$title .= 'Read More Articles ';
		}
		$title .= 'Related to...';
		
		//create structure based on global/post options
		
		//widget output
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $title ). $args['after_title'];
// 		echo $this_post_id . '<br/>' . $this_post_title;
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'type' ] ) ) {
			$type = $instance[ 'type' ];
		}
		else {
			$type = 'content';
		}
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'tekserve_celebros_widgets' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type of Results:' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" >
				<option value="content" <?php selected( $type, 'content' ) ?>>Content</option>
				<option value="product" <?php selected( $type, 'product' ) ?>>Product</option>
			</select>
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		return $instance;
	}
}

// register Celebros widget
function register_tekserve_celebros_widget() {
    register_widget( 'Tekserve_Celebros_Widget' );
}
add_action( 'widgets_init', 'register_tekserve_celebros_widget' );