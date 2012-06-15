<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_LogRouItem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_LogRouItem
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
	 * @var $test_logRoute
	 *
	 * @ORM\ManyToOne(targetEntity="Test_LogRoute", inversedBy="test_logRouItems")
	 * @ORM\JoinColumn(name="test_rogRoute_id", referencedColumnName="id")
	 */
    private $test_logRoute;

	/**
	 * @var $test_item
	 *
	 * @ORM\ManyToOne(targetEntity="Test_Item", inversedBy="test_logRouItems")
	 * @ORM\JoinColumn(name="test_iteQuestion_id", referencedColumnName="id")
	 */
    private $test_item;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_logRouIteQuestion", mappedBy="test_logRouItem")
	 */
	private $test_logRouIteQuestions;

	public function __construct()
	{
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
     * Set test_logRoute
     *
     * @param OSPT\TestBundle\Entity\Test_LogRoute $testLogRoute
     */
    public function setTestLogRoute(\OSPT\TestBundle\Entity\Test_LogRoute $testLogRoute)
    {
        $this->test_logRoute = $testLogRoute;
    }

    /**
     * Get test_logRoute
     *
     * @return OSPT\TestBundle\Entity\Test_LogRoute 
     */
    public function getTestLogRoute()
    {
        return $this->test_logRoute;
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
     * Add test_logRouIteQuestions
     *
     * @param OSPT\TestBundle\Entity\Test_logRouIteQuestion $testLogRouIteQuestions
     */
    public function addTest_logRouIteQuestion(\OSPT\TestBundle\Entity\Test_logRouIteQuestion $testLogRouIteQuestions)
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
