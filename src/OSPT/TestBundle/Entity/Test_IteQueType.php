<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_IteQueType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_IteQueType
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_IteQuestion", mappedBy="type")
	 */
	private $test_iteQuestions;

	public function __construct()
	{
		$this->test_iteQuestions = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add test_iteQuestions
     *
     * @param OSPT\TestBundle\Entity\Test_IteQuestion $testIteQuestions
     */
    public function addTest_IteQuestion(\OSPT\TestBundle\Entity\Test_IteQuestion $testIteQuestions)
    {
        $this->test_iteQuestions[] = $testIteQuestions;
    }

    /**
     * Get test_iteQuestions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestIteQuestions()
    {
        return $this->test_iteQuestions;
    }
}