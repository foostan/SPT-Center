<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_ProQueType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_ProQueType
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
	 * @ORM\OneToMany(targetEntity="Test_ProQuestion", mappedBy="type")
	 */
	private $test_proQuestions;

	public function __construct()
	{
		$this->test_proQuestions = new ArrayCollection();
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
     * Add test_proQuestions
     *
     * @param OSPT\TestBundle\Entity\Test_ProQuestion $testProQuestions
     */
    public function addTest_ProQuestion(\OSPT\TestBundle\Entity\Test_ProQuestion $testProQuestions)
    {
        $this->test_proQuestions[] = $testProQuestions;
    }

    /**
     * Get test_proQuestions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestProQuestions()
    {
        return $this->test_proQuestions;
    }
}