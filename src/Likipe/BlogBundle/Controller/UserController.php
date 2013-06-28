<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Likipe\BlogBundle\Form\User\UserType;
use Likipe\BlogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

	public function indexAction() {
		
		$oAllUsers = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->findAll();

		if (!$oAllUsers) {
			$this->get( 'session' )
					->getFlashBag()
					->add( 'user_does_not_exist', $this->get('translator')->trans('User does not exist!') );
			
			return $this->render('LikipeBlogBundle:Default:default.html.twig');
		}

		return $this->render('LikipeBlogBundle:User:index.html.twig', array(
					'oUsers' => $oAllUsers
				)
		);
	}
	
	public function deniedAction() {
        return $this->render( 'EcommerceBackendBundle:Default:denied.html.twig');
    }

	public function addAction( Request $request ) {
		
		$oUser = new User();
		$form = $this->createForm(
				new UserType(),
				$oUser
			);
		/**
		 * Form for symfony3
		 */
		$form->handleRequest($request);
		if($form->isValid()) {
				
				$em = $this->getDoctrine()->getManager();
				$em->persist($oUser);
				$em->flush();
				$this->get('session')->getFlashBag()->add('user_success', $this->get('translator')->trans('Create successfully user: ' . $oUser->getUsername()));

				return $this->redirect($this->generateUrl('LikipeBlogBundle_User_index'));
		}
		
		return $this->render('LikipeBlogBundle:User:add.html.twig', array(
			'user' => $form->createView()
		));
	}
}
