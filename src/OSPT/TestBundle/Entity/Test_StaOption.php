<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_State
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_StaOption
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
     * @var string $value
     *
     * @ORM\Column(name="value", type="text")
     * @Assert\NotBlank()
     */
    private $value;

	/**
	 * @var Test_State $test_state
	 *
	 * @ORM\ManyToOne(targetEntity="Test_State", inversedBy="test_staOptions")
	 * @ORM\JoinColumn(name="test_state_id", referencedColumnName="id")
	 */
    private $test_state;


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
     * Set value
     *
     * @param text $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return text 
     */
    public function getValue()
    {
        return $this->value;
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
}