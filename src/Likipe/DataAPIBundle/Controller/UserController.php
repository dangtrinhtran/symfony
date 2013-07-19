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
     * @Rest\View
     */
	public function getUsersAction() {
		
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
	
	public function newUsersAction(Request $request) {
		$user = new User();
		$statusCode = $user ? 201 : 204;
		
		$form = $this->createForm(new UserType(), $user);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			$view = View::create(array('user' => $user))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($user)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'user-id'));
			return $this->get('fos_rest.view_handler')->handle($view);
		
//			$response = new Response();
//			$response->setStatusCode($statusCode);
//			// set the `Location` header only when creating new resources
//			if (201 === $statusCode) {
//				$response->headers->set('Location', $this->generateUrl(
//						'Likipe_DataAPI_User_Id', array('iIdUser' => $user->getId()), true));
//			}
//			return $response;
		}

		return View::create($form, 400);
	}
}
#curl -v -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"user":{"username":"foo", "email": "foo@example.org", "password":"hahaha"}}' http://localhost/symfony/web/app_dev.php/api/user/new