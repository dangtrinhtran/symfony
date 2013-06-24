<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Likipe\BlogBundle\Form\Post\PostType;
use Likipe\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller {
	
	public function indexAction($iPage) {
		/*$iLimit = 5;
		$iOffset = $page * $iLimit - $iLimit;*/
		$aAllPosts = $this->getDoctrine()
			->getRepository('LikipeBlogBundle:Post')
			->findAll();	
			#->findBy(array(), array('id' => 'DESC'), $iLimit, $iOffset); //1: conditions, 2: order, 3:limit, 4: offset
		
		if (!$aAllPosts) {
			$this->get( 'session' )
					->getFlashBag()
					->add( 'post_success', $this->get('translator')
							->trans('Post does not exist!') );
			
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Post_index' ));
		}
		$iTotalPosts = count($aAllPosts);
		$iPostsPerPage = $this->container->getParameter('max_post_on_post');
		$fLastPage = ceil($iTotalPosts / $iPostsPerPage);
		$iPreviousPage = $iPage > 1 ? $iPage - 1 : 1;
		$iNextPage = $iPage < $fLastPage ? $iPage + 1 : $fLastPage;
		
		$em = $this->getDoctrine()->getManager();
		$iOffset = $iPage * $iPostsPerPage - $iPostsPerPage;
		$aPostPagination = $em->getRepository('LikipeBlogBundle:Post')
            ->getActivePosts($iPostsPerPage, $iOffset);
		
		return $this->render('LikipeBlogBundle:Post:index.html.twig', 
				array(
					'aPosts' => $aPostPagination,
					'fLastPage' => $fLastPage,
					'iPreviousPage' => $iPreviousPage,
					'iCurrentPage' => $iPage,
					'iNextPage' => $iNextPage,
					'iTotalPosts' => $iTotalPosts
				)
		);
	}
	
	public function addAction(Request $request) {
		$oPost = new Post();
		
		$form = $this->createForm(
				new PostType(),
				$oPost);
		/**
		 * Form for symfony3
		 */
		$form->handleRequest($request);
		if($form->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			#var_dump($oPost);exit;
			
			$em->persist($oPost);
			$em->flush();
			$this->get( 'session' )->getFlashBag()->add( 'post_success', $this->get('translator')->trans('Create successfully post: ' . $oPost->getTitle()) );
			
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
			$this->get( 'session' )->getFlashBag()->add( 'post_success', $this->get('translator')->trans('Edit successfully post: ' . $oPost->getTitle()) );
			
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
		$this->get( 'session' )->getFlashBag()->add( 'post_success', $this->get('translator')->trans('Delete successfully post: ' . $oPost->getTitle()) );
		return $this->redirect($this->generateUrl('LikipeBlogBundle_Post_index'));
	}
}
