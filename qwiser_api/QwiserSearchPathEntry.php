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
class Celebros_Conversionpro_Model_Api_QwiserSearchPathEntry 
{
	var $AnswerIndex;
	var $Answers;
	var $QuestionId;
	
	Function Celebros_Conversionpro_Model_Api_QwiserSearchPathEntry($EntryNode)
	{
		if(is_object($EntryNode))
		{
			$this->AnswerIndex = $EntryNode->get_attribute("AnswerIndex");
			$this->QuestionId = $EntryNode->get_attribute("QuestionID");
			$search_path_entry_answers = new Celebros_Conversionpro_Model_Api_QwiserAnswers(current(getDomElements($EntryNode->child_nodes())));
// 			$this->Answers = Mage::getModel('conversionpro/Api_QwiserAnswers', current(getDomElements($EntryNode->child_nodes())));
			$this->Answers = $search_path_entry_answers;
		}
	}
}
?>