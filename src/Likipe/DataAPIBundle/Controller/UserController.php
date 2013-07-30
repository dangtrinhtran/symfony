<?php

namespace Likipe\DataAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Likipe\BlogBundle\Entity\User;
use Likipe\BlogBundle\Form\User\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

class UserController extends Controller {

	/**
	 * Get name
	 *
	 * @param string $name
	 * @return View view instance
	 *
	 * @Rest\View
	 */
	public function indexAction($name = NULL) {
		$view = View::create(array('name' => $name))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($name)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'index'));
		return $this->get('fos_rest.view_handler')->handle($view);
		#return $this->handleView($view);
	}
	
	/**
	 * Get all users
	 *
	 * @return View view instance
	 *
	 * @Rest\View
	 */
	public function cgetUsersAction() {
		
		$oAllUsers = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->findAll();
		if(!$oAllUsers)
			throw new NotFoundHttpException('User not found');
		
		$view = View::create(array('users' => $oAllUsers))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oAllUsers)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'user'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Get user by ID
	 *
	 * @param string $iIdUser
	 * @return View view instance
	 *
	 * @Rest\View
	 */
	public function getUserByIdAction($iIdUser) {
		
		$oUser = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->find($iIdUser);
		if(!$oUser)
			throw new NotFoundHttpException('User not found');
		
		$view = View::create(array('user' => $oUser))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oUser)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'user-id'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Get blog
	 *
	 * @return View view instance
	 *
	 * @Rest\View
	 */
	public function getBlogsAction() {
		
		$oAllBlogs = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->findAll();
		
		if(!$oAllBlogs)
			throw new NotFoundHttpException('Blog not found');
		
		$view = View::create(array('blogs' => $oAllBlogs))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oAllBlogs)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'blog'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Put blog
	 *
	 * @return View view instance
	 *
	 * @Rest\View
	 */
	public function putBlogAction() {
		
		$oAllBlogs = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->findAll();
		
		if(!$oAllBlogs)
			throw new NotFoundHttpException('Blog not found');
		
		$view = View::create(array('blogs' => $oAllBlogs))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oAllBlogs)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'blog'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Create a new resource
	 * Post new user
	 * 
	 * @return View view instance
	 *
	 * @Rest\View
	 */
	public function postUserAction(Request $request) {
		$user = new User();
		$statusCode = $user ? 201 : 204;
		
		$form = $this->createForm(new UserType(), $user);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			$response = new Response();
			$response->setStatusCode($statusCode);
			if (201 === $statusCode) {
				return $this->redirect( $this->generateUrl( 'Likipe_DataAPI_User_Id', array('iIdUser' => $user->getId()) ));
			}
		}

		return View::create($form, 400);
	}
}