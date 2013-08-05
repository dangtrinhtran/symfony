<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Likipe\BlogBundle\Form\Blog\BlogType;
use Likipe\BlogBundle\Entity\Blog;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller {

	public function indexAction() {

		$aAllBlogs = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->getActiveBlogs();

		if (!$aAllBlogs) {
			$this->get( 'session' )
					->getFlashBag()
					->add( 'blog_does_not_exist', $this->get('translator')
							->trans('Blog does not exist!') );
			
			#return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Blog_index' ));
			return $this->render('LikipeBlogBundle:Default:default.html.twig');
		}

		return $this->render('LikipeBlogBundle:Blog:index.html.twig', array(
					'aBlogs' => $aAllBlogs
				)
		);
	}

	public function addAction( Request $request ) {
		
		$oBlog = new Blog();
		$form = $this->createForm(
				new BlogType(),
				$oBlog
			);
		/**
		 * Form for symfony3
		 */
		$form->handleRequest($request);
		if($form->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($oBlog);
			$em->flush();
			$this->get( 'session' )->getFlashBag()->add( 'blog_success', $this->get('translator')->trans('Create successfully blog: ' . $oBlog->getTitle()) );
			
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Blog_index' ));
		}
		
		return $this->render('LikipeBlogBundle:Blog:add.html.twig', array(
			'blog' => $form->createView()
		));
	}

	public function editAction( Request $request, $iBlogId ) {
		
		$em = $this->getDoctrine()->getManager();
		$oBlog = $em->getRepository('LikipeBlogBundle:Blog')->find($iBlogId);
		
		if (!$oBlog) {
			throw $this->createNotFoundException(
					'No blog found for id ' . $iBlogId
			);
		}
		
		$form = $this->createForm(
				new BlogType(),
				$oBlog
			);
		/**
		 * Form for symfony3
		 */
		$form->handleRequest($request);
		if($form->isValid()) {
			$em->flush();
			$this->get( 'session' )->getFlashBag()->add( 'blog_success', $this->get('translator')->trans('Edit successfully blog: ' . $oBlog->getTitle()) );
			
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Blog_index' ));
		}
		
		return $this->render('LikipeBlogBundle:Blog:edit.html.twig', array(
			'blog' => $form->createView(),
			'iIdBlog'	=> $iBlogId
		));
	}

	public function deleteAction( $iBlogId ) {
		
		$em = $this->getDoctrine()->getManager();
		$oBlog = $em->getRepository('LikipeBlogBundle:Blog')->find($iBlogId);
		
		if (!$oBlog) {
			throw $this->createNotFoundException(
					'No blog found for id ' . $iBlogId
			);
		}
		//When remove blog => delete all the posts in this blog.
		
		$oBlog->setDelete(1);
		#$oPosts = $em->getRepository('LikipeBlogBundle:Post')->find($iBlogId);
		#var_dump($oPosts);exit;
		$em->flush();
		$this->get( 'session' )->getFlashBag()->add( 'blog_success', $this->get('translator')->trans('Delete successfully blog: ' . $oBlog->getTitle()) );
		
		return $this->redirect($this->generateUrl('LikipeBlogBundle_Blog_index'));
	}

}
