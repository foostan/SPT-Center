<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_Log
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_Log
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
	 * @var Test $test
	 *
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="test_logs")
	 * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
	 */
    private $test;

	/**
	 * @var User $user
	 *
	 * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="test_logs")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
    private $user;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_LogRoute", mappedBy="test_log")
	 */
	private $test_logRoutes;

	public function __construct()
	{
		$this->test_staOptions = new ArrayCollection();
		$this->test_logRoutes = new ArrayCollection();
		$this->startedAt = new \DateTime();
		$this->finishedAt = new \DateTime();
		$this->score = 0;
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
     * Set user
     *
	 * @param Acme\UserBundle\Entity\User $user
     */
    public function setUser(\Acme\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Acme\UserBUndle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add test_logRoutes
     *
     * @param OSPT\TestBundle\Entity\Test_LogRoute $testLogRoutes
     */
    public function addTest_LogRoute(\OSPT\TestBundle\Entity\Test_LogRoute $testLogRoutes)
    {
        $this->test_logRoutes[] = $testLogRoutes;
    }

    /**
     * Get test_logRoutes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestLogRoutes()
    {
        return $this->test_logRoutes;
    }
}
