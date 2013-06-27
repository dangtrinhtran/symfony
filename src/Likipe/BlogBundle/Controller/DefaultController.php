<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultController extends Controller {

	public function indexAction() {
		
		$oUser = $this->container->get('security.context')->getToken()->getUser();
		if (!is_object($oUser) || !$oUser instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
		return $this->render('LikipeBlogBundle:Default:index.html.twig');
	}

}
