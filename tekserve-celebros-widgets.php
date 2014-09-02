<?php
/*
Plugin Name: Tekserve Celebros Widgets
Plugin URI: https://github.com/bangerkuwranger/tekserve_celebros_widgets
Description: Retrieves related products/data from celebros based on current post title/keywords. API portions © Celebros.
Version: 0.0.1
Author: Chad A. Carino
Author URI: http://www.chadacarino.com
License: MIT
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

define('QWISER_FILE', __FILE__);
define('QWISER_PATH', plugin_dir_path(__FILE__));

require QWISER_PATH . '/qwiser_api/SalespersonSearchApi.php';

$GLOBALS['QWISER'] = new Celebros_Conversionpro_Model_SalespersonSearchApi(__FILE__);