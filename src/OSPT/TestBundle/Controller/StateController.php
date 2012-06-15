<?php

namespace OSPT\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OSPT\TestBundle\Resources\lib\OSPTController;

use OSPT\TestBundle\Entity\Test;
use OSPT\TestBundle\Entity\Test_State;
use OSPT\TestBundle\Entity\Test_StaOption;
use OSPT\TestBundle\Entity\Test_StaType;

use OSPT\TestBundle\Form\Test_StateType;
use OSPT\TestBundle\Form\Test_StaOptionType;

class StateController extends Controller
{
    
	public function indexAction($id)
	{
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		return $this->render('OSPTTestBundle:State:index.html.twig', array('test' => $test));
	}

	public function viewAction($id, $sid)
	{
		// load state 
		$state = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_State')->findOneBy(array('id'=>$sid));
        if (!$state) {
            throw new NotFoundHttpException('The state does not exist.');
        }

		return $this->render('OSPTTestBundle:State:view.html.twig', array('state' => $state));
	}

	public function newAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		$form = $this->createForm(new Test_StateType(), new Test_State());

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$test_state = $form->getData();
				$test_state->setTest($test); // relate to Test
				$test_state->setCreatedAt(new \DateTime());
				$test_state->setUpdatedAt(new \DateTime());

				foreach($test_state->getTestStaOptions() as $test_staOption){
					$test_staOption->setTestState($test_state); // relate to State
					$em->persist($test_staOption);
				}

				$em->persist($test_state);
				$em->flush();

				return $this->redirect($this->generateUrl('test_state_index',array('id' => $id)));

			}
		}

		return $this->render('OSPTTestBundle:State:new.html.twig', array(
			'form' => $form->createView(),
			'test_id' => $id,
		));
	}
	
	public function editAction($id, $sid)
    {
		$em = $this->getDoctrine()->getEntityManager();
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }
		// load state
		$test_state = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_State')->findOneBy(array('id'=>$sid));
        if (!$test_state) {
            throw new NotFoundHttpException('The state does not exist.');
        }

		$orgTestStaOptions = array();
		foreach($test_state->getTestStaOptions() as $test_staOption){
			$orgTestStaOptions[$test_staOption->getId()] = $test_staOption;
		}

		$form = $this->createForm(new Test_StateType(), $test_state);

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$test_state->setUpdatedAt(new \DateTime());

				// skip common options
				foreach($test_state->getTestStaOptions() as $test_staOption){
					if(array_key_exists($test_staOption->getId(), $orgTestStaOptions)){
						unset($orgTestStaOptions[$test_staOption->getId()]);
					}
				}
				// delete options
				foreach($orgTestStaOptions as $test_staOption){
					$em->remove($test_staOption);
				}

				// add, modify or nothing options
				foreach($test_state->getTestStaOptions() as $test_staOption){
					$test_staOption->setTestState($test_state); // relate to State
					$em->persist($test_staOption);
				}

				$em->flush();

				return $this->redirect($this->generateUrl('test_state_index',array('id' => $id)));

			}
		}

		return $this->render('OSPTTestBundle:State:edit.html.twig', array(
			'form' => $form->createView(),
			'test_id' => $id,
			'test_sid' => $sid,
		));
	}

	public function deleteAction($id, $sid)
    {
        $em = $this->getDoctrine()->getEntityManager();
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }
		// load state
		$test_state = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_State')->findOneBy(array('id'=>$sid));
        if (!$test_state) {
            throw new NotFoundHttpException('The state does not exist.');
        }

		foreach( $test_state->getTestStaOptions() as $test_staOption ){
			$em->remove($test_staOption);
		}
		$em->remove($test_state);
		$em->flush();

		return $this->render('OSPTTestBundle:State:index.html.twig', array('test' => $test));
    }
}	
