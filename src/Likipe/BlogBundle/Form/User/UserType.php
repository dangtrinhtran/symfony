<?php

// src/Likipe/BlogBundle/Form/Blog/BlogType.php

namespace Likipe\BlogBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {
	
	/**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->add('firstname', 'text', array(
			'label' => 'First name: ',
			'required' => false
		));
		
		$builder->add('lastname', 'text', array(
			'label' => 'Last name: ',
			'required' => false
		));
		
		$builder->add('username', 'text', array(
			'label' => 'Username: '
		));
		
		$builder->add('password', 'repeated', array(
			'type' => 'password',
			'invalid_message' => 'The password fields must match.',
			'options' => array('attr' => array('class' => 'password-field')),
			'first_options'  => array('label' => 'Password: '),
			'second_options' => array('label' => 'Repeat Password: ')
		));
		
		$builder->add('role', 'choice', array(
			'label' => 'Role: ',
			'choices'   => array('ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_EDITOR' => 'ROLE_EDITOR'),
			'empty_value' => false
		));
		
		$builder->add('Email', 'email', array(
			'label' => 'Email: '
		));
	}

	/**
     * {@inheritdoc}
     */
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'Likipe\BlogBundle\Entity\User',
			'csrf_protection'   => false,
		));
	}

	/**
     * {@inheritdoc}
     */
	public function getName() {
		return 'user';
	}
}