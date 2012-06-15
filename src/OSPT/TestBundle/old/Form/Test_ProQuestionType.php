<?php
namespace OSPT\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;
use OSPT\TestBundle\Entity\Test_ProQueType;

class Test_ProQuestionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('statement')
            ->add('pointRate')
			->add('test_proQueType', 'entity', array(
				'class' => 'OSPTTestBundle:Test_ProQueType',
				'property' => 'name',
				'empty_value' => 'Choose one',
			))

			->add('test_proQueChoices', 'collection', array(
				'type' => new Test_ProQueChoiceType(),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => true,
				'prototype' => true,
				'prototype_name' => '$$test_proQueChoice$$',
			))

		;
	  }

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'OSPT\TestBundle\Entity\Test_ProQuestion',
        );
    }

    public function getName()
    {
        return 'test_proQuestion';
    }

}
