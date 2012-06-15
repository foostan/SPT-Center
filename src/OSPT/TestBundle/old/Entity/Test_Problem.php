<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_Problem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_Problem
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
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="test_problems")
	 * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
	 */
    private $test;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_ProQuestion", mappedBy="test_problem")
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
     * Add test_proQuestions
     *
     * @param OSPT\TestBundle\Entity\Test_ProQuestion $testProQuestions
     */
    public function addTest_ProQuestion(\OSPT\TestBundle\Entity\Test_ProQuestion $testProQuestions)
    {
        $this->test_proQuestions[] = $testProQuestions;
    }

    /**
     * Set test_proQuestions
     *
     * @param ArrayCollection $testProQuestions
     */
    public function setTestProQuestions($testProQuestions)
    {
        $this->test_proQuestions = $testProQuestions;
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