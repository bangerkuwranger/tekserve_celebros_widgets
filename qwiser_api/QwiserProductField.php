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
class Celebros_Conversionpro_Model_Api_QwiserProductField 
{
	var $FieldType;
	var $FieldName;

	
	Function Celebros_Conversionpro_Model_Api_QwiserProductField($ProductFieldNode)
	{
		if(is_object($ProductFieldNode))
		{
			$this->FieldType = $ProductFieldNode->get_attribute("FieldType");
			$this->FieldName = $ProductFieldNode->get_attribute("Name");
		}
	}
}
?>