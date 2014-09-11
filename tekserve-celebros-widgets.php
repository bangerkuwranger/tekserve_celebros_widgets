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

//global vars
define('QWISER_FILE', __FILE__);
define('QWISER_PATH', plugin_dir_path(__FILE__));
define('QWISER_URL', plugin_dir_url(__FILE__));

//define text domain
load_plugin_textdomain('tekserve_celebros_widgets');

//include api files
require_once(QWISER_PATH . "/qwiser_api/SalespersonSearchApi.php");
require_once(QWISER_PATH . "/qwiser_api/DomXMLPhp4ToPhp5.php");
require_once(QWISER_PATH . "/qwiser_api/SearchInformation.php");
require_once(QWISER_PATH . "/qwiser_api/SpecialCasesDetectedInThisSession.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserSearchResults.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserProducts.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserProduct.php");
require_once(QWISER_PATH . "/qwiser_api/SortingOptions.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserQuestions.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserQuestion.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserAnswers.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserAnswer.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserAnsweredAnswers.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserAnsweredAnswer.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserSearchPath.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserSearchPathEntry.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserSpellerInformation.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserConcepts.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserConcept.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserProductAnswers.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserProductAnswer.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserProductFields.php");
require_once(QWISER_PATH . "/qwiser_api/QwiserProductField.php");

//define new api obj instance and add to globals
$GLOBALS['QWISER'] = new Celebros_Conversionpro_Model_SalespersonSearchApi(__FILE__);

//include file to create additional post fields
require_once(QWISER_PATH . "tekserve-celebros-widget-fields.php");

//include file to create admin menu
require_once(QWISER_PATH . "tekserve-celebros-menu.php");

//include file to register widget class
require_once(QWISER_PATH . "tekserve-celebros-widget-class.php");