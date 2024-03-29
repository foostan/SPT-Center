<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_ProQueChoice
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_ProQueChoice
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
     * @var float $pointRate
     *
     * @ORM\Column(name="pointRate", type="float")
     * @Assert\NotBlank()
     */
    private $pointRate;


	/**
	 * @var Test_ProQuestion $test_proQuestion
	 *
	 * @ORM\ManyToOne(targetEntity="Test_ProQuestion", inversedBy="test_proQueChoices")
	 * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
	 */
    private $test_proQuestion;

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
     * Set pointRate
     *
     * @param float $pointRate
     */
    public function setPointRate($pointRate)
    {
        $this->pointRate = $pointRate;
    }

    /**
     * Get pointRate
     *
     * @return float 
     */
    public function getPointRate()
    {
        return $this->pointRate;
    }

    /**
     * Set test_proQuestion
     *
     * @param OSPT\TestBundle\Entity\Test_ProQuestion $testProQuestion
     */
    public function setTestProQuestion(\OSPT\TestBundle\Entity\Test_ProQuestion $testProQuestion)
    {
        $this->test_proQuestion = $testProQuestion;
    }

    /**
     * Get test_proQuestion
     *
     * @return OSPT\TestBundle\Entity\Test_ProQuestion 
     */
    public function getTestProQuestion()
    {
        return $this->test_proQuestion;
    }
}