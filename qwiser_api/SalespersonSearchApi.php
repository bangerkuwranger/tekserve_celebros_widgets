<?php
/**
 * Celebros Conversion Pro - WordPress
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish correct extension functionality.
 * If you wish to customize it, please contact Celebros.
 *
 * @category    Celebros
 * @package     Celebros_Conversionpro
 *
 */
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."SearchInformation.php");
//*require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserSearchResults.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserProducts.php");
//*require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserProduct.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."SortingOptions.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserQuestions.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserQuestion.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserAnswers.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserAnswer.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserSearchPath.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserSearchPathEntry.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserSpellerInformation.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserConcepts.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserConcept.php");
//*require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserProductAnswers.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserProductAnswer.php");
//*require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserProductFields.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."QwiserProductField.php");
//require_once(dirname(dirname(__FILE__)).DS."Model".DS."Api".DS."domxml-php4-to-php5.php");

if (!class_exists('Celebros_Conversionpro_Model_SalespersonSearchApi')) {



class Celebros_Conversionpro_Model_SalespersonSearchApi
{

		// settings array
	protected $option_name = 'tekserve_celebros';

	// Default values
	protected $option_data = array(
		'port'	=> '6035',
		'host'	=> 'tekserve-search.celebros.com',
		'key'	=> 'tekserve'
	);
    
    protected $CommunicationPort; //The name of the comm port to use for access to the search server.
    protected $HostName;  //The name of the search server to connect to.
    protected $SiteKey;   //the api site key.
    protected $LastOperationErrorMessage; //the last operation error message.
    protected $LastOperationSucceeded; //return true if the last operation ended successfully.
    protected $WebService;    //Search WebService full uri.
    
    public $results;
    public $current_response;
    
    /**
     * Init resource model
     *
     */
    protected function _construct()
    {
    	register_activation_hook(QWISER_FILE, array($this, 'activate'));
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action('admin_menu', array($this, 'add_page'));
		add_action( 'plugins_loaded', array( $this, 'setupAPI' ) );
    }
    
    public function setupAPI() {
    	$options = get_option($this->option_name);
    	if ($options['host'] != '' && $options['port'] != '' && $options['key'] != ''){
            $this->HostName = $options['host'];
            if (preg_match('/http:\/\//',$this->HostName)){
                $this->HostName = preg_replace('/http::\/\//','', $this->HostName);
            }
            $this->CommunicationPort = $options['port'];
            $this->SiteKey = $options['key'];
            $this->WebService ="http://".$this->HostName.":".$this->CommunicationPort."/";
            $this->LastOperationSucceeded = true;
		}
    }
    
    public function admin_init() {
		register_setting('tekserve_celebros_options', $this->option_name, array($this, 'validate'));
	}
	
	public function validate($input) {

		$valid = array();
		$valid['port'] = sanitize_text_field($input['port']);
		$valid['host'] = sanitize_text_field($input['host']);
		$valid['key'] = sanitize_text_field($input['key']);

		if (strlen($valid['url_todo']) == 0) {
			add_settings_error(
					'port',                 	    // Setting title
					'port_texterror',   	         // Error ID
					'Please enter a valid port',     // Error message
					'error'                         // Type of message
			);

			// Set it to the default value
			$valid['port'] = $this->option_data['port'];
		}
		
		if (strlen($valid['host']) == 0) {
			add_settings_error(
					'host',
					'host_texterror',
					'Please enter a valid host address',
					'error'
			);

			$valid['host'] = $this->option_data['host'];
		}
		
		if (strlen($valid['key']) == 0) {
			add_settings_error(
					'key',
					'key_texterror',
					'Please enter a valid key',
					'error'
			);

			$valid['key'] = $this->option_data['key'];
		}

		return $valid;
	}
	
	// Add entry in the settings menu
	public function add_page() {
		add_options_page('Celebros Options', 'Celebros Options', 'manage_options', 'tekserve_celebros_options', array($this, 'options_do_page'));
	}
	
	// Output the options page
	public function options_do_page() {
		$options = get_option($this->option_name);
		?>
		<div class="wrap">
			<h2>Celebros API Settings</h2>
			<form method="post" action="options.php">
				<?php settings_fields('tekserve_celebros_options'); ?>
				<table class="form-table">
					<tr valign="top"><th scope="row">Host:</th>
						<td><input type="text" name="<?php echo $this->option_name?>[host]" value="<?php echo $options['host']; ?>" /></td>
					</tr>
					<tr valign="top"><th scope="row">Title:</th>
						<td><input type="text" name="<?php echo $this->option_name?>[port]" value="<?php echo $options['port']; ?>" /></td>
					</tr>
					<tr valign="top"><th scope="row">Key:</th>
						<td><input type="text" name="<?php echo $this->option_name?>[key]" value="<?php echo $options['key']; ?>" /></td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				</p>
			</form>
		</div>
	<?php
	}
	
	public function activate() {
		update_option($this->option_name, $this->option_data);
	}

    //Activate serach Profile
    Function ActivateProfile($SearchHandle,$SearchProfile)
    {
        $SearchProfile = urlencode($SearchProfile);
        $RequestUrl = "ActivateProfile?SearchHandle=".$SearchHandle."&SearchProfile=".$SearchProfile."&Sitekey=".$this->SiteKey;
        $this->results =  $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Answer Question
    Function AnswerQuestion($SearchHandle,$AnswerId,$EffectOnSearchPath)
    {
        $RequestUrl = "AnswerQuestion?SearchHandle=".$SearchHandle."&answerId=".$AnswerId."&EffectOnSearchPath=".$EffectOnSearchPath."&Sitekey=".$this->SiteKey;
        $this->results =  $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }
    
    //Answer Questions
    Function AnswerQuestions($SearchHandle,$AnswerIds,$EffectOnSearchPath)
    {
        $RequestUrl = "AnswerQuestions?SearchHandle=".$SearchHandle."&answerIds=".$AnswerIds."&EffectOnSearchPath=".$EffectOnSearchPath."&Sitekey=".$this->SiteKey;
        $this->results =  $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }   

    //Change Number of Products in Page
    Function ChangePageSize($SearchHandle,$PageSize)
    {
        $RequestUrl = "ChangePageSize?SearchHandle=".$SearchHandle."&pageSize=".$PageSize."&Sitekey=".$this->SiteKey;
        $this->results =  $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Change the search default price
    Function ChangePriceColumn($SearchHandle,$PriceColumn)
    {
        $RequestUrl = "ChangePriceColumn?SearchHandle=".$SearchHandle."&PriceColumn=".$PriceColumn."&Sitekey=".$this->SiteKey;
        $this->results =  $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Deactivate Search Profile
    Function DeactivateProfile($SearchHandle)
    {
        $RequestUrl = "DeactivateProfile?SearchHandle=".$SearchHandle."&Sitekey=".$this->SiteKey;
        $this->results =  $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Moves to the first page of the results
    Function FirstPage($SearchHandle)
    {
        $RequestUrl = "FirstPage?SearchHandle=".$SearchHandle."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Forces the BQF to allow the specified question to appear first
    Function ForceQuestionAsFirst($SearchHandle,$QuestionId)
    {
        $RequestUrl = "ForceQuestionAsFirst?SearchHandle=".$SearchHandle."&QuestionId=".$QuestionId."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Get alll the product fields
    Function GetAllProductFields()
    {
        $RequestUrl = "GetAllProductFields?Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserProductFields");
        return $this;
    }

    //Return all the questions
    Function GetAllQuestions()
    {
		$RequestUrl = "GetAllQuestions?Sitekey=" . $this->SiteKey;
		$RequestUrl .= "&Searchprofile=SiteDefault";
		$this->results = $this->GetResult($RequestUrl,"QwiserQuestions");
// 		if ($cacheEnabled) {
// 			$cache->save(json_encode($this->results), 'conversionpro_getallquestions_' . $this->SiteKey, array('CONVERSIONPRO_CACHE'), $lifetime);
// 		}

        return $this;
    }

    //Return all search profiles
    Function GetAllSearchProfiles()
    {
        $RequestUrl = "GetAllSearchProfiles?Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSimpleStringCollection");
        return $this;
    }

    //Gets the results for the specified search handle
    Function GetCustomResults($SearchHandle,$bNewSearch,$PreviousSearchHandle)
    {
        $RequestUrl = "GetCustomResults?SearchHandle=".$SearchHandle."&NewSearch=".$bNewSearch."&PreviousSearchHandle=".$PreviousSearchHandle."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Gets Engine Status
    Function GetEngineStatus()
    {
        $RequestUrl = "GetEngineStatus?Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"String");
        return $this;
    }

    //Gets all the answers that a product exists in
    Function GetProductAnswers($Sku)
    {
        $Sku = urlencode($Sku);
        $RequestUrl = "GetProductAnswers?Sku=".$Sku."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserProductAnswers");
        return $this;   
    }

    //Gets the full path to the best answer for this product under the selected question for the �View All� feature (in the SPD).
    Function GetProductSearchPath($Sku)
    {
        $Sku = urlencode($Sku);
        $RequestUrl = "GetProductSearchPath?Sku=".$Sku."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchPath");
        return $this;
    }

    //Returns the answers for a specific question
    Function GetQuestionAnswers($QuestionId)
    {
        $RequestUrl = "GetQuestionAnswers?QuestionId=".$QuestionId."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserAnswers");
        return $this;
    }

    //return all the question ampped to the given search profile
    Function GetSearchProfileQuestions($SearchProfile)
    {
        $SearchProfile = urlencode($SearchProfile);
        $RequestUrl = "GetSearchProfileQuestions?SearchProfile=".$SearchProfile."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserQuestions");
        return $this;
    }

    //Gets all the answers a collection of products exist in.
    Function GetSeveralProductsAnswers($Skus)
    {
        $RequestUrl = "GetSeveralProductsAnswers?Skus=".$Skus."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserProductAnswers");
        return $this;
    }

    //Return the LastPage.
    Function LastPage($SearchHandle)
    {
        $RequestUrl = "LastPage?SearchHandle=".$SearchHandle."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Moves to the specified page of the results
    Function MoveToPage($SearchHandle,$Page)
    {
        $RequestUrl = "MoveToPage?SearchHandle=".$SearchHandle."&Page=".$Page."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Moves to the previous page of the results
    Function PreviousPage($SearchHandle)
    {
        $RequestUrl = "PreviousPage?SearchHandle=".$SearchHandle."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Moves to the next page of the results
    Function NextPage($SearchHandle)
    {
        $RequestUrl = "NextPage?SearchHandle=".$SearchHandle."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Removes the specified answer from the list of answered answers in this session.
    Function RemoveAnswer($SearchHandle,$AnswerId)
    {
        $RequestUrl = "RemoveAnswer?SearchHandle=".$SearchHandle."&AnswerId=".$AnswerId."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Removes the specified answers from the list of answered answers in this session.
    Function RemoveAnswerAt($SearchHandle,$AnswerIndex)
    {
        $RequestUrl = "RemoveAnswerAt?SearchHandle=".$SearchHandle."&AnswerIndex=".$AnswerIndex."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Removes the specified answers from the list of answered answers in this session.
    Function RemoveAnswers($SearchHandle,$AnswerIds)
    {
        $RequestUrl = "RemoveAnswers?SearchHandle=".$SearchHandle."&AnswerIds=".$AnswerIds."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Remove the all the answer from the search information form the given index
    Function RemoveAnswersFrom($SearchHandle,$StartIndex)
    {
        $RequestUrl = "RemoveAnswersFrom?SearchHandle=".$SearchHandle."&StartIndex=".$StartIndex."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        
        return $this;
    }

    //Marks a product as out of stock.
    Function RemoveProductFromStock($Sku)
    {
        $Sku = urlencode($Sku);
        $RequestUrl = "RemoveProductFromStock?Sku=".$Sku."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"String");
        
        return $this;
    }

    //Marks a product as in stock.
    Function RestoreProductToStock($Sku)
    {
        $Sku = urlencode($Sku);
        $RequestUrl = "RestoreProductToStock?Sku=".$Sku."&Sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"String");
        return $this;
    }

    //Gets the results for the specified search term.
    Function Search($Query)
    {
        $Query = urlencode($Query);
        $RequestUrl = "search?Query=".$Query."&sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Gets the results for the specified search term under the specified search profile and the answer which Id was specified.
    Function SearchAdvance($Query,$SearchProfile,$AnswerId,$EffectOnSearchPath,$PriceColumn,$PageSize,$Sortingfield,$bNumericsort,$bAscending)
    {
        $Query = urlencode($Query);
        $SearchProfile = urlencode($SearchProfile);
        $Sortingfield = urlencode($Sortingfield);
        //$PriceColumn = urlencode($PriceColumn);
        $PriceColumn = "";
        $RequestUrl = "SearchAdvance?Query=".$Query."&SearchProfile=".$SearchProfile."&AnswerId=".$AnswerId."&EffectOnSearchPath=".$EffectOnSearchPath."&PriceColumn=".$PriceColumn."&PageSize=".$PageSize."&Sortingfield=".$Sortingfield."&Numericsort=".$bNumericsort."&Ascending=".$bAscending."&sitekey=".$this->SiteKey;
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //set the general params of the api
    Function SetQwiserSearchAPI($siteKey ,$serverName ,$port )
    {
        $this->SiteKey = $siteKey;
        $this->HostName = $serverName;
        $this->CommunicationPort = $port;
    }

    //Changes the sorting of the results to display products by the value of the specified field, and whether to perform a numeric sort on that field, in the specified sorting direction.
    Function SortByField($SearchHandle,$FieldName,$bNumericSort,$bAscending)
    {
        $FieldName = urlencode($FieldName);
        $RequestUrl = "SortByField?SearchHandle=".$SearchHandle."&FieldName=".$FieldName."&NumericSort=".$bNumericSort."&Ascending=".$bAscending."&sitekey=".$this->SiteKey;
        
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Changes the sorting of the results to display products by their price in the specified sorting direction
    Function SortByPrice($SearchHandle,$bAscending)
    {
        $RequestUrl = "SortByPrice?SearchHandle=".$SearchHandle."&Ascending=".$bAscending."&sitekey=".$this->SiteKey;
        
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    //Changes the sorting of the results to display products by relevancy in descending order.
    Function SortByRelevancy($SearchHandle)
    {
        $RequestUrl = "SortByRelevancy?SearchHandle=".$SearchHandle."&Sitekey=".$this->SiteKey;
        
        $this->results = $this->GetResult($RequestUrl,"QwiserSearchResults");
        return $this;
    }

    Function get_data($url)
    {
        //var_dump($url); exit();
        $data = null;
        try {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);

            curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
            curl_setopt($ch, CURLOPT_POST, 1);

            $response= curl_exec($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $data = $this->parse_response($response, $header_size);
            $this->current_data = $response;

            $curlError = curl_error($ch);
            curl_close($ch);
            
            //If we've enabled monitoring on Conversionpro's activity, we'll register to the db whether the curl request was 
            // successful, and in case of a few subsequent failures, we'll disable the plugin completely.
//             $helper = Mage::helper('conversionpro');
//             if ($helper->isMonitoringEnabled() && $helper->isConnectivityMonitoringEnabled()) {
//                 $result = (empty($curlError)) ? true : false;
//                 $helper->pushResultToMonitor('connection', $result);
//                 
//                 $helper->checkConversionproPulse();
//             }
            
            if(!empty($curlError)) {
               return new WP_Error( 'curlError', 'get_data: ' . $curlError .' Request Url: ' . $url );
            }
        }
        catch (Exception $e) {
            new WP_Error( 'curlExcept', $e->getMessage() );
        }       
        return $data;
    }
    
    Function parse_response($response, $header_size) {
        $header = substr($response, 0, $header_size);
        $data = substr($response, $header_size);

        return $data;
    }
    
    //Gets the xml file, parse it and chack for Errors.
    Function GetResult($RequestUrl,$ReturnValue)
    {
        if(!$this->WebService) {
           return new WP_Error( 'conversionpronotset', 'Configuration error! Check Celebros admin settings.');
        }
        
        //print $this->WebService.$RequestUrl;
        //get xml file from url.
        //echo $this->WebService.$RequestUrl; //exit();
        //$xml_file = file_get_contents($this->WebService.$RequestUrl);
        $xml_file = $this->get_data($this->WebService.$RequestUrl);
    
        //file_get_contents return value should be true.
        if(!$xml_file)
        {
            $this->LastOperationSucceeded = false;
            $this->LastOperationErrorMessage = "Error : could not GET XML input, there might be a problem with the connection";
            return;
        }

        //Parse the xml file with php4 Dom parser.
        $parser = new Celebros_Conversionpro_Model_Api_DomXMLPhp4ToPhp5(__FILE__);
        $xml_doc = $parser->domxml_open_mem($xml_file);

        //domxml_open_mem should Return object.
        if ((!is_object($xml_doc)) && !$xml_doc)
        {
            $this->LastOperationSucceeded = false;
            $this->LastOperationErrorMessage = "Error : could not parse XML input, there might be a problem with the connection";
            return ;
        }

        //Get the Root Element.
        $xml_root=$xml_doc->document_element();

        //Check the ErrorOccured node in the xml file
//      if(!$this->CheckForAPIErrors($xml_root))
//      {
//          return ;
//      }
        
//  Mage::log($RequestUrl);
//  Mage::log($xml_file);
        return $this->GetReturnValue($xml_root,$ReturnValue);
    }

    //return value by xml type
    function GetReturnValue($xml_root,$ReturnValue)
    {
    
    return "not yet";
//         switch ($ReturnValue)
//         {
//             case "QwiserSearchResults":
//                 return (new Celebros_Conversionpro_Model_Api_QwiserSearchResults($xml_root));
//                 break;
//             case "String":
//                 return $this->SimpleStringParser($xml_root);
//                 break;
//             case "QwiserQuestions":
//                 return (new Celebros_Conversionpro_Model_Api_QwiserQuestions(current($xml_root->get_elements_by_tagname("Questions"))));
//                 break;
//             case "QwiserProductAnswers":
//                 return (new Celebros_Conversionpro_Model_Api_QwiserProductAnswers(current($xml_root->get_elements_by_tagname("ProductAnswers"))));
//                 break;
//             case "QwiserProductFields":
//                 return (new Celebros_Conversionpro_Model_Api_QwiserProductFields(current($xml_root->get_elements_by_tagname("ProductFields"))));
//                 break;
//             case "QwiserSearchPath":
//                 return (new Celebros_Conversionpro_Model_Api_QwiserSearchPath(current($xml_root->get_elements_by_tagname("SearchPath"))));
//                 break;
//             case "QwiserAnswers":
//                 return (new Celebros_Conversionpro_Model_Api_QwiserAnswers(current($xml_root->get_elements_by_tagname("Answers"))));
//                 break;
//             case "QwiserSimpleStringCollection":
//                 return GetQwiserSimpleStringCollection(current($xml_root->get_elements_by_tagname("QwiserSimpleStringCollection")));
//                 break;
//         }
    }

    //Checks the error node
    function CheckForAPIErrors($xml_root)
    {

        $ErrorNode = current($xml_root->get_elements_by_tagname("LastError"));
        if(is_object($ErrorNode))
        {
            $MethodName = $ErrorNode->get_attribute("MethodName");
            if($MethodName=="")
            return true;
            $ErrorMessage = $ErrorNode->get_attribute("ErrorMessage");
            $this->LastOperationErrorMessage = "Error: MethodName=".$MethodName." ErrorMessage=".$ErrorMessage;

            $this->LastOperationSucceeded = false;

        }
        else {
            $this->LastOperationErrorMessage = "Error: ".$xml_root->get_content();

        }
            
        return false;
            
    }

    //returns the "ReturnValue" node as string
    function SimpleStringParser($xml_root)
    {
        $StringValue = current($xml_root->get_elements_by_tagname("ReturnValue"));
        return $StringValue->get_content();
    }
    
    ///////////////////////////////////////////////////////////////////////////////
    
    /**
     * Retrieve minimum query length
     *
     * @deprecated after 1.3.2.3 use getMinQueryLength() instead
     * @return int
     */
    public function getMinQueryLenght()
    {
//         return Mage::getStoreConfig(self::XML_PATH_MIN_QUERY_LENGTH, $this->getStoreId());
		return 3;
    }

    /**
     * Retrieve minimum query length
     *
     * @return int
     */
    public function getMinQueryLength(){
        return $this->getMinQueryLenght();
    }

    /**
     * Retrieve maximum query length
     *
     * @deprecated after 1.3.2.3 use getMaxQueryLength() instead
     * @return int
     */
    public function getMaxQueryLenght()
    {
//         return Mage::getStoreConfig(self::XML_PATH_MAX_QUERY_LENGTH, $this->getStoreId());
		return 140;
    }

    /**
     * Retrieve maximum query length
     *
     * @return int
     */
    public function getMaxQueryLength()
    {
        return $this->getMaxQueryLenght();
    }

    /**
     * Retrieve maximum query words for like search
     *
     * @return int
     */
    public function getMaxQueryWords()
    {
//         return Mage::getStoreConfig(self::XML_PATH_MAX_QUERY_WORDS, $this->getStoreId());
			return 30;
    }
}

} // end if (!class_exists('Celebros_Conversionpro_Model_SalespersonSearchApi'))

//Global function: Returns Array of strings from Array of nodes contents.
function GetQwiserSimpleStringCollection ($xml_node)
{
    $xml_nodes = $xml_node->child_nodes();
    $xml_nodes = getDomElements($xml_nodes);
    $arr = array();
    foreach($xml_nodes as $node)
    {
        $arr[] = $node->get_content();
    }
    return $arr;
}

//Global function: Returns hash of value .
function GetQwiserSimpleStringDictionary($xml_node)
{
    $xml_nodes = $xml_node->child_nodes();
    $xml_nodes = getDomElements($xml_nodes);
    $arr = array();
    foreach($xml_nodes as $node)
    {
        $arr[$node->get_attribute("name")] = $node->get_attribute("value");
    }
    return $arr;
}

//Global function: Returns Array of only DomElments
function getDomElements($element)
{
    $p=0;
    $new_element = array();
    foreach ($element as $value)
    {
        if($value->node_type()==1)
        {
            $new_element[$p]=$value;
            $p++;
        }
    }
    return $new_element;
}