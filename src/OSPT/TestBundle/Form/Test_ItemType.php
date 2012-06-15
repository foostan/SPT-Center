<?php
namespace OSPT\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;

class Test_ItemType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('statement')
			->add('test_iteQuestions', 'collection', array( 
				'type' => new Test_IteQuestionType(),
				'allow_add' => true,
				'allow_delete' => true,
				'by_reference' => true,
				'prototype' => true,
				'prototype_name' => '$$test_iteQuestion$$',
			))
      ;
    }

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'OSPT\TestBundle\Entity\Test_Item',
        );
    }

    public function getName()
    {
        return 'test_item';
    }

}
