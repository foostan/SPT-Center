<?php

namespace Acme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Acme\UserBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

     /**
     * @var ArrayCollection $userRoles
     *
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="UserRole",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $userRoles;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="OSPT\TestBundle\Entity\Test_Log", mappedBy="user")
	 */
	private $test_logs;

	/**
     * construct
     */
    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

  	/**
     * @return ArrayCollection|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

	/**
	 * @param string $roleName
	 * @return bool
	 */
	public function haveRole($roleName){

		$roles = $this->getUserRoles()->toArray();
		foreach( $roles as $role ){
			if( $role->getName() === $roleName ) return true;
		}

		return false;
	}

    /**
     * Saltを返すメソッド、パスワードのエンコード方式がplaintextの場合
     * Saltを定義しても意味がないので、これも空文字が返るようにする
     *
     * @return string
     */
    public function getSalt()
    {
        return '';
    }
    
    /**
     * 取得されたくないようなユーザーデータとかを削除するメソッドらしい
     */
    public function eraseCredentials()
    {
        
    }
    
    /**
     * 同一ユーザーであるかの判定
     *
     * @return boolean
     */
    public function equals(UserInterface $user)
    {
        return $this->getUsername() == $user->getUsername();
    }


    /**
     * Add userRoles
     *
     * @param Acme\UserBundle\Entity\Role $userRoles
     */
    public function addRole(\Acme\UserBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;
    }

    /**
     * Add test_logs
     *
     * @param Acme\UserBundle\Entity\Test_Log $testLogs
     */
    public function addTest_Log(\Acme\UserBundle\Entity\Test_Log $testLogs)
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