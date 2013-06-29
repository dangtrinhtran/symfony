<?php

namespace Likipe\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

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
	 * @var string $slug
	 *
	 * @ORM\Column(name="slug_post", type="string", length=255)
	 */
	protected $slug;

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
	 * @var string $featuredimage
	 * @ORM\Column(name="featured_image", type="string", length=255, nullable=true)
	 */
	protected $featuredimage;
	
	/**
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;

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


    /**
	 * Set featuredimage
	 *
	 * @param string $featuredimage
	 * @return Post
	 */
	public function setFeaturedimage($featuredimage) {
		$this->featuredimage = $featuredimage;

		return $this;
	}

	/**
	 * Get featuredimage
	 *
	 * @return string 
	 */
	public function getFeaturedimage() {
		return $this->featuredimage;
	}

	/**
	 * Sets file.
	 *
	 * @param UploadedFile $file
	 */
	public function setFile(UploadedFile $file = null) {
		$this->file = $file;
	}

	/**
	 * Get file.
	 *
	 * @return UploadedFile
	 */
	public function getFile() {
		return $this->file;
	}
	
    /**
	 * Set slug
	 *
	 * @param string $slug
	 * @return Post
	 */
	public function setSlug($slug) {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string 
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * The absolute directory path where uploaded.
	 * Documents should be saved.
	 * @author Rony <rony@likipe.se>
	 * @return string
	 */
	protected function getUploadRootDir() {
		return __DIR__ . '/../../../../web/' . $this->getUploadDir();
	}
	
	/**
	 * Get directory path when upload.
	 * @author Rony <rony@likipe.se>
	 * @return string
	 */
	protected function getUploadRoot() {
		return __DIR__ . '/../../../../web/';
	}

	/**
	 * Get rid of the __DIR__ so it doesn't screw up
	 * When displaying uploaded doc/image in the view.
	 * @author Rony <rony@likipe.se>
	 * @return string
	 */
	protected function getUploadDir() {
		return 'uploads/documents';
	}
	
	/**
	 * The upload() method will take advantage of the UploadedFile object, 
	 * which is what's returned after a file field is submitted.
	 * @author Rony <rony@likipe.se>
	 */
	public function upload() {
		// the file property can be empty if the field is not required
		if (null === $this->getFile()) {
			return;
		}

		// use the original file name here but you should
		// sanitize it at least to avoid any security issues
		// move takes the target directory and then the
		// target filename to move to
		
		
		$fileName = pathinfo($this->getFile()->getClientOriginalName());
		$fileUpload = time('now') . '.' . $fileName['extension'];
		
		$this->getFile()->move(
				$this->getUploadRootDir(), $fileUpload
		);

		// set the path property to the filename where you've saved the file
		$this->featuredimage = $this->getUploadDir() . '/' . $fileUpload;

		// clean up the file property as you won't need it anymore
		$this->file = null;
	}
	
	/**
	 * @ORM\PostRemove()
	 * PostRemove(): After remove => automatic call function removeUpload().
	 * Remove file upload.
	 * @author Rony <rony@likipe.se>
	 * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
	 */
	public function removeUpload() {
		if (empty($this->featuredimage)) return;
		$file = $this->getUploadRoot() . $this->featuredimage;
		
		if ($file) {
			if (file_exists($file) && is_writable($file)) 
				unlink ($file);
		}
	}
}