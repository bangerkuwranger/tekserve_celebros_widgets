<?php

//create meta boxes to select and save display options: 
//for both content and products user can decide whether to display 
//None : Default (from options) : Relate to Title : Related to Custom Phrases


function tekserve_celebros_content_metabox() {
    
    add_meta_box( 'tekserve_celebros_content_metabox', 'Celebros Content Keywords', 'tekserve_celebros_content_metabox_callback', 'post', 'side' );

}

//create meta box to display fields that save meta fields for content
add_action( 'add_meta_boxes', 'tekserve_celebros_content_metabox' );

// add meta for content keywords/phrases to all post objects
function tekserve_celebros_content_metabox_callback( $post ) { ?>
	<style>
		.tekserve_celebros_content_metabox_keywords input[type="text"] {
			min-width: 50px;
			width: 100%;
		}
	</style>
	<?php wp_nonce_field( basename( __FILE__ ), 'tekserve_celebros_content_metabox' ); ?>
	<?php $tekserve_celebros_content_metabox_display = get_post_meta( $post->ID, 'tekserve_celebros_content_display', true ) ?>
	<?php $tekserve_celebros_content_metabox_keywords = get_post_meta( $post->ID, 'tekserve_celebros_content_keywords', false ) ?>
	<?php $tekserve_celebros_content_metabox_keywords = $tekserve_celebros_content_metabox_keywords[0] ?>
	<?php $tekserve_celebros_content_metabox_keywords_count = count( $tekserve_celebros_content_metabox_keywords ) ?>
	<?php if( $tekserve_celebros_content_metabox_display == null || $tekserve_celebros_content_metabox_display == '' ){ $tekserve_celebros_content_metabox_display = 'default'; } ?>
	<p>
		<label for="tekserve_celebros_content_metabox_display"><b>Select articles to display:</b></label><br/>
		<input name="tekserve_celebros_content_metabox_display" type="radio" value="none" <?php checked( $tekserve_celebros_content_metabox_display, 'none', true ) ?>>None</input><br/>
		<input name="tekserve_celebros_content_metabox_display" type="radio" value="default" <?php checked( $tekserve_celebros_content_metabox_display, 'default', true ) ?>>Default (selected in settings)</input><br/>
		<input name="tekserve_celebros_content_metabox_display" type="radio" value="title" <?php checked( $tekserve_celebros_content_metabox_display, 'title', true ) ?>>Related to Title</input><br/>
		<input name="tekserve_celebros_content_metabox_display" type="radio" value="keywords" <?php checked( $tekserve_celebros_content_metabox_display, 'keywords', true ) ?>>Related to Keywords (enter below)</input>
	</p>
	<p class="tekserve_celebros_content_metabox_keywords">
	<?php if( $tekserve_celebros_content_metabox_keywords_count == 0 || $tekserve_celebros_content_metabox_keywords_count == null ): ?>
		<label for="tekserve_celebros_content_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw1" name="tekserve_celebros_content_metabox_kw1" /><br/>
		<label for="tekserve_celebros_content_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw2" name="tekserve_celebros_content_metabox_kw2" /><br/>
		<label for="tekserve_celebros_content_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw3" name="tekserve_celebros_content_metabox_kw3" />
	<?php elseif( $tekserve_celebros_content_metabox_keywords_count == 1 ): ?>
		<label for="tekserve_celebros_content_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw1" name="tekserve_celebros_content_metabox_kw1" value="<?php echo $tekserve_celebros_content_metabox_keywords[0] ?>" /><br/>
		<label for="tekserve_celebros_content_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw2" name="tekserve_celebros_content_metabox_kw2" /><br/>
		<label for="tekserve_celebros_content_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw3" name="tekserve_celebros_content_metabox_kw3" />
	<?php elseif( $tekserve_celebros_content_metabox_keywords_count == 2 ): ?>
		<label for="tekserve_celebros_content_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw1" name="tekserve_celebros_content_metabox_kw1" value="<?php echo $tekserve_celebros_content_metabox_keywords[0] ?>" /><br/>
		<label for="tekserve_celebros_content_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw2" name="tekserve_celebros_content_metabox_kw2" value="<?php echo $tekserve_celebros_content_metabox_keywords[1] ?>"/><br/>
		<label for="tekserve_celebros_content_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw3" name="tekserve_celebros_content_metabox_kw3" />
	<?php elseif( $tekserve_celebros_content_metabox_keywords_count == 3 ): ?>
		<label for="tekserve_celebros_content_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw1" name="tekserve_celebros_content_metabox_kw1" value="<?php echo $tekserve_celebros_content_metabox_keywords[0] ?>" /><br/>
		<label for="tekserve_celebros_content_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw2" name="tekserve_celebros_content_metabox_kw2" value="<?php echo $tekserve_celebros_content_metabox_keywords[1] ?>" /><br/>
		<label for="tekserve_celebros_content_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_content_metabox_kw3" name="tekserve_celebros_content_metabox_kw3" value="<?php echo $tekserve_celebros_content_metabox_keywords[2] ?>" />
	<?php endif ?>
	</p>
    
<?php }

//save related content display option and keywords
function tekserve_celebros_content_metabox_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'tekserve_celebros_content_metabox' ] ) && wp_verify_nonce( $_POST[ 'tekserve_celebros_content_metabox' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'tekserve_celebros_content_metabox_display' ] ) ) {
        update_post_meta( $post_id, 'tekserve_celebros_content_display', sanitize_text_field( $_POST[ 'tekserve_celebros_content_metabox_display' ] ) );
    }
    $keywords = array();
    if( isset( $_POST[ 'tekserve_celebros_content_metabox_kw1' ] ) ) {
        $keywords[0] = sanitize_text_field( $_POST[ 'tekserve_celebros_content_metabox_kw1' ] );
    }
    if( isset( $_POST[ 'tekserve_celebros_content_metabox_kw2' ] ) ) {
        $keywords[1] = sanitize_text_field( $_POST[ 'tekserve_celebros_content_metabox_kw2' ] );
    }
    if( isset( $_POST[ 'tekserve_celebros_content_metabox_kw3' ] ) ) {
        $keywords[2] = sanitize_text_field( $_POST[ 'tekserve_celebros_content_metabox_kw3' ] );
    }
    if( !empty( $keywords ) ) {
    	update_post_meta( $post_id, 'tekserve_celebros_content_keywords', $keywords );
    }
 
}

add_action( 'save_post', 'tekserve_celebros_content_metabox_save' );

//create meta box to display fields that save meta fields for product
function tekserve_celebros_product_metabox() {
    
    add_meta_box( 'tekserve_celebros_product_metabox', 'Celebros Product Keywords', 'tekserve_celebros_product_metabox_callback', 'post', 'side' );

}

add_action( 'add_meta_boxes', 'tekserve_celebros_product_metabox' );

// add meta for product keywords/phrases to all post objects
function tekserve_celebros_product_metabox_callback( $post ) { ?>
	<style>
		.tekserve_celebros_product_metabox_keywords input[type="text"] {
			min-width: 50px;
			width: 100%;
		}
	</style>
	<?php wp_nonce_field( basename( __FILE__ ), 'tekserve_celebros_product_metabox' ); ?>
	<?php $tekserve_celebros_product_metabox_display = get_post_meta( $post->ID, 'tekserve_celebros_product_display', true ) ?>
	<?php $tekserve_celebros_product_metabox_keywords = get_post_meta( $post->ID, 'tekserve_celebros_product_keywords', false ) ?>
	<?php $tekserve_celebros_product_metabox_keywords = $tekserve_celebros_product_metabox_keywords[0] ?>
	<?php $tekserve_celebros_product_metabox_keywords_count = count( $tekserve_celebros_product_metabox_keywords ) ?>
	<?php if( $tekserve_celebros_product_metabox_display == null || $tekserve_celebros_product_metabox_display == '' ){ $tekserve_celebros_product_metabox_display = 'default'; } ?>
	<p>
		<label for="tekserve_celebros_product_metabox_display"><b>Select products to display:</b></label><br/>
		<input name="tekserve_celebros_product_metabox_display" type="radio" value="none" <?php checked( $tekserve_celebros_product_metabox_display, 'none', true ) ?>>None</input><br/>
		<input name="tekserve_celebros_product_metabox_display" type="radio" value="default" <?php checked( $tekserve_celebros_product_metabox_display, 'default', true ) ?>>Default (selected in settings)</input><br/>
		<input name="tekserve_celebros_product_metabox_display" type="radio" value="title" <?php checked( $tekserve_celebros_product_metabox_display, 'title', true ) ?>>Related to Title</input><br/>
		<input name="tekserve_celebros_product_metabox_display" type="radio" value="keywords" <?php checked( $tekserve_celebros_product_metabox_display, 'keywords', true ) ?>>Related to Keywords (enter below)</input>
	</p>
	<p class="tekserve_celebros_product_metabox_keywords">
	<?php if( $tekserve_celebros_product_metabox_keywords_count == 0 || $tekserve_celebros_product_metabox_keywords_count == null ): ?>
		<label for="tekserve_celebros_product_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw1" name="tekserve_celebros_product_metabox_kw1" /><br/>
		<label for="tekserve_celebros_product_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw2" name="tekserve_celebros_product_metabox_kw2" /><br/>
		<label for="tekserve_celebros_product_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw3" name="tekserve_celebros_product_metabox_kw3" />
	<?php elseif( $tekserve_celebros_product_metabox_keywords_count == 1 ): ?>
		<label for="tekserve_celebros_product_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw1" name="tekserve_celebros_product_metabox_kw1" value="<?php echo $tekserve_celebros_product_metabox_keywords[0] ?>" /><br/>
		<label for="tekserve_celebros_product_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw2" name="tekserve_celebros_product_metabox_kw2" /><br/>
		<label for="tekserve_celebros_product_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw3" name="tekserve_celebros_product_metabox_kw3" />
	<?php elseif( $tekserve_celebros_product_metabox_keywords_count == 2 ): ?>
		<label for="tekserve_celebros_product_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw1" name="tekserve_celebros_product_metabox_kw1" value="<?php echo $tekserve_celebros_product_metabox_keywords[0] ?>" /><br/>
		<label for="tekserve_celebros_product_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw2" name="tekserve_celebros_product_metabox_kw2" value="<?php echo $tekserve_celebros_product_metabox_keywords[1] ?>"/><br/>
		<label for="tekserve_celebros_product_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw3" name="tekserve_celebros_product_metabox_kw3" />
	<?php elseif( $tekserve_celebros_product_metabox_keywords_count == 3 ): ?>
		<label for="tekserve_celebros_product_metabox_kw1"><b>Keywords/Phrase 1:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw1" name="tekserve_celebros_product_metabox_kw1" value="<?php echo $tekserve_celebros_product_metabox_keywords[0] ?>" /><br/>
		<label for="tekserve_celebros_product_metabox_kw2"><b>Keywords/Phrase 2:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw2" name="tekserve_celebros_product_metabox_kw2" value="<?php echo $tekserve_celebros_product_metabox_keywords[1] ?>" /><br/>
		<label for="tekserve_celebros_product_metabox_kw3"><b>Keywords/Phrase 3:</b></label><br/>
		<input type="text" id="tekserve_celebros_product_metabox_kw3" name="tekserve_celebros_product_metabox_kw3" value="<?php echo $tekserve_celebros_product_metabox_keywords[2] ?>" />
	<?php endif ?>
	</p>
    
<?php }

//save related product display option and keywords
function tekserve_celebros_product_metabox_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'tekserve_celebros_product_metabox' ] ) && wp_verify_nonce( $_POST[ 'tekserve_celebros_product_metabox' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return $post_id;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'tekserve_celebros_product_metabox_display' ] ) ) {
        update_post_meta( $post_id, 'tekserve_celebros_product_display', sanitize_text_field( $_POST[ 'tekserve_celebros_product_metabox_display' ] ) );
    }
    $keywords = array();
    if( isset( $_POST[ 'tekserve_celebros_product_metabox_kw1' ] ) ) {
        $keywords[0] = sanitize_text_field( $_POST[ 'tekserve_celebros_product_metabox_kw1' ] );
    }
    if( isset( $_POST[ 'tekserve_celebros_product_metabox_kw2' ] ) ) {
        $keywords[1] = sanitize_text_field( $_POST[ 'tekserve_celebros_product_metabox_kw2' ] );
    }
    if( isset( $_POST[ 'tekserve_celebros_product_metabox_kw3' ] ) ) {
        $keywords[2] = sanitize_text_field( $_POST[ 'tekserve_celebros_product_metabox_kw3' ] );
    }
    if( !empty( $keywords ) ) {
    	update_post_meta( $post_id, 'tekserve_celebros_product_keywords', $keywords );
    }
 
}
add_action( 'save_post', 'tekserve_celebros_product_metabox_save' );