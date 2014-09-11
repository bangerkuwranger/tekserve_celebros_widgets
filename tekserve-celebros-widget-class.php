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
		//enqueue js for content retrieval, send needed vars to js, add css for widget display
		
		//add get option #ofresults for both types of data here to pass in localize; hardcoded for now
		$productsper = 3;
		$contentsper = 3;
		$loader = QWISER_URL . 'images/ajax-loader.gif';
		//check for theme override of plugin loader image
		if( file_exists( get_stylesheet_directory() . '/images/ajax-loader.gif' ) ) {
			$loader = get_stylesheet_directory_uri() . '/images/ajax-loader.gif';
		}
		$qwiser_js_data = array(
			'themeUrl'				=> get_stylesheet_directory_uri(),
			'pluginUrl'				=> QWISER_URL,
			'numProductsToDisplay'	=> $productsper,
			'numContentsToDisplay'	=> $contentsper,
			'loader'				=> $loader
		);
		$plugincss = QWISER_URL . 'tekserve-celebros-widgets.css';
		//check for theme override of plugin css
		if( file_exists( get_stylesheet_directory() . '/tekserve-celebros-widgets.css' ) ) {
			$plugincss = get_stylesheet_directory_uri() . '/tekserve-celebros-widgets.css';
		}
		wp_enqueue_style( 'celebroswidgetscss', $plugincss );
		wp_enqueue_script( 'celebroswidgetsjs', QWISER_URL . 'tekserve-celebros-widgets.js', array('jquery'), '', true );
		wp_localize_script( 'celebroswidgetsjs', 'qwiserData', $qwiser_js_data );
		
		//get post id, post title, default display options, and post display options
		global $wp_query;
		$post_obj = $wp_query->get_queried_object();
		$this_post_id = $post_obj->ID;
		$this_post_title = $post_obj->post_title;
		
		$default_display_option = get_option('tekserve_celebros_' . $instance['type'] . '_display_option');
		$post_display_option = get_post_meta( $this_post_id, 'tekserve_celebros_' . $instance['type'] . '_display', true );
		if( $post_display_option == null || $post_display_option == '' || $post_display_option == 'default' ) {
			$post_display_option = $default_display_option;
		}
		if( $post_display_option == 'keywords' ) {
			$related_keywords = get_post_meta( $this_post_id, 'tekserve_celebros_' . $instance['type'] . '_keywords', false );
			$related_keywords = $related_keywords[0];
// 			$related_keywords_count = count( $related_keywords );
		}
		else {
			$related_keywords = false;
// 			$related_keywords_count = 0;
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
		$html_structure = '<div class="tekserve-celebros-related-items related-' . $instance['type'] . '">';
		if( $post_display_option == 'title' ) {
			$html_structure .= '<div class="tekserve-celebros-related-items-section first" qwiserquery="' . urlencode( $this_post_title ) . '">';
			$html_structure .= '<p class="tekserve-celebros-related-items-section-title"><strong>' . ucwords( $this_post_title ) . '</strong></p>';
			$html_structure .= '<div class="tekserve-celebros-related-items-section-content"></div>';
			$html_structure .= '</div>';
		}
		if( $post_display_option == 'keywords' ) {
// 			$html_structure .= print_r($related_keywords,true);
			$i=1;
			foreach( $related_keywords as $keyword ) {
				
				$html_structure .= '<div class="tekserve-celebros-related-items-section ' . numToOrdinalWord($i) . '" qwiserquery="' . urlencode( $keyword ) . '">';
				$html_structure .= '<p class="tekserve-celebros-related-items-section-title"><strong>' . ucwords( $keyword ) . '</strong></p>';
				$html_structure .= '<div class="tekserve-celebros-related-items-section-content"></div>';
				$html_structure .= '</div>';
				$i++;
			}
		}
		$html_structure .= '</div>';
		
		//widget output
		if( $post_display_option == 'none' ) {
			return false;
		}
		else{
			echo $args['before_widget'];
			echo $args['before_title'] . apply_filters( 'widget_title', $title ). $args['after_title'];
			echo $html_structure;
// 			echo $this_post_id . '<br/>' . $this_post_title . '<br/>' . $instance['type'] . ' display option: ' . $post_display_option;
			echo $args['after_widget'];
		}
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

//loop section class generation help with english ordinal class names
function numToOrdinalWord($num) {
	$first_word = array('eth','first','second','third','fouth','fifth','sixth','seventh','eighth','ninth','tenth','eleventh','twelfth','thirteenth','fourteenth','fifteenth','sixteenth','seventeenth','eighteenth','nineteenth','twentieth');
	$second_word =array('','','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety');

	if($num <= 20)
		return $first_word[$num];

	$first_num = substr($num,-1,1);
	$second_num = substr($num,-2,1);

	return $string = str_replace('y-eth','ieth',$second_word[$second_num].'-'.$first_word[$first_num]);
}