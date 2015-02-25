<?php
//Panel for testing API responses


//generates html for the test panel menu page
function tekserve_celebros_test_panel_menu_page( $handle = NULL, $operation = NULL ) {

	global $wpdb;
	$api = $GLOBALS['QWISER'];
	if( ! empty( $_POST ) && check_admin_referer( 'performoperation', 'celebrostestpanel' ) ) {
	
		echo "POST: <br/>";
		$q = (isset($_POST['celebros_search_query'])) ? sanitize_text_field( $_POST['celebros_search_query'] ) : NULL;
		$operation = (isset($_POST['celebros_operation'])) ? sanitize_text_field( $_POST['celebros_operation'] ) : NULL;
		$oldhandle = (isset($_POST['celebros_search_handle'])) ? sanitize_text_field( $_POST['celebros_search_handle'] ) : NULL;
		$newprofile = (isset($_POST['celebros_profiles'])) ? sanitize_text_field( $_POST['celebros_profiles'] ) : NULL;
		$newpagesize = (isset($_POST['celebros_search_perpage'])) ? sanitize_text_field( $_POST['celebros_search_perpage'] ) : NULL;
		$sortfield = (isset($_POST['celebros_product_fields'])) ? sanitize_text_field( $_POST['celebros_product_fields'] ) : NULL;
		$newsortdir = (isset($_POST['celebros_product_sortdir'])) ? sanitize_text_field( $_POST['celebros_product_sortdir'] ) : NULL;

		switch( $operation ) {
		
			case "Search":
				$results = $api->Search( $q )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "ActivateProfile":
				$results = $api->ActivateProfile( $oldhandle, $newprofile )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "ChangePageSize":
				$results = $api->ChangePageSize( $oldhandle, $newpagesize )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "FirstPage":
				$results = $api->FirstPage( $oldhandle )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "LastPage":
				$results = $api->LastPage( $oldhandle )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "PreviousPage":
				$results = $api->PreviousPage( $oldhandle )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "NextPage":
				$results = $api->NextPage( $oldhandle )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "SortByField":
				$results = $api->SortByField( $oldhandle, $sortfield, false, $newsortdir )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "SortByPrice":
				$results = $api->SortByPrice( $oldhandle, $newsortdir )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
			case "SortByRelevancy":
				$results = $api->SortByRelevancy( $oldhandle )->results;
				$handle = $results->GetSearchHandle();
				$searchinfo = $results->SearchInformation;
				break;
				
		}	//end switch( $operation )

	}	//end if( ! empty( $_POST ) && check_admin_referer( 'performoperation', 'celebrostestpanel' ) )
	?>
	<style>
	.hidden-fields select,
	.hidden-fields label,
	.hidden-fields input {
		font-weight: 900;
		display: none;
	}
	.product {
		border: 1px dotted #000;
		display: inline-block;
		margin: 1em auto;
		padding: 1em;
	}
	.api-results .product h4 {
		font-size: 1.25em;
		font-weight: 200;
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
	<?php if( isset( $handle ) && isset( $operation ) ): 
	?>
	<p>
		PAGE <b><?php echo $searchinfo->CurrentPage ?></b> of <b><?php echo $searchinfo->NumberOfPages ?></b>
	</p>
	<p>
		SORTED BY <b><?php echo $searchinfo->SortingOptions->Method ?><?php echo (isset( $searchinfo->SortingOptions->FieldName ) ) ? '' : ': ' . $searchinfo->SortingOptions->FieldName ?></b> - <b><?php echo ($searchinfo->SortingOptions->Ascending) ? 'ASC' : 'DESC' ?></b>
	</p>
	
	<?php $operations = array(
		'ActivateProfile'	=> 'Switch Profile',
		'ChangePageSize'	=> 'Change Number of Results per Page',
		'FirstPage'			=> 'Go to First Page of Results',
		'LastPage'			=> 'Go to Last Page of Results',
		'NextPage'			=> 'Go to Next Page of Results',
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
			<label for="celebros_search_query" style="font-weight: 900">Search Query:</label>
			<input type="text" size="60" id="celebros_search_query" name="celebros_search_query"  value="<?php echo $q ?>" style="font-weight: 900" />
			<br/>
			<label for="celebros_operation" style="font-weight: 900">Operation:</label>
			<select type="text" id="celebros_operation" name="celebros_operation" style="font-weight: 900">
			<?php foreach( $operations as $o=>$label ): 
			?>
				<option <?php echo ($operation == $o) ? 'selected="selected"' : '' ?> value="<?php echo $o ?>"><?php echo $label ?></option>
			<?php 
			endforeach ?>
			</select>
			<br/>
		</div>
		<div class="hidden-fields">
			<?php $profiles = $api->GetAllSearchProfiles()->results ?>
			<label for="celebros_profiles">Select New Search Profile:</label>
			<select type="text" id="celebros_profiles" name="celebros_profiles">
				<?php foreach( $profiles as $profile ): 
				?>
					<option value="<?php echo $profile ?>"><?php echo $profile ?></option>
				<?php 
				endforeach ?>
			</select>


			<label for="celebros_search_perpage">Enter Number of Results Per Page:</label>
			<input readonly type="number" id="celebros_search_perpage" name="celebros_search_perpage" value="<?php echo $searchinfo->PageSize ?>" />


			<?php $currentdir = ($searchinfo->SortingOptions->Ascending) ? 'ASC' : 'DESC' ?>
			<label for="celebros_product_sortdir">Change Sort Direction:</label>
			<select type="text" id="celebros_product_sortdir" name="celebros_product_sortdir">
				<option value="true" <?php echo ($currentdir == 'ASC') ? 'selected="selected"' : '' ?>>Ascending</option>
				<option value="false" <?php echo ($currentdir == 'DESC') ? 'selected="selected"' : '' ?>>Descending</option>
			</select>
			<br/>
		
			<?php $pfields = $api->GetAllProductFields()->results->Items ?>
			<label for="celebros_product_fields">Select Product Field to Sort By:</label>
			<select type="text" id="celebros_product_fields" name="celebros_product_fields">
				<?php foreach( $pfields as $field ): 
				?>
					<option value="<?php echo $field->FieldName ?>"><?php echo $field->FieldName ?></option>
				<?php
				endforeach ?>
			</select>
		</div>
		<input type="submit" value="Operate" />
	</form>
	
	<script type="text/javascript">
		function visibleFields(operation) {
		
			switch(operation) {
			
				case "Search" :
					jQuery('.hidden-fields select, .hidden-fields label, .hidden-fields input').hide().prop('readonly', true);
					jQuery('#celebros_search_query').prop('readonly', false);
					jQuery('#celebros_search_query, label[for="celebros_search_query"]').css('fontWeight', '900');
					break;
				case "ActivateProfile" :
					jQuery('.hidden-fields select, .hidden-fields label, .hidden-fields input').hide().prop('readonly', true);
					jQuery('#celebros_search_query').prop('readonly', true);
					jQuery('#celebros_profiles, label[for="celebros_profiles"]').show();
					jQuery('#celebros_search_query, label[for="celebros_search_query"]').css('fontWeight', 'normal');
					break;
				case "ChangePageSize" :
					jQuery('.hidden-fields select, .hidden-fields label, .hidden-fields input').hide().prop('readonly', true);
					jQuery('#celebros_search_query').prop('readonly', true);
					jQuery('#celebros_search_perpage, label[for="celebros_search_perpage"]').show().prop('readonly', false);
					jQuery('#celebros_search_query, label[for="celebros_search_query"]').css('fontWeight', 'normal');
					break;
				case "SortByField" :
					jQuery('.hidden-fields select, .hidden-fields label, .hidden-fields input').hide().prop('readonly', true);
					jQuery('#celebros_search_query').prop('readonly', true);
					jQuery('#celebros_product_fields, label[for="celebros_product_fields"], #celebros_product_sortdir, label[for="celebros_product_sortdir"]').show().prop('readonly', false);
					jQuery('#celebros_search_query, label[for="celebros_search_query"]').css('fontWeight', 'normal');
					break;
				case "SortByPrice" :
					jQuery('.hidden-fields select, .hidden-fields label, .hidden-fields input').hide().prop('readonly', true);
					jQuery('#celebros_search_query').prop('readonly', true);
					jQuery('#celebros_product_sortdir, label[for="celebros_product_sortdir"]').show().prop('readonly', false);
					jQuery('#celebros_search_query, label[for="celebros_search_query"]').css('fontWeight', 'normal');
					break;
				default :
					jQuery('.hidden-fields select, .hidden-fields label, .hidden-fields input').hide().prop('readonly', true);
					jQuery('#celebros_search_query').prop('readonly', true);
					jQuery('#celebros_search_query, label[for="celebros_search_query"]').css('fontWeight', 'normal');
			
			}	//end switch(operation)
		
		}	//end visibleFields(operation)
		
		
		
		jQuery('#celebros_operation').change(function() {
		
			var o = jQuery('#celebros_operation option:selected').val();
			visibleFields(o);
			
		});	//end jQuery('#celebros_operation').change(function()
		
		
		
		jQuery(function() {
		
			var o = jQuery('#celebros_operation option:selected').val();
			visibleFields(o);
		
		});	//end jQuery(function()
	</script>
	
	<?php else: 
	?>
	<?php $operations = array(
		'Search'	=> 'New Search'
	) ?>
	
	<form id="celebros_operation" method="POST" action="">
		<?php wp_nonce_field( 'performoperation', 'celebrostestpanel' ) ?>
		<div class="visible-fields">
			<label for="celebros_search_query" style="font-weight: 900">Search Query:</label>
			<input type="text" size="60" id="celebros_search_query" name="celebros_search_query" style="font-weight: 900" />
			<br/>
			<label for="celebros_operation">Operation:</label>
			<select readonly type="text" id="celebros_operation" name="celebros_operation">
			<?php foreach( $operations as $o=>$label ): 
			?>
				<option value="<?php echo $o ?>"><?php echo $label ?></option>
			<?php
			endforeach ?>
			</select>
			<br/>
		</div>
		<div class="hidden-fields">
		</div>
		<input type="submit" value="Operate" />
	</form>
	<?php 
	endif ?>
	<?php if( isset( $api->current_response ) ): 
	?>
	<h3>Current Response:</h3>
	<div class="api-response">
		<?php echo $api->current_response ?>
	</div>
	<?php
	endif ?>
	<?php if( isset( $api->results ) || isset( $results ) ):
	?>
	<h3>Results:</h3>
	<div class="api-results">
		 <?php foreach( $results->Products->Items as $product ): 
		 ?>
		 	<div class="product">
		 		<h4><?php echo $product->Field['sku']; ?></h4>
		 		<?php foreach( $product->Field as $field=>$value ): 
		 		?>
		 			<?php if( $field != "sku" && isset( $value ) && $value != '' ): 
		 			?>
		 				<?php if( $field == "link" ): 
		 				?>
		 				<div class="product-field">
		 					<b><?php echo $field ?>:</b>
		 					<br/> 
		 					<a href="<?php echo str_replace( 'tekserve.corrastage.com', 'shop.tekserve.com', $value ) ?>" target="_blank"><?php echo $value ?></a>
		 				</div>
		 				<?php 
		 				elseif( $field == "thumbnail" || $field == "image_link" || $field == "small_image" ): 
		 				?>
		 				<div class="product-field">
		 					<b><?php echo $field ?>:</b>
		 					<br/> 
		 					<a href="<?php echo str_replace( 'cdn.tekserve.corrastage.com', 'shop.tekserve.com', $value ) ?>" target="_blank"><img src="<?php echo str_replace( 'cdn.tekserve.corrastage.com', 'shop.tekserve.com', $value ) ?>" /><br/><?php echo $value ?></a>
		 				</div>
		 				<?php 
		 				else: 
		 				?>
		 				<div class="product-field">
		 					<b><?php echo $field ?>:</b>
		 					<br/> 
		 					<?php echo substr( $value, 0 , 90 ) ?>
		 					<?php echo ( strlen( $value ) > 90 ) ? '[...]' : '' ?>
		 				</div>
		 				<?php
		 				endif ?>
		 			<?php 
		 			endif ?>
		 		<?php 
		 		endforeach ?>
		 	</div>
		 	<br/>
		 <?php 
		 endforeach ?>
		<h3>raw:</h3>
		<?php print_r( $results ) ?>
	</div>
	<?php 
	endif ?>
	
	<?php

}	//end tekserve_celebros_test_panel_menu_page( $handle = NULL, $operation = NULL )