<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * OSPT\TestBundle\Entity\Test
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("name")
 */
class Test
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
     * @ORM\Column(name="name", type="string", unique="true", length=255)
     * @Assert\NotBlank()
     * @Assert\MinLength(2)
     * @Assert\MaxLength(50)
     */
    private $name;

    /**
     * @var string $controller
     *
     * @ORM\Column(name="controller", type="text")
     * @Assert\NotBlank()
     * @Assert\MinLength(10)
     */
    private $controller;

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
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_Item", mappedBy="test")
	 */
	private $test_items;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_State", mappedBy="test")
	 */
	private $test_states;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_Log", mappedBy="test")
	 */
	private $test_logs;


	public function __construct()
	{
		$this->test_items = new ArrayCollection();
		$this->test_states = new ArrayCollection();
        $this->test_logs = new ArrayCollection();
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
     * Set controller
     *
     * @param text $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Get controller
     *
     * @return text 
     */
    public function getController()
    {
        return $this->controller;
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
     * Add test_items
     *
     * @param OSPT\TestBundle\Entity\Test_Item $test_items
     */
    public function addTest_Item(\OSPT\TestBundle\Entity\Test_Item $test_items)
    {
        $this->test_items[] = $test_items;
    }

    /**
     * Get test_items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestItems()
    {
        return $this->test_items;
    }

    /**
     * Add test_states
     *
     * @param OSPT\TestBundle\Entity\Test_State $testStates
     */
    public function addTest_State(\OSPT\TestBundle\Entity\Test_State $testStates)
    {
        $this->test_states[] = $testStates;
    }

    /**
     * Get test_states
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestStates()
    {
        return $this->test_states;
    }

	/**
	 * Get test_state
	 *
	 * @param $name
	 * @return OSPT\TestBundle\Entity\Test_State $testState
	 */
	public function getTestState($name)
	{
		foreach($this->test_states as $test_state){
			if($test_state->getName() === $name){
				return $test_state;
			}
			
		}
		return null;
	}

    /**
     * Add test_logs
     *
     * @param OSPT\TestBundle\Entity\Test_Log $testLogs
     */
    public function addTest_Log(\OSPT\TestBundle\Entity\Test_Log $testLogs)
    {
        $this->test_logs[] = $testLogs;
    }

    /**
     * Get test_logs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestLogs()
    {
        return $this->test_logs;
    }
}