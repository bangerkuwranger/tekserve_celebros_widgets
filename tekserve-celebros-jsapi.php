<?php
//handles AJAX requests and returns values from the API

// include wp-load
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');

// Variables from $_GET
$pageSize = (isset($_GET['PageSize'])) ? intval( $_GET['PageSize'], 10 ) : 0;
$query = (isset($_GET['Query'])) ? $_GET['Query'] : 0;
$profile = (isset($_GET['Profile'])) ? $_GET['Profile'] : 0;

// Local Variables
$handle = false;

global $wpdb;
$api = $GLOBALS['QWISER'];

$results = $api->Search($query)->results;
$handle = $results->GetSearchHandle();
$results = $results = $api->ActivateProfile($handle, $profile)->results;
$handle = $results->GetSearchHandle();
$results = $api->ChangePageSize($handle, $pageSize)->results;
$handle = $results->GetSearchHandle();
$searchinfo = $results->SearchInformation;

echo '<div class="tekserve-celebros-related-items-single">';

foreach( $results->Products->Items as $product ): ?>
	<?php $url = str_replace( 'tekserve.corrastage.com', 'shop.tekserve.com', $product->Field['link'] ) ?>
	<?php $description = $product->Field['description'] ?>
	<?php $imgsrc = $product->Field['thumbnail'] ?>
	<?php $price = $product->Field['price'] ?>
	<?php if( ! empty( $imgsrc ) ): ?>
	<a class="item-with-image" href="<?php echo $url ?>" target="_blank">
		<div class="tekserve-celebros-related-items-single-image">
			<img src="<?php echo str_replace( 'cdn.tekserve.corrastage.com', 'shop.tekserve.com', $imgsrc ) ?>" />
		</div>
		<div class="tekserve-celebros-related-items-single-data">
			<div class="tekserve-celebros-related-items-single-data-title">
				<?php echo $product->Field['title'] ?>
			</div>
			<div class="tekserve-celebros-related-items-single-data-domain">
				<?php 
				$host = @parse_url($url, PHP_URL_HOST);
				if (!$host) {
					$host = $url;
				}
				echo $host;
				?>
			</div>
			<div class="tekserve-celebros-related-items-single-data-description">
				<?php echo substr( $description, 0 , 190 ) ?>
		 		<?php echo ( strlen( $description ) > 190 ) ? '[...]' : '' ?>
			</div>
			<?php if( ! empty( $price ) ): ?>
				<div class="tekserve-celebros-related-items-single-data-buy">
					<span class="price">
						$<?php echo round( $price, 2 ) ?>
					</span>
					<span class="button">
						BUY NOW
					</span>
				</div>
			<?php endif ?>
		</div>
	<?php else: ?>
	<a href="<?php echo $url ?>" target="_blank">
		<div class="tekserve-celebros-related-items-single-data">
			<div class="tekserve-celebros-related-items-single-data-title">
				<?php echo $product->Field['title'] ?>
			</div>
			<div class="tekserve-celebros-related-items-single-data-domain">
				<?php 
				$host = @parse_url($url, PHP_URL_HOST);
				if (!$host) {
					$host = $url;
				}
				echo $host;
				?>
			</div>
			<div class="tekserve-celebros-related-items-single-data-description">
				<?php echo substr( $description, 0 , 190 ) ?>
		 		<?php echo ( strlen( $description ) > 190 ) ? '[...]' : '' ?>
			</div>
			<?php if( ! empty( $price ) ): ?>
				<div class="tekserve-celebros-related-items-single-data-buy">
					<span class="price">
						$<?php echo round( $price, 2 ) ?>
					</span>
					<span class="button">
						BUY NOW
					</span>
				</div>
			<?php endif ?>
		</div>
	<?php endif ?>
	</a>
	<?php /* foreach( $product->Field as $field=>$value ): ?>
		<?php if( $field != "sku" && isset( $value ) && $value != '' ): ?>
			<?php if( $field == "link" ): ?>
			<div class="product-field">
				<b><?php echo $field ?>:</b>
				<br/> 
				<a href="<?php echo str_replace( 'tekserve.corrastage.com', 'shop.tekserve.com', $value ) ?>" target="_blank"><?php echo $value ?></a>
			</div>
			<?php elseif( $field == "thumbnail" || $field == "image_link" || $field == "small_image" ): ?>
			<div class="product-field">
				<b><?php echo $field ?>:</b>
				<br/> 
				<a href="<?php echo str_replace( 'cdn.tekserve.corrastage.com', 'shop.tekserve.com', $value ) ?>" target="_blank"><img src="<?php echo str_replace( 'cdn.tekserve.corrastage.com', 'shop.tekserve.com', $value ) ?>" /><br/><?php echo $value ?></a>
			</div>
			<?php else: ?>
			<div class="product-field">
				<b><?php echo $field ?>:</b>
				<br/> 
				<?php echo substr( $value, 0 , 90 ) ?>
				<?php echo ( strlen( $value ) > 90 ) ? '[...]' : '' ?>
			</div>
			<?php endif ?>
		<?php endif ?>
	<?php endforeach ?>
</div>
<br/>
<?php */ endforeach;

echo '<p>Page Size: ' . $pageSize . '</p>';
echo '<p>Query: ' . urldecode( $query ) . '</p>';
echo '<p>Profile: ' . $profile . '</p>';
echo '<p>Sorted By: ' . $searchinfo->SortingOptions->Method . '</p>';
echo '</div>';