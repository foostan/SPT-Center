<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_Item
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_Item
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
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

	/**
	 * @var Test $test
	 *
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="test_items")
	 * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
	 */
    private $test;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_IteQuestion", mappedBy="test_item")
	 */
	private $test_iteQuestions;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_LogRouItem", mappedBy="test_item")
	 */
	private $test_logRouItems;

	public function __construct()
	{
		$this->test_iteQuestions = new ArrayCollection();
		$this->test_logRouItems = new ArrayCollection();
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
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set test
     *
     * @param OSPT\TestBundle\Entity\Test $test
     */
    public function setTest(\OSPT\TestBundle\Entity\Test $test)
    {
        $this->test = $test;
    }

    /**
     * Get test
     *
     * @return OSPT\TestBundle\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
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
     * Set test_iteQuestions
     *
     * @param ArrayCollection $testIteQuestions
     */
    public function setTestIteQuestions($testIteQuestions)
    {
        $this->test_iteQuestions = $testIteQuestions;
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

    /**
     * Add test_logRouItems
     *
     * @param OSPT\TestBundle\Entity\Test_LogRouItem $testLogRouItems
     */
    public function addTest_LogRouItem(\OSPT\TestBundle\Entity\Test_LogRouItem $testLogRouItems)
    {
        $this->test_logRouItems[] = $testLogRouItems;
    }

    /**
     * Get test_logRouItems
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestLogRouItems()
    {
        return $this->test_logRouItems;
    }
}
