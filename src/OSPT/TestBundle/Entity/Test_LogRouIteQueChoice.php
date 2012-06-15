<?php

namespace OSPT\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OSPT\TestBundle\Entity\Test_LogRouIteQueChoice
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test_LogRouIteQueChoice
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
	 * @var $test_logRouIteQuestion
	 *
	 * @ORM\ManyToOne(targetEntity="Test_LogRouIteQuestion", inversedBy="test_logRouIteQueChoices")
	 * @ORM\JoinColumn(name="test_rogRouQuestion_id", referencedColumnName="id")
	 */
    private $test_logRouIteQuestion;

	/**
	 * @var $test_iteQueChoice
	 *
	 * @ORM\ManyToOne(targetEntity="Test_IteQueChoice", inversedBy="test_logRouIteQueChoices")
	 * @ORM\JoinColumn(name="test_iteQueChoice_id", referencedColumnName="id")
	 */
    private $test_iteQueChoice;

	public function __construct()
	{
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
     * Set test_logRouIteQuestion
     *
     * @param OSPT\TestBundle\Entity\Test_LogRouIteQuestion $testLogRouIteQuestion
     */
    public function setTestLogRouIteQuestion(\OSPT\TestBundle\Entity\Test_LogRouIteQuestion $testLogRouIteQuestion)
    {
        $this->test_logRouIteQuestion = $testLogRouIteQuestion;
    }

    /**
     * Get test_logRouIteQuestion
     *
     * @return OSPT\TestBundle\Entity\Test_LogRouIteQuestion 
     */
    public function getTestLogRouIteQuestion()
    {
        return $this->test_logRouIteQuestion;
    }

    /**
     * Set test_iteQueChoice
     *
     * @param OSPT\TestBundle\Entity\Test_IteQueChoice $testIteQueChoice
     */
    public function setTestIteQueChoice(\OSPT\TestBundle\Entity\Test_IteQueChoice $testIteQueChoice)
    {
        $this->test_iteQueChoice = $testIteQueChoice;
    }

    /**
     * Get test_iteQueChoice
     *
     * @return OSPT\TestBundle\Entity\Test_IteQueChoice 
     */
    public function getTestIteQueChoice()
    {
        return $this->test_iteQueChoice;
    }
}