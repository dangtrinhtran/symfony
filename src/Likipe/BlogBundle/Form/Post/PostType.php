<?php

// src/Likipe/BlogBundle/Form/Post/PostType.php

namespace Likipe\BlogBundle\Form\Post;

use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class PostType extends AbstractType {
	
	private $securityContext;

	public function __construct(SecurityContext $securityContext) {
		$this->securityContext = $securityContext;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		// grab the user, do a quick sanity check that one exists
        $user = $this->securityContext->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'The PostType cannot be used without an authenticated user!'
            );
        }
		
		$username = mb_convert_case($user->getUsername(), MB_CASE_TITLE, "UTF-8");
		
		$builder->add('author', 'text', array(
			'label' => 'Author post: ',
			'attr'	=> array('value'	=> $username),
			'required' => false
		));
		
		
		$builder->add('title', 'text', array(
			'label' => 'Title post: '
		));
		
		$builder->add('slug', 'text', array(
			'label' => 'Slug post: ',
			'required' => false
		));
		
		/**
		 * Entity Field Type
		 */
		$builder->add('blog', 'entity', array(
			'label' => 'Blog: ',
			'class'	=> 'LikipeBlogBundle:Blog',
			'property' => 'title',
			'query_builder' => function(EntityRepository $er) {
				return $er->createQueryBuilder('b')
						->where('b.delete = 0')
						->orderBy('b.title', 'DESC');
			}
		));

		/**
		 * Using CKEditor content
		 */
		$builder->add('content', 'ckeditor', array(
			'label' => 'Content post: ',
			'required' => false
		));
		
		/**
		 * Upload file
		 */
		
		$builder->add('file', 'file', array(
			'label' => 'Featured image: ',
			'attr'	=> array('accept' => 'image/*'),//Specify that the server accepts only image files in the file upload.
			'required'  => false
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'Likipe\BlogBundle\Entity\Post'
		));
	}

	public function getName() {
		return 'post';
	}
}