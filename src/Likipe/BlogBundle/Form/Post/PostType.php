<?php

// src/Likipe/BlogBundle/Form/Post/PostType.php

namespace Likipe\BlogBundle\Form\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		#$sValueAuthor = (!empty($options['sAuthor'])) ? $options['sAuthor'] : '';
		$builder->add('author', 'text', array(
			'label' => 'Author post: ',
			'required' => false
		));
		
		#$sValueTitle = (!empty($options['sTitle'])) ? $options['sTitle'] : '';
		$builder->add('title', 'text', array(
			'label' => 'Title post: '
		));

		#$sValueContent = (!empty($options['sContent'])) ? $options['sContent'] : '';
		$builder->add('content', 'ckeditor', array(
			'label' => 'Content post: ',
			'required' => false
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