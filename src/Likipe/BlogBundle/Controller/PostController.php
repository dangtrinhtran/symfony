<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Likipe\BlogBundle\Form\Post\PostType;
use Likipe\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller {
	public function indexAction($page) {
		$iLimit = 5;
		$iOffset = $page * $iLimit - $iLimit;
		$oPost = $this->getDoctrine()
			->getRepository('LikipeBlogBundle:Post')
			->findBy(array(), array('id' => 'DESC'), $iLimit, $iOffset); //1: conditions, 2: order, 3:limit, 4: offset
		
		
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
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($oPost);
			$em->flush();
			$this->get( 'session' )->getFlashBag()->add( 'success_note', $this->get('translator')->trans('Create successfully post: ' . $oPost->getTitle()) );
			
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Post_index' ));
		}
		
		return $this->render('LikipeBlogBundle:Post:add.html.twig', array(
			'post' => $form->createView()
		));
	}
	
	public function editAction( Request $request, $iPostId ) {
		
		$em = $this->getDoctrine()->getManager();
		$oPost = $em->getRepository('LikipeBlogBundle:Post')->find($iPostId);
		if (!$oPost) {
			throw $this->createNotFoundException(
					'No post found for id ' . $iPostId
			);
		}
		
		$form = $this->createForm(
				new PostType(),
				$oPost
			);
		/**
		 * Form for symfony3
		 */
		$form->handleRequest($request);
		if($form->isValid()) {
			
			//$em->persist($oPost);
			
			$em->flush();
			$this->get( 'session' )->getFlashBag()->add( 'success', $this->get('translator')->trans('Edit successfully post: ' . $oPost->getTitle()) );
			
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Post_index' ));
		}
		
		return $this->render('LikipeBlogBundle:Post:edit.html.twig', array(
			'post' => $form->createView(),
			'iPostId'	=> $iPostId
		));
	}
	
	public function deleteAction( $iPostId ) {
		$em = $this->getDoctrine()->getManager();
		$oPost = $em->getRepository('LikipeBlogBundle:Post')->find($iPostId);
		
		if (!$oPost) {
			throw $this->createNotFoundException(
					'No post found for id ' . $iPostId
			);
		}
		
		$em->remove($oPost);
		$em->flush();
		
		return $this->redirect($this->generateUrl('LikipeBlogBundle_Post_index'));
	}
}
