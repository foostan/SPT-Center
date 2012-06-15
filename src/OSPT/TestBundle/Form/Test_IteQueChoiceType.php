<?php
namespace OSPT\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManager;

class Test_IteQueChoiceType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('statement')
			->add('pointRate')
        ;
    }

	public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'OSPT\TestBundle\Entity\Test_IteQueChoice',
        );
    }

    public function getName()
    {
        return 'test_iteQueChoice';
    }
	
}

