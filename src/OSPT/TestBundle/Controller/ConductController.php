<?php

namespace OSPT\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OSPT\TestBundle\Entity\Test;
use OSPT\TestBundle\Entity\Test_item;
use OSPT\TestBundle\Entity\Test_log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OSPT\TestBundle\Resources\lib\OSPTController;


class ConductController extends Controller
{
	public function indexAction($id)
	{


		// load test
		$em = $this->getDoctrine()->getEntityManager();
		$test = $em->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
			return $this->errorAction($id,'Not found this test','');
        }


		$doc = new \DomDocument;
		$doc->validateOnParse = true;
		$doc->preserveWhiteSpace = false;
		$osptcont = new OSPTController();
		$attributes = $this->getAttributes($id);

		if( 
			!($attributes === null) &&
			array_key_exists('nowState', $attributes) &&
			$attributes['nowState']!=null 
		){
			return $this->errorAction($id,'Direct access to this page is not supported','');
		}

		// if first access
		// get and set controller
		if($attributes === null){
			// get controller
			try {
				$doc->loadXML($test->getController());
			} catch (\Exception $e) {
				return $this->errorAction($id,'Failed to load a controller of'.$test->getName(),$e->getMessage());
			}
			// prepare root node
			$xpath = new \DOMXPath($doc);
			$query = "//*[@id='".$test->getName()."']";
			$entries = $xpath->query($query);
			$node = $entries->item(0);
			if( $node == null ){
				return $this->errorAction($id,'Failed to load a controller of'.$test->getName(),'');
			}
			// validate prepared controller
			try {
				$osptcont->validate($node);
			} catch (\Exception $e) {
				return $this->errorAction($id,'Failed to validate a controller of'.$test->getName(),$e->getMessage());
			}
			// set prepared controller
			try {
				$osptcont->setNodesToNodeStack($node);
			} catch (\Exception $e) {
				return $this->errorAction($id,'Failed to set nodes to a NodeStack of'.$test->getName(),$e->getMessage());
			}
			// create log
			$log = new Test_Log();
			$log->setTest($test);
			$log->setUser($this->get('security.context')->getToken()->getUser());
			$em->persist($log);
			$em->flush();
		}
		// continue
		else{
			if(! array_key_exists('variables', $attributes)){
				return $this->errorAction($id,'Not found variables','');
			}
			if(! array_key_exists('xmlStack', $attributes)){
				return $this->errorAction($id,'Not found a NodeStack','');
			}
			if(! array_key_exists('logId', $attributes)){
				return $this->errorAction($id,'Not found a Log Id','');
			}else{
				// load log
				$log = $em->getRepository('OSPTTestBundle:Test_Log')->findOneBy(array('id'=>$attributes['logId']));
        		if (!$log) {
					return $this->errorAction($id,'Not found a Log','');
				}
			}

			$nodeStack = array();
			foreach( $attributes['xmlStack'] as $xml){

				// get controller
				try {
					$doc->loadXML($xml);
				} catch (\Exception $e) {
					return $this->errorAction($id,'Failed to load a controller of'.$test->getName(),$e->getMessage());
				}
				$node = $doc->documentElement;

				// validate prepared controller
				try {
					$osptcont->validate($node);
				} catch (\Exception $e) {
					return $this->errorAction($id,'Failed to validate a controller of'.$test->getName(),$e->getMessage());
				}
				
				// push node
				array_push($nodeStack, $node);
			}
			//var_dump($nodeStack);

			$osptcont->setVariables($attributes['variables']);
			$osptcont->setNodeStack($nodeStack);

		}

		// run by controller
		$result = array();
		try {
			print "<h2>run debug</h2><pre>";
			$result = $osptcont->run();
			print '</pre>';
			print '<h2>result</h2><pre>';
			print '</pre>';
		} catch (\Exception $e) {
			return $this->errorAction($id,'Failed to run a controller of'.$test->getName(),$e->getMessage());
		}

		if($result['successFlag']){
			$this->setConductAttributes($id, null);
			/*
			 * 正常に終了
			 *
			 */

			// stamp finied time
			$log->setFinishedAt(new \DateTime());
			$em->persist($log);
			$em->flush();
			//最終的にはレポート(今回のテスト結果)に飛ばす
			return $this->redirect($this->generateUrl('test_index'));
		}elseif($result['stopFlag']){
			// exchange DOM Element for XML
			$nodes = array();
			foreach($osptcont->getNodeStack() as $node){
				array_push($nodes, $node->ownerDocument->saveXML($node));
			}

/*
			// load items
			$items = array();
			foreach($result['value']['items'] as $itemName){
				$item = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_Item')->findOneBy(array('name'=>$itemName));
    	    	if (!$item) {
					return $this->errorAction($id,"Not found $itemName in the item pool",'');
    	    	}
				array_push($items,$item);
			}
*/
			// save attributes
			$variables = $osptcont->getVariables();

/*
			$variables['system']['logs'][] = array(
				'startTime' => 'hoge',
				'finishTime' => '',
				'items' => $items,

			);
*/

			/*
			 * go to next state
			 */
			$this->setConductAttributes($id, array(
				'variables' => $variables,
				'items' => $result['value']['items'],
				'xmlStack' => $nodes,
				'nowState' => $result['nodeId'],
				'logId' => $log->getId(),
			));
			return $this->redirect($this->generateUrl('test_conduct_state', array('id'=>$id, 'state'=>$result['nodeId'])));

		}elseif($result['errorFlag']){
			$this->setConductAttributes($id, null);
			return $this->errorAction($id,'Error on ID'.$result['nodeId'],$result['message']);
		}else{
			return $this->errorAction($id,'Not found a result code','');
		}


		//debug
		print '<h2>Session</h2><pre>';
		var_dump($this->get('request')->getSession());
		print '</pre>';
	}

	public function stateAction($id, $state)
	{
		// load attributes
		$attributes = $this->getAttributes($id);
		if( !(array_key_exists('nowState', $attributes) && $attributes['nowState']==$state) ){
			return $this->errorAction($id,'Not found the next state','');
		}
		if(! array_key_exists('variables', $attributes)){
			return $this->errorAction($id,'Not found variables','');
		}

		// cheack step next request
		$request = $this->get('request');
		if( $request->get('next') == 'true' ){



			$attributes['nowState'] = null;
			$this->setConductAttributes($id, $attributes);
			return $this->forward('OSPTTestBundle:Conduct:index', array('id'=>$id));
		}

		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
			return $this->errorAction($id,'Not found this test','');
        }

		// load state
		$nowState = $test->getTestState($state);
		if($nowState === null){
			return $this->errorAction($id,'Not found the next state','');
		}

		// load items
		$items = array();
		foreach($attributes['items'] as $itemName){
			$item = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_Item')->findOneBy(array('name'=>$itemName));
        	if (!$item) {
				return $this->errorAction($id,"Not found $itemName in the item pool",'');
        	}
			array_push($items,$item);
		}

	
		print '<div>';	
		print '<span class="label label-info">Attributes</span>';
		print '<pre class=".pre-scrollable">';
		var_dump($attributes);
		print "</pre>";

		print '<span class="label label-info">Requests</span>';
		print '<pre class=".pre-scrollable">';
		var_dump($request->request);
		var_dump($this->get('request')->getSession());
		print "</pre>";
		print '</div>';

		$staType = $nowState->getTestStaType();
		if($staType->getName() === 'Plain'){
			return $this->render('OSPTTestBundle:Conduct:state_plain.html.twig',array(
				'test'=>$test,
				'state'=>$nowState,
				'variables'=>$attributes['variables'],
				'items'=>$items,
				//'log'=>$log
			));
		}elseif($staType->getName() === 'Question'){
			return $this->render('OSPTTestBundle:Conduct:state_question.html.twig',array(
				'test'=>$test,
				'state'=>$nowState,
				'variables'=>$attributes['variables'],
				'items'=>$items,
				//'log'=>$log
			));
		}else{
			return $this->errorAction($id,'Not found the state type','');
		}
	}

	private function getAttributes($id, $default = null)
	{
		$session = $this->get('request')->getSession();
		$allAttributes = $session->get('test_conduct', array());
		return array_key_exists($id, $allAttributes) ? $allAttributes[$id] : $default;
	}

	private function setConductAttributes($id, $attributes)
	{
		$session = $this->get('request')->getSession();
		$allAttributes = $session->get('test_conduct');
		if( $allAttributes === null ) $allAttributes = array();
		$allAttributes[$id] = $attributes;
		$session->set('test_conduct', $allAttributes);
	}

	private function errorAction($id, $title, $message)
	{
		// write finished time
		$em = $this->getDoctrine()->getEntityManager();
		$attributes = $this->getAttributes($id);
		if( !($attributes === null) && array_key_exists('logId', $attributes)){
			$log = $em->getRepository('OSPTTestBundle:Test_Log')->findOneBy(array('id'=>$attributes['logId']));
       		if ($log) {
				$log->setFinishedAt(new \DateTime());
				$em->persist($log);
				$em->flush();
			}
		}

		$this->setConductAttributes($id, null);
		return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
			'errorTitle'=>$title,
			'errorMessage'=>$message,
		));
	}
}	
