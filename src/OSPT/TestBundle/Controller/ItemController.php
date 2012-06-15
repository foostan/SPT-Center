<?php

namespace OSPT\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OSPT\TestBundle\Resources\lib\OSPTController;

use OSPT\TestBundle\Entity\Test;
use OSPT\TestBundle\Entity\Test_Item;
use OSPT\TestBundle\Entity\Test_IteQuestion;
use OSPT\TestBundle\Entity\Test_IteQueChoice;
use OSPT\TestBundle\Entity\Test_IteQueType;

use OSPT\TestBundle\Form\Test_ItemType;
use OSPT\TestBundle\Form\Test_IteQuestionType;
use OSPT\TestBundle\Form\Test_IteQueChoiceType;
use OSPT\TestBundle\Form\Test_HogeType;

class ItemController extends Controller
{
    
	public function indexAction($id)
	{
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		return $this->render('OSPTTestBundle:Item:index.html.twig', array('test' => $test));
	}

	public function viewAction($id, $pid)
	{
		// load item
		$item = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_Item')->findOneBy(array('id'=>$pid));
        if (!$item) {
            throw new NotFoundHttpException('The item does not exist.');
        }

		return $this->render('OSPTTestBundle:Item:view.html.twig', array('item' => $item));
	}

	public function newAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$test = $em->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		$form = $this->createForm(new Test_ItemType(), new Test_Item());

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				// set new Item data
				$test_item = $form->getData();
				$test_item->setTest($test); // relate to Test
				$test_item->setCreatedAt(new \DateTime());
				$test_item->setUpdatedAt(new \DateTime());

				foreach($test_item->getTestIteQuestions() as $test_iteQuestion){
					foreach($test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice){
						$test_iteQueChoice->setTestIteQuestion($test_iteQuestion); // relate to Question
						$em->persist($test_iteQueChoice);
					}
					$test_iteQuestion->setTestItem($test_item); // relate to Item
					$em->persist($test_iteQuestion);
				}

				$em->persist($test_item);
				$em->flush();

				return $this->redirect($this->generateUrl('test_item_index',array('id' => $id)));

			}
		}

		return $this->render('OSPTTestBundle:Item:new.html.twig', array(
			'form' => $form->createView(),
			'test_id' => $id,
		));
	}
	
	public function editAction($id, $pid)
    {
		$em = $this->getDoctrine()->getEntityManager();
		$test = $em->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }
		
		$test_item = $em->getRepository('OSPTTestBundle:Test_Item')->findOneBy(array('id'=>$pid));
        if (!$test_item) {
           throw new NotFoundHttpException('The item does not exist.');
        }

		$orgTestIteQuestions = array();
		$orgTestIteQueChoices = array();
		foreach($test_item->getTestIteQuestions() as $test_iteQuestion){
			foreach($test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice){
				$orgTestIteQueChoices[$test_iteQuestion->getId()][$test_iteQueChoice->getId()] = $test_iteQueChoice;
			}
			$orgTestIteQuestions[$test_iteQuestion->getId()] = $test_iteQuestion;
		}


		$form = $this->createForm(new Test_ItemType(), $test_item);

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				// set new Item data
				//$test_item = $form->getData();
				$test_item->setUpdatedAt(new \DateTime());

				// skip common questions
				// and delete choices
				foreach($test_item->getTestIteQuestions() as $test_iteQuestion){
					if(array_key_exists($test_iteQuestion->getId(), $orgTestIteQuestions)){

						// aboud choices
						if(array_key_exists($test_iteQuestion->getId(), $orgTestIteQueChoices)){
							// skip common choices
							foreach($test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice){
								if(array_key_exists($test_iteQueChoice->getId(), $orgTestIteQueChoices[$test_iteQuestion->getId()])){
									unset($orgTestIteQueChoices[$test_iteQuestion->getId()][$test_iteQueChoice->getId()]);
								}
							}

							// delete choices
							foreach($orgTestIteQueChoices[$test_iteQuestion->getId()] as $test_iteQueChoice){
								$em->remove($test_iteQueChoice);
							}
						}

						unset($orgTestIteQuestions[$test_iteQuestion->getId()]);
					}
				}
				// delete questions
				foreach($orgTestIteQuestions as $test_iteQuestion){
					foreach($test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice){
						$em->remove($test_iteQueChoice);
					}
					$em->remove($test_iteQuestion);
				}

				// add, modify or nothing elements
				foreach($test_item->getTestIteQuestions() as $test_iteQuestion){
					foreach($test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice){
						$test_iteQueChoice->setTestIteQuestion($test_iteQuestion); // relate to Question
						$em->persist($test_iteQueChoice);
					}
					$test_iteQuestion->setTestItem($test_item); // relate to Item
					$em->persist($test_iteQuestion);
				}
										
				$em->flush();

				return $this->redirect($this->generateUrl('test_item_index',array('id' => $id)));

			}
		}
		
		return $this->render('OSPTTestBundle:Item:edit.html.twig', array(
			'form' => $form->createView(),
			'test_id' => $id,
			'item_id' => $pid,
		));
	}

	public function deleteAction($id, $pid)
    {

        $em = $this->getDoctrine()->getEntityManager();

		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		$test_item = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_Item')->findOneBy(array('id'=>$pid));
        if (!$test_item) {
           throw new NotFoundHttpException('The item does not exist.');
        }

		foreach( $test_item->getTestIteQuestions() as $test_iteQuestion ){
			foreach( $test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice ){
				$em->remove($test_iteQueChoice);
			}
			$em->remove($test_iteQuestion);
		}
		$em->remove($test_item);
		$em->flush();

		return $this->render('OSPTTestBundle:Item:index.html.twig', array('test' => $test));
    }
}	
