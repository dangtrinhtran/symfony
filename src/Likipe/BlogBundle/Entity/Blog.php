<?php

namespace Likipe\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likipe\BlogBundle\Entity\Blog
 * 
 * @ORM\Table(name="blog")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Likipe\BlogBundle\Repository\BlogRepository")
 */
class Blog {

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string $title
	 *
	 * @ORM\Column(name="title_blog", type="string", length=255)
	 */
	protected $title;

	/**
	 * @var string $description
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	protected $description;

	/**
	 * @var datetime $created
	 *
	 * @ORM\Column(name="created_blog", type="datetime")
	 */
	protected $created;

	/**
	 * @var datetime $updated
	 *
	 * @ORM\Column(name="updated_blog", type="datetime")
	 */
	protected $updated;

	/**
	 * @var integer $delete
	 *
	 * @ORM\Column(name="delete_blog", type="integer")
	 */
	protected $delete;

	/**
	 * @ORM\OneToMany(targetEntity="Post", mappedBy="blog", cascade={"remove"})
	 */
	protected $posts;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->posts = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	/**
	 * @ORM\PrePersist
	 */
	public function prePersist() {
		$this->setCreated(new \DateTime('now'));
		$this->setUpdated(new \DateTime('now'));
		$this->setDelete(0);
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function preUpdate() {
		$this->setUpdated(new \DateTime('now'));
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
	 * Set title
	 *
	 * @param string $title
	 * @return Blog
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string 
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 * @return Blog
	 */
	public function setDescription($description) {
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string 
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Blog
	 */
	public function setCreated($created) {
		$this->created = $created;

		return $this;
	}

	/**
	 * Get created
	 *
	 * @return \DateTime 
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * Set updated
	 *
	 * @param \DateTime $updated
	 * @return Blog
	 */
	public function setUpdated($updated) {
		$this->updated = $updated;

		return $this;
	}

	/**
	 * Get updated
	 *
	 * @return \DateTime 
	 */
	public function getUpdated() {
		return $this->updated;
	}

	/**
	 * Set delete
	 *
	 * @param integer $delete
	 * @return Blog
	 */
	public function setDelete($delete) {
		$this->delete = $delete;

		return $this;
	}

	/**
	 * Get delete
	 *
	 * @return integer 
	 */
	public function getDelete() {
		return $this->delete;
	}

	/**
	 * Add posts
	 *
	 * @param \Likipe\BlogBundle\Entity\Post $posts
	 * @return Blog
	 */
	public function addPost(\Likipe\BlogBundle\Entity\Post $posts) {
		$this->posts[] = $posts;

		return $this;
	}

	/**
	 * Remove posts
	 *
	 * @param \Likipe\BlogBundle\Entity\Post $posts
	 */
	public function removePost(\Likipe\BlogBundle\Entity\Post $posts) {
		$this->posts->removeElement($posts);
	}

	/**
	 * Get posts
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getPosts() {
		return $this->posts;
	}

}