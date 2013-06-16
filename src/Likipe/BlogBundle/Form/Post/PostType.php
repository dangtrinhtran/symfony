<?php

// src/Likipe/BlogBundle/Form/Post/PostType.php

namespace Likipe\BlogBundle\Form\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('author', 'text', array(
			'label' => 'Author post: ',
			'required' => false
		));

		$builder->add('title', 'text', array(
			'label' => 'Title post: ',
			'required' => true
		));

		$builder->add('content', 'textarea', array(
			'label' => 'Content post: ',
			'required' => true
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			/*'sAuthor' => NULL,
			'sTitle' => NULL,
			'sContent' => NULL*/
			'data_class' => 'Likipe\BlogBundle\Entity\Post'
		));
	}

	public function getName() {
		return 'post';
	}
}