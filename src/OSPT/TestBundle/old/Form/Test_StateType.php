<?php
namespace OSPT\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;
use OSPT\TestBundle\Entity\Test_StaType;

class Test_StateType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder
            ->add('name')
			->add('test_staType', 'entity', array(
				'class' => 'OSPTTestBundle:Test_StaType',
				'property' => 'name',
				'empty_value' => 'Choose one',
			))

			->add('test_StaOptions', 'collection', array( 
				'type' => new Test_StaOptionType(),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => true,
				'prototype' => true,
				'prototype_name' => '$$test_staOption$$',
			))
      ;
    }

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'OSPT\TestBundle\Entity\Test_State',
        );
    }

    public function getName()
    {
        return 'test_state';
    }

}
