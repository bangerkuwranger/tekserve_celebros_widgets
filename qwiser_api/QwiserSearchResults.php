<?php
/**
 * Celebros Qwiser - WordPress
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
class Celebros_Conversionpro_Model_Api_QwiserSearchResults
{
	var $xml_root;
	var $QwiserSearchResults;
	var $QwiserErrorOccurred;
	var $QwiserErrorMessage;
	var $SearchInformation;
	var $Questions;
	var $SearchPath;
	var $Products;
	var $QueryConcepts;
	var $SpellerInformation ;
	var $RelatedSearches;
	var $SpecialCasesDetectedInThisSearch;
	
	Function Celebros_Conversionpro_Model_Api_QwiserSearchResults($root)
	{
		$this->xml_root = $root;
		$this->QwiserSearchResults = current($this->xml_root->get_elements_by_tagname("QwiserSearchResults"));
		$this->QwiserErrorOccurred = (bool)$this->xml_root->get_attribute("ErrorOccurred");
		$this->QwiserErrorMessage = current($this->xml_root->get_elements_by_tagname("QwiserError"));
		$search_results_search_information = new Celebros_Conversionpro_Model_Api_SearchInformation(current($this->xml_root->get_elements_by_tagname("SearchInformation")));
// 		$this->SearchInformation = Mage::getModel('conversionpro/Api_SearchInformation', current($this->xml_root->get_elements_by_tagname("SearchInformation")));
		$this->SearchInformation = $search_results_search_information;
		$search_results_questions = new Celebros_Conversionpro_Model_Api_QwiserQuestions(current($this->xml_root->get_elements_by_tagname("Questions")));
// 		$this->Questions =	Mage::getModel('conversionpro/Api_QwiserQuestions', current($this->xml_root->get_elements_by_tagname("Questions")));
		$this->Questions = $search_results_questions;
		$search_results_search_path = new Celebros_Conversionpro_Model_Api_QwiserSearchPath(current($this->xml_root->get_elements_by_tagname("SearchPath")));
// 		$this->SearchPath = Mage::getModel('conversionpro/Api_QwiserSearchPath', current($this->xml_root->get_elements_by_tagname("SearchPath")));
		$this->SearchPath = $search_results_search_path;
		$search_results_products = new Celebros_Conversionpro_Model_Api_QwiserProducts(current($this->xml_root->get_elements_by_tagname("Products")));
// 		$this->Products = Mage::getModel('conversionpro/Api_QwiserProducts', current($this->xml_root->get_elements_by_tagname("Products")));
		$this->Products = $search_results_products;
		$search_results_concepts = new Celebros_Conversionpro_Model_Api_QwiserConcepts(current($this->xml_root->get_elements_by_tagname("QueryConcepts")));
// 		$this->QueryConcepts = Mage::getModel('conversionpro/Api_QwiserConcepts', current($this->xml_root->get_elements_by_tagname("QueryConcepts")));
		$this->QueryConcepts = $search_results_concepts;
		$search_results_speller_information = new Celebros_Conversionpro_Model_Api_QwiserSpellerInformation(current($this->xml_root->get_elements_by_tagname("SpellerInformation")));
// 		$this->SpellerInformation = Mage::getModel('conversionpro/Api_QwiserSpellerInformation', current($this->xml_root->get_elements_by_tagname("SpellerInformation")));
		$this->SpellerInformation = $search_results_speller_information;
		$this->RelatedSearches  = GetQwiserSimpleStringCollection(current($this->xml_root->get_elements_by_tagname("RelatedSearches")));
		$this->SpecialCasesDetectedInThisSearch  = current($this->xml_root->get_elements_by_tagname("SpecialCasesDetectedInThisSearch"));
	}
	
	Function GetErrorOccurred(){
		return $this->QwiserErrorOccurred;
	}
	
	Function GetErrorMessage(){
		if ($this->GetErrorOccurred()){
			return $this->QwiserErrorMessage->get_attribute("ErrorMessage");
		}
	}
	
	Function GetExactMatchFound()
	{
		return $this->QwiserSearchResults->get_attribute("ExactMatchFound");
	}
	
	Function GetLogHandle()
	{
		return $this->QwiserSearchResults->get_attribute("LogHandle");
	}
	
	Function GetSearchHandle()
	{
		return $this->QwiserSearchResults->get_attribute("SearchHandle");
	}
	
	Function GetMaxMatchClassFound()
	{
			return $this->QwiserSearchResults->get_attribute("MaxMatchClassFound");
	}
	
	Function GetMinMatchClassFound()
	{
			return $this->QwiserSearchResults->get_attribute("MinMatchClassFound");
	}	
	
	Function GetRecommendedMessage()
	{
			return $this->QwiserSearchResults->get_attribute("RecommendedMessage");
	}
	
	Function GetRedirectionUrl()
	{
			return $this->QwiserSearchResults->get_attribute("RedirectionUrl");
	}
	
	Function GetRelevantProductsCount()
	{
			return $this->QwiserSearchResults->get_attribute("RelevantProductsCount");
	}
	
	Function GetSearchDataVersion()
	{
			return $this->QwiserSearchResults->get_attribute("SearchDataVersion");
	}
	
	Function GetSearchEngineTimeDuration()
	{
			return $this->QwiserSearchResults->get_attribute("SearchEngineTimeDuration");
	}
	
	Function GetSearchTimeDuration()
	{
			return $this->QwiserSearchResults->get_attribute("SearchTimeDuration");
	}
	
	Function GetSearchStatus()
	{
		return $this->QwiserSearchResults->get_attribute("SearchStatus");
	}
	
	/*Function GetLogHandle()
	{
	  return $this->QwiserSearchResults->get_attribute("LogHandle");
	}*/
		
}


?>