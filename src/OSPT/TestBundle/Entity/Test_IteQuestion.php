<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_IteQuestion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_IteQuestion
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
	 * @var Test_Item $test_item
	 *
	 * @ORM\ManyToOne(targetEntity="Test_Item", inversedBy="test_iteQuestions")
	 * @ORM\JoinColumn(name="test_item_id", referencedColumnName="id")
	 */
    private $test_item;

	/**
	 * @var Test_IteQueType $test_iteQueType
	 *
	 * @ORM\ManyToOne(targetEntity="Test_IteQueType", inversedBy="test_iteQuestions")
	 * @ORM\JoinColumn(name="test_iteQueType_id", referencedColumnName="id")
     * @Assert\NotBlank()
	 */
    private $test_iteQueType;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_IteQueChoice", mappedBy="test_iteQuestion")
	 */
	private $test_iteQueChoices;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_LogRouIteQuestion", mappedBy="test_iteQuestion")
	 */
	private $test_logRouIteQuestions;

	public function __construct()
	{
		$this->test_iteQueChoices = new ArrayCollection();
		$this->test_logRouIteQuestions = new ArrayCollection();
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
     * Set test_item
     *
     * @param OSPT\TestBundle\Entity\Test_Item $testItem
     */
    public function setTestItem(\OSPT\TestBundle\Entity\Test_Item $testItem)
    {
        $this->test_item = $testItem;
    }

    /**
     * Get test_item
     *
     * @return OSPT\TestBundle\Entity\Test_Item 
     */
    public function getTestItem()
    {
        return $this->test_item;
    }

    /**
     * Set test_iteQueType
     *
     * @param OSPT\TestBundle\Entity\Test_IteQueType $testIteQueType
     */
    public function setTestIteQueType(\OSPT\TestBundle\Entity\Test_IteQueType $testIteQueType)
    {
        $this->test_iteQueType = $testIteQueType;
    }

    /**
     * Get test_iteQueType
     *
     * @return OSPT\TestBundle\Entity\Test_IteQueType 
     */
    public function getTestIteQueType()
    {
        return $this->test_iteQueType;
    }

    /**
     * Add test_iteQueChoices
     *
     * @param OSPT\TestBundle\Entity\Test_IteQueChoice $testIteQueChoices
     */
    public function addTest_IteQueChoice(\OSPT\TestBundle\Entity\Test_IteQueChoice $testIteQueChoices)
    {
        $this->test_iteQueChoices[] = $testIteQueChoices;
    }

    /**
     * Set test_iteQueChoices
     *
     * @param ArrayCollection $testIteQueChoices
     */
    public function setTestIteQueChoices($testIteQueChoices)
    {
        $this->test_iteQueChoices = $testIteQueChoices;
    }

    /**
     * Get test_iteQueChoices
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestIteQueChoices()
    {
        return $this->test_iteQueChoices;
    }

    /**
     * Add test_logRouIteQuestions
     *
     * @param OSPT\TestBundle\Entity\Test_LogRouIteQuestion $testLogRouIteQuestions
     */
    public function addTest_LogRouIteQuestion(\OSPT\TestBundle\Entity\Test_LogRouIteQuestion $testLogRouIteQuestions)
    {
        $this->test_logRouIteQuestions[] = $testLogRouIteQuestions;
    }

    /**
     * Get test_logRouIteQuestions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestLogRouIteQuestions()
    {
        return $this->test_logRouIteQuestions;
    }
}
