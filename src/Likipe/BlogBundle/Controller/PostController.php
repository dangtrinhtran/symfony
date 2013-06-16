<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Likipe\BlogBundle\Form\Post\PostType;
use Likipe\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller {
	public function indexAction() {
		return $this->render('LikipeBlogBundle:Post:index.html.twig');
		
	}
	
	public function addAction(Request $request) {
		$oPost = new Post();
		$form = $this->createForm(new PostType(), $oPost);
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
			return $this->redirect( $this->generateUrl( 'LikipeBlogBundle_Post_index' ));
		}
		
		return $this->render('LikipeBlogBundle:Post:add.html.twig', array(
			'post' => $form->createView()
		));
	}	
}
