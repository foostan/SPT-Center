<?php

namespace OSPT\TestBundle\Resources\lib;

/**
 * OSPT\TestBundle\Resources\lib\OSPTController
 */
class OSPTController
{
	/******************************************
	 * Constants 
	 *****************************************/

/*
	const SUCCESS = 0;
	const ERROR = 1;
	const STOP = 2;
*/

	/******************************************
	 * Properties
	 *****************************************/

	/**
	 * @var array $variables
	 */
	private $variables = array();
	
	/**
	 * @var array $nodeStack
	 */
	private $nodeStack = array();

	/******************************************
	 * Methods about Properties
	 *****************************************/

	/**
	 * Set variables
	 * 
	 * @param array $variables
	 */
	public function setVariables($variables)
	{
		$this->variables = $variables;
	}

	/**
	 * Get variables
	 *
	 * @return array
	 */
	public function getVariables()
	{
		return $this->variables;
	}
	
	/**
	 * Set nodeStack 
	 * 
	 * @param array $nodeStack
	 */
	public function setNodeStack($nodeStack)
	{
		$this->nodeStack = $nodeStack;
	}

	/**
	 * Set NodeStack from DOMRootNode
	 *
	 * @param DOMNode $rootNode
	 * @return boolean 
	*/
	public function setNodesToNodeStack($rootNode)
	{
		$node = $rootNode->lastChild;
		while( $node ){
			array_unshift($this->nodeStack, $node);		
			$node = $node->previousSibling;	
		}

		return true;
	}

	/**
	 * Get nodeStack
	 *
	 * @return array
	 */
	public function getNodeStack()
	{
		return $this->nodeStack;
	}
	
	/**
	 * success
	 *
	 * @param mixed $successValue
	 * @return array Result
	 */
	private function success($successValue)
	{
		return array(
			'successFlag' => true,
			'errorFlag' => false,
			'stopFlag' => false,
			'value' => $successValue,
			'message' => '',
			'nodeId' => ''
		);
	}

	/**
	 * error
	 *
	 * @param string errorMessage, string errorNodeId
	 * @return boolean false
	 */
	private function error($errorMessage, $errorNodeId)
	{
		return array(
			'successFlag' => false,
			'errorFlag' => true,
			'stopFlag' => false,
			'value' => '',
			'message' => $errorMessage,
			'nodeId' => $errorNodeId
		);
	}

	/**
	 * stop
	 *
	 * @param string $stopNodeId
	 * @return boolean true
	 */
	private function stop($stopNodeId,$returnValues)
	{
		return array(
			'successFlag' => false,
			'errorFlag' => false,
			'stopFlag' => true,
			'value' => $returnValues,
			'message' => '',
			'nodeId' => $stopNodeId
		);
	}
	

	/******************************************
	 * Methods 
	 *****************************************/

	/**
	 * Constractor
	 */
	public function OSPTController()
	{
		$this->variables = array();
		$this->nodeStack = array();
	}

	/**
	 * Validate OSPTController
	 *
	 * @param DOMNode $node
	 * @return array $validatedList
	 */
	function validate($node)
	{
		$validatedList = array();

		while ($node){
			if( $node->nodeName == '#comment'){
				$node->parentNode->removeChild($node);
			}else{

				/*
					TODO: validate parameter
				*/

				array_push($validatedList, $this->validate($node->firstChild));
			}
			$node = $node->nextSibling;
		}

		return $validatedList;
	}

	/**
	 * Run OSPT Controller
	 *
	 * @return mixed Result
	*/
	function run()
	{
		while( $node = array_shift($this->nodeStack) ){
			$result = $this->parseNode($node);
			if(! $result['successFlag'] ){ return $result; }
		}
		return $this->success('');
	}

	/**
	 * Parse Node
	 *
	 * @param DOMnode
	 * @return mixed Result 
	*/
	function parseNode($node)
	{
		// debug { 
		$id = $node->getAttribute('id');
		print $id.":  ".$node->nodeName."\n";
		// }	

		$function = 'parse_'.$node->nodeName;
		if(method_exists($this, $function)){
			return $this->$function($node);
		}else{
			return $this->error('Function "'.$node->nodeName.'" nothing.', $node->getAttribute('id'));
		}
	}


	/******************************************
	 * Methods about Parse Function 
	 *****************************************/

	/**
	 * Parse Function Block
	 *
	 * @param DOMnode
	 * @return boolean Success ? true : false
	*/
	function parse_block($node)
	{
		if( $this->setNodesToNodeStack($node) ){
			return $this->success('');
		}else{
			return $this->error('', $node->getAttribute('id'));
		}
	}

	/**
	 * Parse Function operation 
	 *
	 * @param DOMnode
	 * @return mixed Result
	*/
	function parse_operation($node)
	{
		$operator = $node->getAttribute('name');
		if($operator == ''){
			return $this->error('Function "name" nothing.', $node->getAttribute('id'));
		}

		$childNodes = $node->childNodes;
		if($childNodes->length == 2){
			// get left and right values
			$resLeft = $this->parseNode($childNodes->item(0));
			$resRight = $this->parseNode($childNodes->item(1));
			if( $resLeft['successFlag'] ){
				if( $resRight['successFlag'] ){
					return $this->success($resLeft['value'].$operator.$resRight['value']);
				}else{ return $resRight; }
			}else{ return $resLeft; }
		}else{
			return $this->error('Syntax error.', $node->getAttribute('id'));
		}
	}


	/**
	 * Parse Function Value
	 *
	 * @param DOMnode
	 * @return mixed Result
	*/
	function parse_value($node)
	{
		$value = $node->getAttribute('name');
		
		if($value != ''){
			return $this->success("'$value'");
		}else{
			return $this->error('Attribute "name" nothing.', $node->getAttribute('id'));
		}
	}
	
	/**
	 * Parse Function Variable
	 *
	 * @param DOMnode
	 * @return mixed Result
	*/
	function parse_var($node)
	{
		$var = $node->getAttribute('name');
		if($var != ''){
			$var = '$this->variables[\''.$var.'\']';
		}else{
			return $this->error('Attribute "name" nothing.', $node->getAttribute('id'));
		}
	
		$childNodes = $node->childNodes;
		foreach ($childNodes as $childNode){
			$result = $this->parseNode($childNode);
			if( $result['successFlag'] ){
				$var .= '['.$result['value'].']';		
			}else{ return $result; }
		}
		return $this->success($var);
	}

	/**
	 * Parse Function Array 
	 *
	 * @param DOMnode
	 * @return mixed Result
	*/
	function parse_array($node)
	{
		$array = '';
		$childNodes = $node->childNodes;
		if( $childNodes->length % 2 == 0){
			for ($i=0; $i<$childNodes->length; $i+=2){
				$resKey = $this->parseNode($childNodes->item($i));
				$resValue = $this->parseNode($childNodes->item($i+1));
				if( $resKey['successFlag'] ){
					if( $resValue['successFlag']){
						$array .= $resKey['value'].'=>'.$resValue['value'].',';		
					}else{ return $resValue; }
				}else{ return $resKey; }
			}
		}else{
			return $this->error('Syntax error.', $node->getAttribute('id'));
		}
		return $this->success("array($array)");
	}
	
	/**
	 * Parse Function Set 
	 *
	 * @param DOMnode
	 * @return mixed Resule
	*/
	function parse_set($node)
	{
		$childNodes = $node->childNodes;
		if($childNodes->length == 2){
			$resLeft = $this->parseNode($childNodes->item(0));
			$resRight = $this->parseNode($childNodes->item(1));
			if( $resLeft['successFlag'] ){
				if( $resRight['successFlag'] ){
					// generate code	
					$phpCode = $resLeft['value'].'='.$resRight['value'].';';
					/* debug */ print "PHP Code: $phpCode\n";
					// run

					$resPHP = false;
					try {
						$resPHP = eval($phpCode);
					} catch (\Exception $e) {
						return $this->error($e->getMessage(), $node->getAttribute('id'));
					}

					if(! ($resPHP === false) ){
						return $this->success($resPHP);
					}else{
						return $this->error('PHP parse error.', $node->getAttribute('id'));
					}
				}else{ return $resRight; }
			}else{ return $resLeft; }
		}else{
			return $this->error('Syntax error.', $node->getAttribute('id'));
		}
	}

	/**
	 * Parse Function If 
	 *
	 * @param DOMnode
	 * @return mixed Result 
	*/
	function parse_if($node){
		$childNodes = $node->childNodes;
		if(
			($childNodes->length == 3) &&
			($childNodes->item(0)->nodeName == 'condition') &&
			($childNodes->item(1)->nodeName == 'block') &&
			($childNodes->item(2)->nodeName == 'block')
		){
			$resCondition = $this->parseNode($childNodes->item(0));	
			if( $resCondition['successFlag'] ){
				if( $resCondition['value'] ){
					return $this->parseNode($childNodes->item(1));
				}else{
					return $this->parseNode($childNodes->item(2));
				}
			}else{ return $resCondition; }
		}else{
			return $this->error('Syntax error.', $node->getAttribute('id'));
		}
	}

	/**
	 * Parse Function While
	 *
	 * @param DOMnode
	 * @return mixed Resule
	*/
	function parse_while($node){
		$childNodes = $node->childNodes;
		if(
			($childNodes->length == 2) &&
			($childNodes->item(0)->nodeName == 'condition') &&
			($childNodes->item(1)->nodeName == 'block') 
		){
			$resCondition = $this->parseNode($childNodes->item(0));	
			if( $resCondition['successFlag'] ){
				if( $resCondition['value'] ){
					array_unshift($this->nodeStack, $node);
					return $this->parseNode($childNodes->item(1));
				}else{
					return $this->success('');
				}
			}else{ return $condition; }
		}else{
			return $this->error('Syntax error.', $node->getAttribute('id'));
		}
	}

	/**
	 * Parse Function Condition 
	 *
	 * @param DOMnode
	 * @return mixed Result
	*/
	function parse_condition($node){
		// get operator
		$operator = $node->getAttribute('name');
		if($operator == ''){
			return $this->error('Attribute "name" nothing.', $node->getAttribute('id'));
		}

		$childNodes = $node->childNodes;
		if($childNodes->length == 2){
			$resLeft = $this->parseNode($childNodes->item(0));
			$resRight = $this->parseNode($childNodes->item(1));
			if( $resLeft['successFlag'] ){
				if( $resRight['successFlag'] ){
					// generate code	
					$phpCode = "return ".$resLeft['value'].$operator.$resRight['value'].';';
					/* debug */ print "PHP Code: $phpCode\n";
					// run

					$resPHP = false;
					try {
						$resPHP = eval($phpCode);
					} catch (\Exception $e) {
						return $this->error($e->getMessage(), $node->getAttribute('id'));
					}

					return $this->success($resPHP);


				}else{ return $resRight; }
			}else{ return $resLeft; }
		}else{
			return $this->error('Syntax error.', $node->getAttribute('id'));
		}
	}

	/**
	 * Parse Function State 
	 *
	 * @param DOMnode
	 * @return boolean false
	*/
	function parse_state($node){
		$returnValues['items'][0]='Sample1';

		return $this->stop($node->getAttribute('id'), $returnValues);
	}

	/**
	 * Parse Function Print 
	 *
	 * @param DOMnode
	 * @return mixed Result
	*/
	function parse_print($node){
		$childNodes = $node->childNodes;
		foreach ($childNodes as $childNode){
			$result = $this->parseNode($childNode);
			if( $result['successFlag'] ){
				$phpCode = 'print '.$result['value'].';';
				/* debug */print "PHP Code: $phpCode\n";

				$resPHP = false;
				try {
					$resPHP = eval($phpCode);print "\n";
				} catch (\Exception $e) {
					return $this->error($e->getMessage(), $node->getAttribute('id'));
				}

				if(! ($resPHP === false) ){
					return $this->success($resPHP);
				}else{
					return $this->error('PHP parse error.', $node->getAttribute('id'));
				}
			}else{ return $result; }
		}
		return $this->success('');
	}

}
