<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_State
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_State
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
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="test_states")
	 * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
	 */
    private $test;

	/**
	 * @var Test_StaType $test_staType
	 *
	 * @ORM\ManyToOne(targetEntity="Test_StaType", inversedBy="test_states")
	 * @ORM\JoinColumn(name="test_staType_id", referencedColumnName="id")
     * @Assert\NotBlank()
	 */
    private $test_staType;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_StaOption", mappedBy="test_state")
	 */
	private $test_staOptions;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_LogRoute", mappedBy="test_state")
	 */
	private $test_logRoutes;


	public function __construct()
	{
		$this->test_staOptions = new ArrayCollection();
		$this->test_logRoutes = new ArrayCollection();
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
     * Set test_staType
     *
     * @param OSPT\TestBundle\Entity\Test_StaType $testStaType
     */
    public function setTestStaType(\OSPT\TestBundle\Entity\Test_StaType $testStaType)
    {
        $this->test_staType = $testStaType;
    }

    /**
     * Get test_staType
     *
     * @return OSPT\TestBundle\Entity\Test_StaType 
     */
    public function getTestStaType()
    {
        return $this->test_staType;
    }

    /**
     * Add test_staOptions
     *
     * @param OSPT\TestBundle\Entity\Test_StaOption $testStaOptions
     */
    public function addTest_StaOption(\OSPT\TestBundle\Entity\Test_StaOption $testStaOptions)
    {
        $this->test_staOptions[] = $testStaOptions;
    }

    /**
     * Set test_staOptions
     *
     * @param ArrayCollection $testStaOptions
     */
    public function setTestStaOptions($testStaOptions)
    {
        $this->test_staOptions = $testStaOptions;
    }

    /**
     * Get test_staOptions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTestStaOptions()
    {
        return $this->test_staOptions;
    }

	/**
	 * exist test_staOption
	 *
	 * @param name
	 * @return boolean
	 */
	public function existTestStaOption($name)
	{
		foreach($this->test_staOptions as $option){
			if($option->getName() === $name){
				return true;
			}
		}
		return false;
	}

	/**
	 * Get test_staOption
	 * 
	 * @param name
	 * @return text value
	 */
	public function getTestStaOption($name)
	{
		foreach($this->test_staOptions as $option){
			if($option->getName() === $name){
				return $option->getValue();
			}
		}
		return null;
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