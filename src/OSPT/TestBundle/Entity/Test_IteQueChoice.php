<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_IteQueChoice
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_IteQueChoice
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
     * @var text $statement
     *
     * @ORM\Column(name="statement", type="text")
     * @Assert\NotBlank()
     */
    private $statement;

    /**
     * @var float $pointRate
     *
     * @ORM\Column(name="pointRate", type="float")
     * @Assert\NotBlank()
     */
    private $pointRate;


	/**
	 * @var Test_IteQuestion $test_iteQuestion
	 *
	 * @ORM\ManyToOne(targetEntity="Test_IteQuestion", inversedBy="test_iteQueChoices")
	 * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
	 */
    private $test_iteQuestion;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_LogRouIteQueChoice", mappedBy="test_logRouIteQuestion")
	 */
	private $test_logRouIteQueChoices;

	public function __construct()
	{
		$this->test_logRouIteQueChoices = new ArrayCollection();
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
     * Set statement
     *
     * @param text $statement
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;
    }

    /**
     * Get statement
     *
     * @return text 
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Set pointRate
     *
     * @param float $pointRate
     */
    public function setPointRate($pointRate)
    {
        $this->pointRate = $pointRate;
    }

    /**
     * Get pointRate
     *
     * @return float 
     */
    public function getPointRate()
    {
        return $this->pointRate;
    }

    /**
     * Set test_iteQuestion
     *
     * @param OSPT\TestBundle\Entity\Test_IteQuestion $testIteQuestion
     */
    public function setTestIteQuestion(\OSPT\TestBundle\Entity\Test_IteQuestion $testIteQuestion)
    {
        $this->test_iteQuestion = $testIteQuestion;
    }

    /**
     * Get test_iteQuestion
     *
     * @return OSPT\TestBundle\Entity\Test_IteQuestion 
     */
    public function getTestIteQuestion()
    {
        return $this->test_iteQuestion;
    }

    /**
     * Add test_logRouIteQueChoices
     *
     * @param OSPT\TestBundle\Entity\Test_LogRouIteQueChoice $testLogRouIteQueChoices
     */
    public function addTest_LogRouIteQueChoice(\OSPT\TestBundle\Entity\Test_LogRouIteQueChoice $testLogRouIteQueChoices)
    {
        $this->test_logRouIteQueChoices[] = $testLogRouIteQueChoices;
    }

    /**
     * Get test_logRouIteQueChoices
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestLogRouIteQueChoices()
    {
        return $this->test_logRouIteQueChoices;
    }
}
