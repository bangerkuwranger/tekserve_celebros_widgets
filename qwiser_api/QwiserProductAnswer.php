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
class Celebros_Conversionpro_Model_Api_QwiserProductAnswer 
{
	var $Id;
	var $Name;
	var $QuestionId;
	var $Sku;
	
	Function Celebros_Conversionpro_Model_Api_QwiserProductAnswer($ProductAnswerNode)
	{
		if(is_object($ProductAnswerNode))
		{
			$this->Id = $ProductAnswerNode->get_attribute("Id");
			$this->Name = $ProductAnswerNode->get_attribute("Name");
			$this->QuestionId = $ProductAnswerNode->get_attribute("QuestionId");
			$this->Sku = $ProductAnswerNode->get_attribute("Sku");
		}
	}
}

?>