<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_LogRoute
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_LogRoute
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
     * @var datetime $startedAt
     *
     * @ORM\Column(name="startedAt", type="datetime")
     */
    private $startedAt;

    /**
     * @var datetime $finishedAt
     *
     * @ORM\Column(name="finishedAt", type="datetime")
     */
    private $finishedAt;

	/**
	 * @var Test $test_log
	 *
	 * @ORM\ManyToOne(targetEntity="Test_Log", inversedBy="test_logRoutes")
	 * @ORM\JoinColumn(name="test_rog_id", referencedColumnName="id")
	 */
    private $test_log;

	/**
	 * @var Test $test_log
	 *
	 * @ORM\ManyToOne(targetEntity="Test_State", inversedBy="test_logRoutes")
	 * @ORM\JoinColumn(name="test_state_id", referencedColumnName="id")
	 */
    private $test_state;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_LogRouItem", mappedBy="test_logRoute")
	 */
	private $test_logRouItems;

	public function __construct()
	{
		$this->test_logRouItems = new ArrayCollection();
		$this->startedAt(new \DateTime());
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
     * Set startedAt
     *
     * @param datetime $startedAt
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;
    }

    /**
     * Get startedAt
     *
     * @return datetime 
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set finishedAt
     *
     * @param datetime $finishedAt
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;
    }

    /**
     * Get finishedAt
     *
     * @return datetime 
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Set test_log
     *
     * @param OSPT\TestBundle\Entity\Test_Log $testLog
     */
    public function setTestLog(\OSPT\TestBundle\Entity\Test_Log $testLog)
    {
        $this->test_log = $testLog;
    }

    /**
     * Get test_log
     *
     * @return OSPT\TestBundle\Entity\Test_Log 
     */
    public function getTestLog()
    {
        return $this->test_log;
    }

    /**
     * Set test_state
     *
     * @param OSPT\TestBundle\Entity\Test_State $testState
     */
    public function setTestState(\OSPT\TestBundle\Entity\Test_State $testState)
    {
        $this->test_state = $testState;
    }

    /**
     * Get test_state
     *
     * @return OSPT\TestBundle\Entity\Test_State 
     */
    public function getTestState()
    {
        return $this->test_state;
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