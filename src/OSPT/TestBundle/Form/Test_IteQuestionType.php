<?php
namespace OSPT\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;
use OSPT\TestBundle\Entity\Test_IteQueType;

class Test_IteQuestionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('statement')
            ->add('pointRate')
			->add('test_iteQueType', 'entity', array(
				'class' => 'OSPTTestBundle:Test_IteQueType',
				'property' => 'name',
				'empty_value' => 'Choose one',
			))

			->add('test_iteQueChoices', 'collection', array(
				'type' => new Test_IteQueChoiceType(),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => true,
				'prototype' => true,
				'prototype_name' => '$$test_iteQueChoice$$',
			))

		;
	  }

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'OSPT\TestBundle\Entity\Test_IteQuestion',
        );
    }

    public function getName()
    {
        return 'test_iteQuestion';
    }

}
