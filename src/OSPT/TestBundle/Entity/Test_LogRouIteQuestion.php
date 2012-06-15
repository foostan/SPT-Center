<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_LogRouIteQuestion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_LogRouIteQuestion
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
     * @var integer $score
     *
     * @ORM\Column(name="score", type="float")
     */
    private $score;

	/**
	 * @var $test_logRouItem
	 *
	 * @ORM\ManyToOne(targetEntity="Test_LogRouItem", inversedBy="test_logRouIteQuestions")
	 * @ORM\JoinColumn(name="test_rogRouItem_id", referencedColumnName="id")
	 */
    private $test_logRouItem;

	/**
	 * @var $test_iteQuestion
	 *
	 * @ORM\ManyToOne(targetEntity="Test_IteQuestion", inversedBy="test_logRouIteQuestions")
	 * @ORM\JoinColumn(name="test_iteQuestion_id", referencedColumnName="id")
	 */
    private $test_iteQuestion;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_logRouIteQueChoice", mappedBy="test_logRouIteQuestion")
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
     * Set score
     *
     * @param float $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * Get score
     *
     * @return float 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set test_logRouItem
     *
     * @param OSPT\TestBundle\Entity\Test_LogRouItem $testLogRouItem
     */
    public function setTestLogRouItem(\OSPT\TestBundle\Entity\Test_LogRouItem $testLogRouItem)
    {
        $this->test_logRouItem = $testLogRouItem;
    }

    /**
     * Get test_logRouItem
     *
     * @return OSPT\TestBundle\Entity\Test_LogRouItem 
     */
    public function getTestLogRouItem()
    {
        return $this->test_logRouItem;
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
     * @param OSPT\TestBundle\Entity\Test_logRouIteQueChoice $testLogRouIteQueChoices
     */
    public function addTest_logRouIteQueChoice(\OSPT\TestBundle\Entity\Test_logRouIteQueChoice $testLogRouIteQueChoices)
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