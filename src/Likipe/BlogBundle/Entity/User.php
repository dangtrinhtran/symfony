<?php

// src/Likipe/BlogBundle/Entity/User.php

namespace Likipe\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Likipe\BlogBundle\Entity\User
 * 
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Likipe\BlogBundle\Repository\UserRepository")
 * @DoctrineAssert\UniqueEntity(fields="username", message="Username already exists.")
 * @DoctrineAssert\UniqueEntity(fields="email", message="Email already exists.")
 */
class User implements UserInterface {

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string $firstname
	 * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
	 */
	private $firstname;
	
	/**
	 * @var string $lastname
	 * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
	 */
	private $lastname;
	
	
	/**
	 * @var string $username
	 * @ORM\Column(name="username", type="string", length=25, unique=true)
	 */
	private $username;

	/**
	 * @var string $salt
	 * @ORM\Column(name="salt", type="string", length=32)
	 */
	private $salt;

	/**
	 * @var string $password
	 * @ORM\Column(name="password", type="string", length=40)
	 */
	private $password;
	
	/**
	 * @var string $role
	 * @ORM\Column(name="role", type="string", length=255)
	 */
	private $role;

	/**
	 * @var string $email
	 * @ORM\Column(name="email", type="string", length=60, unique=true)
	 */
	private $email;

	/**
	 * @var boolean $email
	 * @ORM\Column(name="is_active", type="boolean")
	 */
	private $isActive;
	
	public function __construct() {
		$this->isActive = true;
		$this->salt = md5(uniqid(null, true));
	}

	/**
	 * @inheritDoc
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @inheritDoc
	 */
	public function getSalt() {
		return $this->salt;
	}

	/**
	 * @inheritDoc
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @inheritDoc
	 */
	public function getRoles() {
		return array($this->getRole());
	}

	/**
	 * @inheritDoc
	 */
	public function eraseCredentials() {
		
	}

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set username
	 *
	 * @param string $username
	 * @return User
	 */
	public function setUsername($username) {
		$this->username = $username;

		return $this;
	}

	/**
	 * Set salt
	 *
	 * @param string $salt
	 * @return User
	 */
	public function setSalt($salt) {
		$this->salt = $salt;

		return $this;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 * @return User
	 */
	public function setPassword($password) {
		$this->password = $password;

		return $this;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return User
	 */
	public function setEmail($email) {
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string 
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Set isActive
	 *
	 * @param boolean $isActive
	 * @return User
	 */
	public function setIsActive($isActive) {
		$this->isActive = $isActive;

		return $this;
	}

	/**
	 * Get isActive
	 *
	 * @return boolean 
	 */
	public function getIsActive() {
		return $this->isActive;
	}


    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set roles
     *
     * @param string $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    
        return $this;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
}