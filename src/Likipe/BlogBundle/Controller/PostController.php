<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Likipe\BlogBundle\Form\Post\PostType;
use Likipe\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller {
	public function indexAction() {

		$em = $this->getDoctrine()->getEntityManager();
		$oBlog = $em->getRepository('LikipeBlogBundle:Post');
		
		$oPost = $this->getDoctrine()
			->getRepository('LikipeBlogBundle:Post')
			->findAll();
		
		if (!$oPost) {
			throw $this->createNotFoundException(
					'No product found'
			);
		}
		#var_dump($oPost);
		return $this->render('LikipeBlogBundle:Post:index.html.twig', 
				array('posts' => $oPost)
		);
	}
	
	public function addAction(Request $request) {
		$oPost = new Post();
		$form = $this->createForm(
				new PostType(),
				$oPost
			);
		/**
		 * Form for symfony3
		 */
		$form->handleRequest($request);
		if($form->isValid()) {
			$oPost->setCreated(new \DateTime('now'));
			$oPost->setUpdated(new \DateTime('now'));
			$oPost->setDelete(0);
			var_dump($oPost);
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($oPost);
			$em->flush();
			$this->get( 'session' )->getFlashBag()->add( 'success', $this->get('translator')->trans('Create successfully post: ' . $oPost->getTitle()) );
			
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Post_index' ));
		}
		
		return $this->render('LikipeBlogBundle:Post:add.html.twig', array(
			'post' => $form->createView()
		));
	}
	
	public function editAction( $iPostId ) {
		
		return $this->render('LikipeBlogBundle:Post:edit.html.twig', array(
			#'post' => $form->createView(),
			'postId'	=> $iPostId
		));
	}
	
	public function deleteAction() {

		return $this->redirect($this->generateUrl('LikipeBlogBundle_Post_index'));
	}
}
