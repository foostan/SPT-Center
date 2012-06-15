<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_ProQuestion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_ProQuestion
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
	 * @var Test_Problem $test_problem
	 *
	 * @ORM\ManyToOne(targetEntity="Test_Problem", inversedBy="test_proQuestions")
	 * @ORM\JoinColumn(name="test_problem_id", referencedColumnName="id")
	 */
    private $test_problem;

	/**
	 * @var Test_ProQueType $test_proQueType
	 *
	 * @ORM\ManyToOne(targetEntity="Test_ProQueType", inversedBy="test_proQuestions")
	 * @ORM\JoinColumn(name="test_proQueType_id", referencedColumnName="id")
     * @Assert\NotBlank()
	 */
    private $test_proQueType;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_ProQueChoice", mappedBy="test_proQuestion")
	 */
	private $test_proQueChoices;

	public function __construct()
	{
		$this->test_proQueChoices = new ArrayCollection();
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
     * Set test_problem
     *
     * @param OSPT\TestBundle\Entity\Test_Problem $testProblem
     */
    public function setTestProblem(\OSPT\TestBundle\Entity\Test_Problem $testProblem)
    {
        $this->test_problem = $testProblem;
    }

    /**
     * Get test_problem
     *
     * @return OSPT\TestBundle\Entity\Test_Problem 
     */
    public function getTestProblem()
    {
        return $this->test_problem;
    }

    /**
     * Set test_proQueType
     *
     * @param OSPT\TestBundle\Entity\Test_ProQueType $testProQueType
     */
    public function setTestProQueType(\OSPT\TestBundle\Entity\Test_ProQueType $testProQueType)
    {
        $this->test_proQueType = $testProQueType;
    }

    /**
     * Get test_proQueType
     *
     * @return OSPT\TestBundle\Entity\Test_ProQueType 
     */
    public function getTestProQueType()
    {
        return $this->test_proQueType;
    }

    /**
     * Add test_proQueChoices
     *
     * @param OSPT\TestBundle\Entity\Test_ProQueChoice $testProQueChoices
     */
    public function addTest_ProQueChoice(\OSPT\TestBundle\Entity\Test_ProQueChoice $testProQueChoices)
    {
        $this->test_proQueChoices[] = $testProQueChoices;
    }

    /**
     * Set test_proQueChoices
     *
     * @param ArrayCollection $testProQueChoices
     */
    public function setTestProQueChoices($testProQueChoices)
    {
        $this->test_proQueChoices = $testProQueChoices;
    }

    /**
     * Get test_proQueChoices
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestProQueChoices()
    {
        return $this->test_proQueChoices;
    }
}
