<?php

namespace OSPT\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OSPT\TestBundle\Resources\lib\OSPTController;

use OSPT\TestBundle\Entity\Test;
use OSPT\TestBundle\Entity\Test_Problem;
use OSPT\TestBundle\Entity\Test_ProQuestion;
use OSPT\TestBundle\Entity\Test_ProQueChoice;
use OSPT\TestBundle\Entity\Test_ProQueType;

use OSPT\TestBundle\Form\Test_ProblemType;
use OSPT\TestBundle\Form\Test_ProQuestionType;
use OSPT\TestBundle\Form\Test_ProQueChoiceType;
use OSPT\TestBundle\Form\Test_HogeType;

class ProblemController extends Controller
{
    
	public function indexAction($id)
	{
		// load test
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		return $this->render('OSPTTestBundle:Problem:index.html.twig', array('test' => $test));
	}

	public function viewAction($id, $pid)
	{
		// load problem
		$problem = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_Problem')->findOneBy(array('id'=>$pid));
        if (!$problem) {
            throw new NotFoundHttpException('The problem does not exist.');
        }

		return $this->render('OSPTTestBundle:Problem:view.html.twig', array('problem' => $problem));
	}

	public function newAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$test = $em->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		$form = $this->createForm(new Test_ProblemType(), new Test_Problem());

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				// set new Problem data
				$test_problem = $form->getData();
				$test_problem->setTest($test); // relate to Test
				$test_problem->setCreatedAt(new \DateTime());
				$test_problem->setUpdatedAt(new \DateTime());

				foreach($test_problem->getTestProQuestions() as $test_proQuestion){
					foreach($test_proQuestion->getTestProQueChoices() as $test_proQueChoice){
						$test_proQueChoice->setTestProQuestion($test_proQuestion); // relate to Question
						$em->persist($test_proQueChoice);
					}
					$test_proQuestion->setTestProblem($test_problem); // relate to Problem
					$em->persist($test_proQuestion);
				}

				$em->persist($test_problem);
				$em->flush();

				return $this->redirect($this->generateUrl('test_problem_index',array('id' => $id)));

			}
		}

		return $this->render('OSPTTestBundle:Problem:new.html.twig', array(
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
		
		$test_problem = $em->getRepository('OSPTTestBundle:Test_Problem')->findOneBy(array('id'=>$pid));
        if (!$test_problem) {
           throw new NotFoundHttpException('The problem does not exist.');
        }

		$orgTestProQuestions = array();
		$orgTestProQueChoices = array();
		foreach($test_problem->getTestProQuestions() as $test_proQuestion){
			foreach($test_proQuestion->getTestProQueChoices() as $test_proQueChoice){
				$orgTestProQueChoices[$test_proQuestion->getId()][$test_proQueChoice->getId()] = $test_proQueChoice;
			}
			$orgTestProQuestions[$test_proQuestion->getId()] = $test_proQuestion;
		}


		$form = $this->createForm(new Test_ProblemType(), $test_problem);

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				// set new Problem data
				//$test_problem = $form->getData();
				$test_problem->setUpdatedAt(new \DateTime());

				// skip common questions
				// and delete choices
				foreach($test_problem->getTestProQuestions() as $test_proQuestion){
					if(array_key_exists($test_proQuestion->getId(), $orgTestProQuestions)){

						// aboud choices
						if(array_key_exists($test_proQuestion->getId(), $orgTestProQueChoices)){
							// skip common choices
							foreach($test_proQuestion->getTestProQueChoices() as $test_proQueChoice){
								if(array_key_exists($test_proQueChoice->getId(), $orgTestProQueChoices[$test_proQuestion->getId()])){
									unset($orgTestProQueChoices[$test_proQuestion->getId()][$test_proQueChoice->getId()]);
								}
							}

							// delete choices
							foreach($orgTestProQueChoices[$test_proQuestion->getId()] as $test_proQueChoice){
								$em->remove($test_proQueChoice);
							}
						}

						unset($orgTestProQuestions[$test_proQuestion->getId()]);
					}
				}
				// delete questions
				foreach($orgTestProQuestions as $test_proQuestion){
					foreach($test_proQuestion->getTestProQueChoices() as $test_proQueChoice){
						$em->remove($test_proQueChoice);
					}
					$em->remove($test_proQuestion);
				}

				// add, modify or nothing elements
				foreach($test_problem->getTestProQuestions() as $test_proQuestion){
					foreach($test_proQuestion->getTestProQueChoices() as $test_proQueChoice){
						$test_proQueChoice->setTestProQuestion($test_proQuestion); // relate to Question
						$em->persist($test_proQueChoice);
					}
					$test_proQuestion->setTestProblem($test_problem); // relate to Problem
					$em->persist($test_proQuestion);
				}
										
				$em->flush();

				return $this->redirect($this->generateUrl('test_problem_index',array('id' => $id)));

			}
		}
		
		return $this->render('OSPTTestBundle:Problem:edit.html.twig', array(
			'form' => $form->createView(),
			'test_id' => $id,
			'problem_id' => $pid,
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

		$test_problem = $this->getDoctrine()->getRepository('OSPTTestBundle:Test_Problem')->findOneBy(array('id'=>$pid));
        if (!$test_problem) {
           throw new NotFoundHttpException('The problem does not exist.');
        }

		foreach( $test_problem->getTestProQuestions() as $test_proQuestion ){
			foreach( $test_proQuestion->getTestProQueChoices() as $test_proQueChoice ){
				$em->remove($test_proQueChoice);
			}
			$em->remove($test_proQuestion);
		}
		$em->remove($test_problem);
		$em->flush();

		return $this->render('OSPTTestBundle:Problem:index.html.twig', array('test' => $test));
    }
}	
