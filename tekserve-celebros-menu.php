<?php
//Initializes menu pages and include associated files

//include file to create testing panel
require_once( QWISER_PATH . "tekserve-celebros-test-panel.php" );



//create top level options menus in admin
add_action( 'admin_menu', 'tekserve_celebros_menu' );

//generates the menu for test panel
function tekserve_celebros_menu() {

	add_menu_page( 'Celebros', 'Celebros', 'edit_published_pages', 'tekserve_celebros_menu', 'tekserve_celebros_related_settings_menu_page', 'dashicons-search', '8.217' );
	add_submenu_page( 'tekserve_celebros_menu', 'Test Celebros Functions', 'Test Celebros Functions', 'edit_published_pages', 'tekserve_celebros_test_panel_menu', 'tekserve_celebros_test_panel_menu_page');

}	//end tekserve_celebros_menu()




function tekserve_celebros_register_default_display_options() {

		register_setting('tekserve_celebros_options', 'tekserve_celebros_content_display_option');
		register_setting('tekserve_celebros_options', 'tekserve_celebros_content_display_number');
		register_setting('tekserve_celebros_options', 'tekserve_celebros_product_display_option');
		register_setting('tekserve_celebros_options', 'tekserve_celebros_product_display_number');

}	//end tekserve_celebros_register_default_display_options()

add_action( 'admin_init', 'tekserve_celebros_register_default_display_options' );




//generates html for default settings page
function tekserve_celebros_related_settings_menu_page() {

	// Checks for input and sanitizes/saves if needed
	if( wp_verify_nonce( $_POST[ 'tekserve_celebros_display_defaults' ], basename( __FILE__ ) ) ) {
	
		if( isset( $_POST[ 'tekserve_celebros_content_display_defaults' ] ) ) {
		
			update_option( 'tekserve_celebros_content_display_option', sanitize_text_field( $_POST[ 'tekserve_celebros_content_display_defaults' ] ) );
		
		}	//end if( isset( $_POST[ 'tekserve_celebros_content_display_defaults' ] ) )
		if( isset( $_POST[ 'tekserve_celebros_content_display_number' ] ) ) {
		
			update_option( 'tekserve_celebros_content_display_number', sanitize_text_field( $_POST[ 'tekserve_celebros_content_display_number' ] ) );
		
		}	//end if( isset( $_POST[ 'tekserve_celebros_content_display_number' ] ) )
		if( isset( $_POST[ 'tekserve_celebros_product_display_defaults' ] ) ) {
		
			update_option( 'tekserve_celebros_product_display_option', sanitize_text_field( $_POST[ 'tekserve_celebros_product_display_defaults' ] ) );
		
		}	//end if( isset( $_POST[ 'tekserve_celebros_product_display_defaults' ] ) )
		if( isset( $_POST[ 'tekserve_celebros_product_display_number' ] ) ) {
		
			update_option( 'tekserve_celebros_product_display_number', sanitize_text_field( $_POST[ 'tekserve_celebros_product_display_number' ] ) );
		
		}	 //end if( isset( $_POST[ 'tekserve_celebros_product_display_number' ] ) )
		?>
		<div id=message class="updated">
        	<p>Default display options for Celebros widgets have been updated.</p>
		</div>
		<?php
	
	}	//end if( wp_verify_nonce( $_POST[ 'tekserve_celebros_display_defaults' ], basename( __FILE__ ) ) )

	$content_option = get_option( 'tekserve_celebros_content_display_option' );
	if( $content_option == false ) {
	
		$content_option = 'title';
	
	}	//end if( $content_option == false )
	$content_number = get_option( 'tekserve_celebros_content_display_number' );
	if( $content_number == false ) {
	
		$content_number = 3;
	
	}	//end if( $content_number == false )
	$product_option = get_option( 'tekserve_celebros_product_display_option' );
	if( $product_option == false ) {
	
		$product_option = 'title';
	
	}	//end if( $product_option == false )
	$product_number = get_option( 'tekserve_celebros_product_display_number' );
	if( $product_number == false ) {
	
		$product_number = 3;
	
	}	//end if( $product_number == false )
	
	?>
	<h1>Settings</h1>
	<hr/>
	<h2>Related Items Display</h2>
	<p>
		Select which items are displayed with posts by default. 'None' will hide this type of item by default; 'Title' will display one section of related items based on the post's title by default; 'Keywords' will display a section for each keyword/phrase selected in the post.
	</p>
	<h4>*NOTE*</h4>
	<p>
		If 'Keywords' is selected as the default option for either products or content, <em>NO</em> related items will be displayed for a post until at least one keyword/phrase has been entered in that post's settings. There are no *global* default keywords.
	</p>
	<form id="tekserve-celebros-display-defaults" method="POST" action="">
	<?php wp_nonce_field( basename( __FILE__ ), 'tekserve_celebros_display_defaults' ); ?>
		<p>
			<label for="tekserve_celebros_content_display_defaults"><b>Default Articles to Display:</b></label><br/>
			<input name="tekserve_celebros_content_display_defaults" type="radio" value="none" <?php checked( $content_option, 'none', true ) ?>>None</input><br/>
			<input name="tekserve_celebros_content_display_defaults" type="radio" value="title" <?php checked( $content_option, 'title', true ) ?>>Related to Title</input><br/>
			<input name="tekserve_celebros_content_display_defaults" type="radio" value="keywords" <?php checked( $content_option, 'keywords', true ) ?>>Related to Keywords (entered in post)</input>
		</p>
		<p>
			<label for="tekserve_celebros_content_display_number"><b>Number of Articles to Display:</b></label><br/>
			<input id="tekserve_celebros_content_display_number" name="tekserve_celebros_content_display_number" type="number" value="<?php echo $content_number ?>" size="3" />
		</p>
		<p>
			<label for="tekserve_celebros_product_display_defaults"><b>Default Products to Display:</b></label><br/>
			<input name="tekserve_celebros_product_display_defaults" type="radio" value="none" <?php checked( $product_option, 'none', true ) ?>>None</input><br/>
			<input name="tekserve_celebros_product_display_defaults" type="radio" value="title" <?php checked( $product_option, 'title', true ) ?>>Related to Title</input><br/>
			<input name="tekserve_celebros_product_display_defaults" type="radio" value="keywords" <?php checked( $product_option, 'keywords', true ) ?>>Related to Keywords (entered in post)</input>
		</p>
		<p>
			<label for="tekserve_celebros_product_display_number"><b>Number of Products to Display:</b></label><br/>
			<input id="tekserve_celebros_product_display_number" name="tekserve_celebros_product_display_number" type="number" value="<?php echo $product_number ?>" size="3" />
		</p>
		<p>
			<?php submit_button( 'Save Default Display Settings' ) ?>
		</p>
	</form>
	<?php

}	//end tekserve_celebros_related_settings_menu_page()