<?php
namespace OSPT\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;

class Test_ProblemType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('statement')
			->add('test_proQuestions', 'collection', array( 
				'type' => new Test_ProQuestionType(),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => true,
				'prototype' => true,
				'prototype_name' => '$$test_proQuestion$$',
			))
      ;
    }

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'OSPT\TestBundle\Entity\Test_Problem',
        );
    }

    public function getName()
    {
        return 'test_problem';
    }

}
