<?php
//Panel for testing API responses

//create top level options menus in admin
add_action( 'admin_menu', 'tekserve_celebros_test_panel_menu' );

//generates the menu for test panel
function tekserve_celebros_test_panel_menu() {
	add_menu_page( 'Test Celebros', 'Test Celebros', 'edit_published_pages', 'tekserve_celebros_test_panel_menu', 'tekserve_celebros_test_panel_menu_page', 'dashicons-search', '8.217' );
	add_submenu_page( 'tekserve_celebros_test_panel_menu', 'Tekserve Celebros Functions', 'Tekserve Celebros Functions', 'edit_published_pages', 'tekserve_celebros_test_panel_menu', 'tekserve_celebros_test_panel_menu_page');
}

//generates html for the test panel menu page
function tekserve_celebros_test_panel_menu_page( $handle = NULL, $operation = NULL ) {
	global $wpdb;
	$api = $GLOBALS['QWISER'];
// 	var_dump($_POST);
	if ( ! empty( $_POST ) && check_admin_referer( 'performoperation', 'celebrostestpanel' ) ) {
		echo "POST: <br/>";
		$q = (isset($_POST['celebros_search_query'])) ? sanitize_text_field( $_POST['celebros_search_query'] ) : NULL;
		$operation = (isset($_POST['celebros_operation'])) ? sanitize_text_field( $_POST['celebros_operation'] ) : NULL;

		switch($operation) {
			case "Search":
				$results = $api->Search($q)->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				var_dump($searchinfo);
				break;
		}
	

// 		var_dump($api);
// 		var_dump($results);
	}
	?>
	<style>
	.hidden-fields select,
	.hidden-fields label,
	.hidden-fields input {
		font-weight: 900;
	}
	.product {
		border: 1px dotted #000;
		display: inline-block;
		margin: 1em auto;
		padding: 1em;
	}
	</style>
	<h1>Celebros Test Panel</h1><hr/>
	<h3>Current API Settings:</h3>
	<table>
		<tr>
			<td>
				<b>Host:</b>
			</td>
			<td>
				<?php echo $api->option_data['host'] ?>
			</td>
		</tr>
		<tr>
			<td>
				<b>Port:</b>
			</td>
			<td>
				<?php echo $api->option_data['port'] ?>
			</td>
		</tr>
		<tr>
			<td>
				<b>Key:</b>
			</td>
			<td>
				<?php echo $api->option_data['key'] ?>
			</td>
		</tr>
	</table>
	<h3>Test Operations:</h3>
	
	<p>
	PAGE <b><?php echo $searchinfo->CurrentPage ?></b> of <b><?php echo $searchinfo->NumberOfPages ?></b>
	</p>
	<p>
	SORTED BY <b><?php echo $searchinfo->SortingOptions->Method ?><?php echo (isset( $searchinfo->SortingOptions->FieldName ) ) ? '' : ': ' . $searchinfo->SortingOptions->FieldName ?></b> - <b><?php echo ($searchinfo->SortingOptions->Ascending) ? 'ASC' : 'DESC' ?></b>
	</p>
	
	<?php if( isset( $handle ) && isset( $operation ) ): ?>
	
	<?php $operations = array(
		'ActivateProfile'	=> 'Switch Profile',
		'ChangePageSize'	=> 'Change Number of Results per Page',
		'FirstPage'			=> 'Go to First Page of Results',
		'LastPage'			=> 'Go to Last Page of Results',
		'NextPage'			=> 'Go to First Page of Results',
		'PreviousPage'		=> 'Go to Previous Page of Results',
		'SortByField'		=> 'Sort by Product Field',
		'SortByPrice'		=> 'Sort by Product Price',
		'SortByRelevancy'	=> 'Sort by Product Relevance',
		'Search'			=> 'New Search'
	) ?>
	

	
	<form id="celebros_operation" method="POST" action="">
		<?php wp_nonce_field( 'performoperation', 'celebrostestpanel' ) ?>
		<div class="visible-fields">
			<label for="celebros_search_handle">Search Handle:</label>
			<input readonly type="text" size="60" id="celebros_search_handle" name="celebros_search_handle" value="<?php echo $handle ?>" />
			<br/>
			<label for="celebros_search_profile">Search Profile:</label>
			<input readonly type="text" id="celebros_search_profile" name="celebros_search_profile" value="<?php echo $searchinfo->SearchProfileName ?>" />
			<br/>
			<label for="celebros_search_query">Search Query:</label>
			<input readonly type="text" size="60" id="celebros_search_query" name="celebros_search_query"  value="<?php echo $q ?>" />
			<br/>
			<label for="celebros_operation">Operation:</label>
			<select readonly type="text" id="celebros_operation" name="celebros_operation">
			<?php foreach( $operations as $operation=>$label ): ?>
				<option value="<?php echo $operation ?>"><?php echo $label ?></option>
			<?php endforeach ?>
			</select>
			<br/>
		</div>
		<div class="hidden-fields">
		
		<?php $profiles = $api->GetAllSearchProfiles()->results ?>
		<label for="celebros_profiles">Profiles:</label>
		<select type="text" id="celebros_profiles" name="celebros_profiles">
			<?php foreach( $profiles as $profile ): ?>
				<option value="<?php echo $profile ?>"><?php echo $profile ?></option>
			<?php endforeach ?>
		</select>
		<?php $pfields = $api->GetAllProductFields()->results->Items ?>
		<label for="celebros_product_fields">Product Fields:</label>
		<select type="text" id="celebros_product_fields" name="celebros_product_fields">
			<?php foreach( $pfields as $field ): ?>
				<option value="<?php echo $field->FieldName ?>"><?php echo $field->FieldName ?></option>
			<?php endforeach ?>
		</select>

		</div>
		<input type="submit" value="Operate" />
	</form>
	
	<?php else: ?>
	
	<?php $operations = array(
		'Search'	=> 'New Search'
	) ?>
	
	<form id="celebros_operation" method="POST" action="">
		<?php wp_nonce_field( 'performoperation', 'celebrostestpanel' ) ?>
		<div class="visible-fields">
			<label for="celebros_search_query">Search Query:</label>
			<input type="text" size="60" id="celebros_search_query" name="celebros_search_query" />
			<br/>
			<label for="celebros_operation">Operation:</label>
			<select readonly type="text" id="celebros_operation" name="celebros_operation">
			<?php foreach( $operations as $operation=>$label ): ?>
				<option value="<?php echo $operation ?>"><?php echo $label ?></option>
			<?php endforeach ?>
			</select>
			<br/>
		</div>
		<div class="hidden-fields">
		</div>
		<input type="submit" value="Operate" />
	</form>
	
	<?php endif ?>
	
	<?php if( isset( $api->current_response ) ): ?>
	<h3>Current Response:</h3>
	<div class="api-response">
		<?php echo $api->current_response ?>
	</div>
	<?php endif ?>
	
	
	<?php if( isset( $api->results ) || isset( $results ) ): ?>
	<h3>Results:</h3>
	<div class="api-results">
		<?php //print_r($api) ?>
		 <?php //debug_print_backtrace(); ?>
		 <?php  
		 foreach( $results->Products->Items as $product ): ?>
		 	<div class="product">
		 		<h4><?php echo $product->Field['sku']; ?></h4>
		 		<?php foreach( $product->Field as $field=>$value ): ?>
		 			<?php if( $field != "sku" && isset( $value ) && $value != '' ): ?>
		 				<div class="product-field">
		 					<b><?php echo $field ?>:</b>
		 					<br/> 
		 					<?php echo substr( $value, 0 , 90 ) ?>
		 					<?php echo ( strlen( $value ) > 90 ) ? '[...]' : '' ?>
		 				</div>
		 			<?php endif ?>
		 		<?php endforeach ?>
		 	</div>
		 	<br/>
		 <?php endforeach ?>
		<h3>raw:</h3>
		<?php print_r($results) ?>
	</div>
	<?php endif ?>
	
	<?php
}