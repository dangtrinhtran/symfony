<?php

namespace Likipe\DataAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Likipe\BlogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
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
     *         },
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function cgetUsersAction() {
		
		$oAllUsers = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->findAll();
		if(!$oAllUsers) {
			return View::create(
				array('error' => array('User does not exist!.')), 404
			);
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
     *           "Returned when something else is not found"
     *         },
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function getUserByIdAction($iIdUser) {
		
		$oUser = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:User')
				->find($iIdUser);
		if(!$oUser) {
			return View::create(
				array('error' => sprintf('No user found for id %d.', $iIdUser)), 404
			);
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
     *         200="Returned when successful",
	 *         404="Returned when Blog does not exist!",
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function getBlogsAction() {
		
		$oAllBlogs = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->findAll();
		
		if(!$oAllBlogs) {
			return View::create(
				array('error' => array('Blog does not exist!.')), 404
			);
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
     *         404="Returned when the blog is not found",
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function getBlogByIdAction($iIdBlog) {
		
		$oBlog = $this->getDoctrine()
				->getRepository('LikipeBlogBundle:Blog')
				->find($iIdBlog);
		if(!$oBlog) {
			return View::create(
				array('error' => sprintf('No blog found for id %d.', $iIdBlog)), 404
			);
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
	 *         404="Returned when the blog is not found",
	 *         400="Returned when data error",
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function putBlogAction(Request $request, $iIdBlog) {
		$em = $this->getDoctrine()->getManager();
		$oBlog = $em->getRepository('LikipeBlogBundle:Blog')->find($iIdBlog);
		
		if (!$oBlog) {
			return View::create(
				array('error' => sprintf('No blog found for id %d.', $iIdBlog)), 404
			);
		}
		/**
		 * If use form $request->get('blog'): blog is name
		 */
		$data = json_decode($request->getContent());
		
		if($data === false) {
			return View::create(
				array('error' => array('Error parsing JSON data in request body.')), 400
			);
		}

		if( ! is_array($data)) {
			return View::create(
				array('error' => array('JSON in request body must be an array.')), 400
			);
		}
		
		foreach($data as $blog) {
			if( ! is_object($blog)) {
				return View::create(
					array('error' => array('Blog in data array must be objects.')), 400
				);
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
     *         200="Returned when successful",
     *         400="Returned when data error",
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function postUserAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$user = new User();
		$dataRequest = $request->request->get('user');
		
		if( ! is_array($dataRequest)) {
			return View::create(
                array('error' => array('Data in request body must be an array.')), 400
            );
		}
		
		if(empty($dataRequest)) {
			return View::create(
                array('error' => array('Parameters is not empty.')), 400
            );
		}
		
		if (empty($dataRequest['username']) && empty($dataRequest['Email']) && empty($dataRequest['password'])) {
			return View::create(
                array('errors' => array('Invalid parameters.')), 400
            );
		} else {
			if ($dataRequest['password']['first'] !== $dataRequest['password']['second']) {
				return View::create(
					array('errors' => array('Password invalid.')), 400
				);
			}
		}
		
		$user->setFirstname($dataRequest['firstname']);
		$user->setLastname($dataRequest['lastname']);
		$user->setUsername($dataRequest['username']);
		$user->setPassword($dataRequest['password']['first']);
		$user->setRole($dataRequest['role']);
		$user->setEmail($dataRequest['Email']);
		$em->persist($user);
		$em->flush();
		
		$dataResponse = array(
				'firstname'    => $dataRequest['firstname'],
				'lastname'   => $dataRequest['lastname'],
				'username' => $dataRequest['username'],
				'email'		=> $dataRequest['Email']
			);
		$view = View::create(array('user' => $dataResponse))
				->setStatusCode(200)
				->setData($dataResponse);
		return $this->get('fos_rest.view_handler')->handle($view);
	}
	
	/**
	 * Delete post
	 * @param integer $iIdPost
	 * @return View view instance
	 * @Rest\View
	 * @ApiDoc(
	 *     description="Delete post",
	 *     statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the post is not found",
	 *         500="Internal Server Error"
     *     }
     * )
	 */
	public function deletePostAction($iIdPost) {
		
		$em = $this->getDoctrine()->getManager();
		$oPost = $em->getRepository('LikipeBlogBundle:Post')->find($iIdPost);
		
		if (!$oPost) {
			return View::create(
				array('error' => sprintf('No post found for id %d.', $iIdPost)), 404
			);
		}
		$em->remove($oPost);
		$em->flush();
		return View::create(
			array('success' => sprintf('Delete successfully post id %d', $iIdPost)), 200
		);
	}
}