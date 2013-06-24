<?php

// src/Likipe/BlogBundle/Form/Blog/BlogType.php

namespace Likipe\BlogBundle\Form\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->add('title', 'text', array(
			'label' => 'Title blog: '
		));

		$builder->add('description', 'textarea', array(
			'label' => 'Description blog: ',
			'attr'	=> array('class'	=> 'description-blog span6'),
			'required' => false
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'Likipe\BlogBundle\Entity\Blog'
		));
	}

	public function getName() {
		return 'blog';
	}
}