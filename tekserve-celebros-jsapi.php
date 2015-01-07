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

// echo $results->Products->Items;
// var_dump($results->Products->Items);



foreach( $results->Products->Items as $product ): ?>
	<?php $url = str_replace( 'tekserve.corrastage.com', 'shop.tekserve.com', $product->Field['link'] ) ?>
	<?php $description = wp_strip_all_tags( $product->Field['description'] ) ?>
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
			<?php else: ?>
				<div class="tekserve-celebros-related-items-single-data-readmore">
					<span class="button">
						READ MORE
					</span>
				</div>
			<?php endif ?>
		</div>
	<?php endif ?>
	</a>
<?php 
endforeach;

echo '</div>';