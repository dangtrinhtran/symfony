<?php

namespace Likipe\DataAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Likipe\BlogBundle\Entity\User;
use Likipe\BlogBundle\Form\User\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

class UserController extends Controller {

	/**
	 * Get name
	 * @param string $name
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *		description="Get name"
	 * )
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
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Returns a collection of User",
	 *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when somehting else is not found"
     *         }
     *     }
     * )
	 */
	public function cgetUsersAction() {
		
		$oAllUsers = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->findAll();
		if(!$oAllUsers) {
			$view = View::create();
            $view->setStatusCode(204);
            return $view;
		}
		
		$view = View::create(array('users' => $oAllUsers))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oAllUsers)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'user'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Get user by ID
	 * @param integer $iIdUser
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Get user by ID",
	 *     statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when somehting else is not found"
     *         }
     *     }
     * )
	 */
	public function getUserByIdAction($iIdUser) {
		
		$oUser = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->find($iIdUser);
		if(!$oUser) {
			$view = View::create();
            $view->setStatusCode(204);
            return $view;
		}
		
		$view = View::create(array('user' => $oUser))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oUser)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'user-id'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Get blog
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Returns a collection of Blog",
	 *     statusCodes={
     *         200="Returned when successful"
     *     }
     * )
	 */
	public function getBlogsAction() {
		
		$oAllBlogs = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->findAll();
		
		if(!$oAllBlogs) {
			$view = View::create();
            $view->setStatusCode(204);
            return $view;
		}
		
		$view = View::create(array('blogs' => $oAllBlogs))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oAllBlogs)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'blog'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Get blog by ID
	 * @param integer $iIdBlog
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Get blog by ID",
	 *     statusCodes={
     *         200="Returned when successful",
     *         204="Returned when the blog is not found"
     *     }
     * )
	 */
	public function getBlogByIdAction($iIdBlog) {
		
		$oBlog = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->find($iIdBlog);
		if(!$oBlog) {
			$view = View::create();
            $view->setStatusCode(204);
            return $view;
		}
		
		$view = View::create(array('blog' => $oBlog))
				->setStatusCode(200)
				->setEngine('twig')
				->setData($oBlog)
				->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'blog-id'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	
	/**
	 * Update blog
	 * @param integer $iIdBlog
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Update Blog",
	 *     input="Likipe\BlogBundle\Form\Blog\BlogType",
     *     output="Likipe\DataAPIBundle\UserController",
	 *     statusCodes={
     *         200="Returned when successful",
	 *         204="Returned when the blog is not found",
	 *         400="Returned when data error",
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function putBlogAction(Request $request, $iIdBlog) {
		$em = $this->getDoctrine()->getManager();
		$oBlog = $em->getRepository('LikipeBlogBundle:Blog')->find($iIdBlog);
		
		if (!$oBlog) {
			$view = View::create();
            $view->setStatusCode(204);
            return $view;
		}
		/**
		 * If use form $request->get('blog'): blog is name
		 */
		$data = json_decode($request->getContent());
		
		if($data === false) {
			$view = View::create();
            $view->setStatusCode(400);
            return $view;
		}

		if( ! is_array($data)) {
			$view = View::create();
            $view->setStatusCode(400);
            return $view;
		}
		
		foreach($data as $blog) {
			if( ! is_object($blog)) {
				$view = View::create();
				$view->setStatusCode(400);
				return $view;
			}
			$oBlog->setTitle($blog->title);
			$oBlog->setDescription($blog->description);
		}
		$em->flush();
		$view = View::create(array('blog' => $oBlog))
				->setStatusCode(200)
				//->setEngine('twig')
				->setData($oBlog);
				//->setTemplate(new TemplateReference('LikipeDataAPIBundle', 'Default', 'blog-id'));
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Add new user
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Add new user",
	 *     input="Likipe\BlogBundle\Form\User\UserType",
     *     output="Likipe\DataAPIBundle\UserController",
	 *     statusCodes={
     *         201="Returned when successful",
	 *         204="Returned when not successful",
     *         400="Returned when the user already exists",
	 *         500="Internal Server Error"
     *     }
     * )
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