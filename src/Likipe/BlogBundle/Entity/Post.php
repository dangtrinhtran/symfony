<?php

namespace Likipe\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likipe\BlogBundle\Entity\Post
 * 
 * @ORM\Table(name="post")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Likipe\BlogBundle\Repository\PostRepository")
 */
class Post {

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string $author
	 *
	 * @ORM\Column(name="author_post", type="string", length=255)
	 */
	protected $author;

	/**
	 * @var string $title
	 *
	 * @ORM\Column(name="title_post", type="string", length=255)
	 */
	protected $title;

	/**
	 * @var string $content
	 *
	 * @ORM\Column(name="content_post", type="text", nullable=true)
	 */
	protected $content;

	/**
	 * @var datetime $created
	 *
	 * @ORM\Column(name="created_post", type="datetime")
	 */
	protected $created;

	/**
	 * @var datetime $updated
	 *
	 * @ORM\Column(name="updated_post", type="datetime")
	 */
	protected $updated;

	/**
	 * @var integer $delete
	 *
	 * @ORM\Column(name="delete_post", type="integer")
	 */
	protected $delete;

	/**
	 * @ORM\ManyToOne(targetEntity="Blog", inversedBy="posts")
	 * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
	 */
	protected $blog;
	

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
	 * Set author
	 *
	 * @param string $author
	 * @return Post
	 */
	public function setAuthor($author) {
		$this->author = $author;

		return $this;
	}

	/**
	 * Get author
	 *
	 * @return string 
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return Post
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
	 * Set content
	 *
	 * @param string $content
	 * @return Post
	 */
	public function setContent($content) {
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string 
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Post
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
	 * Set delete
	 *
	 * @param boolean $delete
	 * @return Post
	 */
	public function setDelete($delete) {
		$this->delete = $delete;

		return $this;
	}

	/**
	 * Get delete
	 *
	 * @return boolean 
	 */
	public function getDelete() {
		return $this->delete;
	}

	/**
	 * Set updated
	 *
	 * @param \DateTime $updated
	 * @return Post
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
	 * Set blog
	 *
	 * @param \Likipe\BlogBundle\Entity\Blog $blog
	 * @return Post
	 */
	public function setBlog(\Likipe\BlogBundle\Entity\Blog $blog = null) {
		$this->blog = $blog;

		return $this;
	}

	/**
	 * Get blog
	 *
	 * @return \Likipe\BlogBundle\Entity\Blog 
	 */
	public function getBlog() {
		return $this->blog;
	}

}