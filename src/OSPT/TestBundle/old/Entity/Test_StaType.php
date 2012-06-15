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
class Test_StaType
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
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="Test_State", mappedBy="test_staType")
	 */
	private $test_states;

	public function __construct()
	{
		$this->test_states = new ArrayCollection();
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
}