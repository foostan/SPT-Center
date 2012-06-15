<?php

namespace OSPT\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OSPT\TestBundle\Entity\Test;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OSPT\TestBundle\Resources\lib\OSPTController;


class ConductController extends Controller
{
	public function indexAction($id)
	{
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
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
            throw new NotFoundHttpException('Direct access to this page is not supported.');
		}

		// if first access
		// get and set controller
		if($attributes === null){
			// get controller
			try {
				$doc->loadXML($test->getController());
			} catch (\Exception $e) {
	        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
					'errorTitle'=>'Failed to load a controller of '.$test->getName(),
					'errorMessage'=>$e->getMessage()
				));
			}
			// prepare root node
			$xpath = new \DOMXPath($doc);
			$query = "//*[@id='".$test->getName()."']";
			$entries = $xpath->query($query);
			$node = $entries->item(0);
			if( $node == null ){
	        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
					'errorTitle'=>'Failed to load a controller of '.$test->getName(),
					'errorMessage'=>''
				));
			}
			// validate prepared controller
			try {
				$osptcont->validate($node);
			} catch (\Exception $e) {
	        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
					'errorTitle'=>'Failed to validate a controller of '.$test->getName(),
					'errorMessage'=>$e->getMessage()
				));
			}
			// set prepared controller
			try {
				$osptcont->setNodesToNodeStack($node);
			} catch (\Exception $e) {
	        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
					'errorTitle'=>'Failed to set nodes to a NodeStack of '.$test->getName(),
					'errorMessage'=>$e->getMessage()
				));
			}
		}
		// continue
		else{
			if(! array_key_exists('variables', $attributes)){
	        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
					'errorTitle'=>'Not found Variables',
					'errorMessage'=>''
				));
			}
			if(! array_key_exists('xmlStack', $attributes)){
	        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
					'errorTitle'=>'Not found a NodeStack',
					'errorMessage'=>''
				));
			}

			$nodeStack = array();
			foreach( $attributes['xmlStack'] as $xml){

				// get controller
				try {
					$doc->loadXML($xml);
				} catch (\Exception $e) {
	        		return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
						'errorTitle'=>'Failed to load a controller of '.$test->getName(),
						'errorMessage'=>$e->getMessage()
					));
				}
				$node = $doc->documentElement;

				// validate prepared controller
				try {
					$osptcont->validate($node);
				} catch (\Exception $e) {
	        		return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
						'errorTitle'=>'Failed to validate a controller of '.$test->getName(),
						'errorMessage'=>$e->getMessage()
					));
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
        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
				'errorTitle'=>'Failed to run a controller of '.$test->getName(),
				'errorMessage'=>$e->getMessage()
			));
		}

		if($result['successFlag']){
			$this->setConductAttributes($id, null);
			return $this->render('OSPTTestBundle:Conduct:index.html.twig');
		}elseif($result['stopFlag']){
			// exchange DOM Element for XML
			$nodes = array();
			foreach($osptcont->getNodeStack() as $node){
				array_push($nodes, $node->ownerDocument->saveXML($node));
			}
			// save attributes
			$this->setConductAttributes($id, array(
				'variables' => $osptcont->getVariables(),
				'xmlStack' => $nodes,
				'nowState' => $result['nodeId']
			));
        
			return $this->redirect($this->generateUrl('test_conduct_state', array('id'=>$id, 'state'=>$result['nodeId'])));

		}elseif($result['errorFlag']){
			$this->setConductAttributes($id, null);
        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
				'errorTitle'=>'Error on ID '.$result['nodeId'],
				'errorMessage'=>$result['message'],
			));
        
			return $this->render('OSPTTestBundle:Conduct:index.html.twig');
		}else{
        	return $this->render('OSPTTestBundle:Conduct:error.html.twig',array(
				'errorTitle'=>'Not found a result code',
				'errorMessage'=>'',
			));
		}


		//debug
		print '<h2>Session</h2><pre>';
		var_dump($this->get('request')->getSession());
		print '</pre>';
		return $this->render('OSPTTestBundle:Conduct:index.html.twig');
	}

	public function stateAction($id, $state)
	{
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }
		
		// load attributes
		$attributes = $this->getAttributes($id);
		if( !(array_key_exists('nowState', $attributes) && $attributes['nowState']==$state) ){
            throw new NotFoundHttpException('This state does not exist.');
		}
	
		// load requests
		$request = $this->get('request');
		if( $request->get('next') == 'true' ){
			$attributes['nowState'] = null;
			$this->setConductAttributes($id, $attributes);
			return $this->forward('OSPTTestBundle:Conduct:index', array('id'=>$id));
		}	

	
		print "<pre>";
		print "<h2>Attributes</h2>";
		var_dump($attributes);
		print "<h2>Requests</h2>";
		var_dump($request->request);
		var_dump($this->get('request')->getSession());
		print "</pre>";


		return $this->render('OSPTTestBundle:Conduct:index.html.twig');

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


}	
