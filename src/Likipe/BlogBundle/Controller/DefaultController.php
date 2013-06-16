<?php

namespace Likipe\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

	public function indexAction() {
		return $this->render('LikipeBlogBundle:Default:index.html.twig');
	}

}
