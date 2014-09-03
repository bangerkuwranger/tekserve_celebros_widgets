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
Class Celebros_Conversionpro_Model_Api_QwiserAnswers
{
	var $Count = 0;	//the number of products
	var $Items = array();	//indexer .
	
	Function Celebros_Conversionpro_Model_Api_QwiserAnswers($xml_Answers)
	{
		//if we got an array of QwiserAnswer
		if(is_array($xml_Answers))
		{
			$this->Items = $xml_Answers;
			$this->Count = count($xml_Answers);
		}
		//if we got a node of QwiserAnswers
		else
		{	
			if(is_object($xml_Answers))
			{	
				$xml_AnswersNodes = $xml_Answers->child_nodes();
				$xml_AnswersNodes = getDomElements($xml_AnswersNodes);
				$this->Count = count($xml_AnswersNodes);

				for ($i = 0 ; $i <= $this->Count - 1;$i++)
				{
					$AnswerNode = $xml_AnswersNodes[$i];
					$answers_answer = new Celebros_Conversionpro_Model_Api_QwiserAnswer($AnswerNode);
// 					$this->Items[$i] = Mage::getModel('conversionpro/Api_QwiserAnswer', $AnswerNode);
					$this->Items[$i] = $answers_answer;
				}
			}
		}
	}
	
	//Return Answer By Id.
	Function GetAnswerById($ID)
	{
		foreach ($this->Items as $Ans)
		{
			if($Ans->Id==$ID)
			{
				return $Ans;
			}
		}
	}
	
	//Gets a QwiserAnswers object of all answers in this collection that have the specified text 
	Function GetAnswersByText($Text)
	{
		$ansArray = array();
		foreach ($this->Items as $Ans)
		{
			if($Ans->Text = $Text)
			{
				$ansArray[] = $Ans;	
			}
		}
		$answers_answer_bytext = new Celebros_Conversionpro_Model_Api_QwiserAnswer($ansArray);
// 		return Mage::getModel('conversionpro/Api_QwiserAnswer', $ansArray);
		return $answers_answer_bytext;
	}
	
	//Gets a QwiserAnswers object of all answers in this collection that are of the specified type
	Function GetAnswersByType($Type)
	{
		$ansArray = array();
		foreach ($this->Items as $Ans)
		{
			if($Ans->Type = $Type)
			{
				$ansArray[] = $Ans;
			}
		}	
		$answers_answer_bytype = new Celebros_Conversionpro_Model_Api_QwiserAnswer($ansArray);
// 		return Mage::getModel('conversionpro/Api_QwiserAnswer', $ansArray);
		return $answers_answer_bytype;
	}
	
	//Sorts This QwiserAnswers collection with CompareTo method. 
	Function SortByAnswerText()
	{
		usort($this->Items,array("QwiserAnswers","CompareTo"));
	}
	
	Function CompareTo($a,$b)
	{
		$al = strtolower($a->Text);
       	$bl = strtolower($b->Text);
       	if ($al == $bl) {
           return 0;
       	}
      	 return ($al > $bl) ? +1 : -1;
		//return strcmp($a1,$b1);
	}
	

}
?>