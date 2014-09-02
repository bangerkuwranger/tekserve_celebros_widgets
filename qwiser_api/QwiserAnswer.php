<?php
/**
 * Celebros Qwiser - Magento Extension
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
Class Celebros_Conversionpro_Model_Api_QwiserAnswer
{
	var $Id;
	var $ImageHeight;
	var $ImageSku;
	var $ImageUrl;
	var $ImageWidth;
	var $ProductCount;
	var $Text;
	var $Type;
	var $DynamicProperties;
	
	Function Celebros_Conversionpro_Model_Api_QwiserAnswer($AnswerNode)
	{
		if(is_object($AnswerNode))
		{
			$this->Id = $AnswerNode->get_attribute("Id");
			$this->ImageHeight = $AnswerNode->get_attribute("ImageHeight");
			$this->ImageSku = $AnswerNode->get_attribute("ImageSku");
			$this->ImageUrl = $AnswerNode->get_attribute("ImageUrl");
			$this->ImageWidth = $AnswerNode->get_attribute("ImageWidth");
			$this->ProductCount = $AnswerNode->get_attribute("ProductCount");
			$this->Text = $AnswerNode->get_attribute("Text");
			$this->Type = $AnswerNode->get_attribute("Type");
			
			if ($this->Type=='Price') {
				$processedText=str_replace(' ','',$this->Text);
				$rangeDividerPos=strpos($processedText,'-');
				if ($rangeDividerPos) {
					//$0 - $4.172444e+07
					$currencySign=substr($processedText,$rangeDividerPos+1,1);
					$processedText=str_replace($currencySign,'',$this->Text);
					
					$minPrice=substr($processedText,0,$rangeDividerPos);
					$maxPrice=substr($processedText,$rangeDividerPos+1);
				
					$this->Text=$currencySign.$minPrice.' - '.$currencySign.$maxPrice;
					
				}
				elseif (($underTextPos=stripos($processedText,'under'))!==FALSE) {
					//under $70000
					$currencySign=substr($processedText,5,1);
					$processedText=str_replace($currencySign,'',$this->Text);
					
					$underPrice=substr($processedText,5);
					
					$this->Text='under '.$currencySign.$underPrice;
				}
				elseif (($overTextPos=stripos($processedText,'over'))!==FALSE) {
					//over $70000
					$currencySign=substr($processedText,4,1);
					$processedText=str_replace($currencySign,'',$this->Text);
					
					$overPrice=substr($processedText,4);
					
					$this->Text='over '.$currencySign.$overPrice;
				}
				elseif (($aboveTextPos=stripos($processedText,'andabove'))!==FALSE) {
					//$800.00 and above
					$currencySign=substr($processedText,0,1);
					$processedText=str_replace($currencySign,'',$processedText);
					
					$abovePrice=substr($processedText,0,$aboveTextPos-1);
					
					$this->Text=$currencySign.$abovePrice.' and above';
				}
			}
			$this->DynamicProperties = GetQwiserSimpleStringDictionary(current($AnswerNode->get_elements_by_tagname("DynamicProperties")));
		}
	}
}
?>