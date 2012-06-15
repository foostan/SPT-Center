<?php

namespace OSPT\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OSPT\TestBundle\Entity\Test;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OSPT\TestBundle\Resources\lib\OSPTController;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
		$em = $this->getDoctrine()->getEntityManager();
		$tests = $em->getRepository('OSPTTestBundle:Test')->findAll();
		return $this->render('OSPTTestBundle:Default:index.html.twig', array('tests' => $tests));
    }

    public function manageAction()
    {
		$em = $this->getDoctrine()->getEntityManager();
		$tests = $em->getRepository('OSPTTestBundle:Test')->findAll();
		return $this->render('OSPTTestBundle:Default:manage.html.twig', array('tests' => $tests));
    }

    public function viewAction($id)
    {
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }
		return $this->render('OSPTTestBundle:Default:view.html.twig', array('test' => $test));
    }

	public function newAction()
	{
		$form = $this->createFormBuilder(new Test())
			->add('name')
			->add('controller')
			->getForm();

		$request = $this->getRequest();
		if ('POST' === $request->getMethod()) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$test = $form->getData();
				$test->setCreatedAt(new \DateTime());
				$test->setUpdatedAt(new \DateTime());
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($test);
				$em->flush();
				return $this->redirect($this->generateUrl('test_manage'));
			}
		}

		return $this->render('OSPTTestBundle:Default:new.html.twig', array(
			'form' => $form->createView(),
		));
	}

	public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
		if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

		// delete Test Items
		foreach( $test->getTestItems() as $test_item ){
			foreach( $test_item->getTestIteQuestions() as $test_iteQuestion ){
				foreach( $test_iteQuestion->getTestIteQueChoices() as $test_iteQueChoice ){
					$em->remove($test_iteQueChoice);
				}
				$em->remove($test_iteQuestion);
			}
			$em->remove($test_item);
		}

		// delete Test States
		foreach( $test->getTestStates() as $test_state ){
			foreach( $test_state->getTestStaOptions() as $test_staOption ){
				$em->remove($test_staOption);
			}
			$em->remove($test_state);
		}


        $em->remove($test);
        $em->flush();
        return $this->redirect($this->generateUrl('test_manage'));
    }

	public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
		$test = $this->getDoctrine()->getRepository('OSPTTestBundle:Test')->findOneBy(array('name'=>$id));
        if (!$test) {
            throw new NotFoundHttpException('The test does not exist.');
        }

        $form = $this->createFormBuilder($test)
            ->add('name')
            ->add('controller')
            ->getForm();

        $request = $this->getRequest();
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $test = $form->getData();
                $test->setUpdatedAt(new \DateTime());
                $em->flush();
                return $this->redirect($this->generateUrl('test_manage'));
            }
        }

        return $this->render('OSPTTestBundle:Default:edit.html.twig', array(
            'test' => $test,
            'form' => $form->createView(),
        ));
    }



}	
