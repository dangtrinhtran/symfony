<?php

namespace Likipe\BlogBundle\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Likipe\BlogBundle\Entity\Post;

class SlugListener {

	public function prePersist(LifecycleEventArgs $args) {
		$entity = $args->getEntity();

		if ($entity instanceof Post) {
			
			$sSlug = $entity->getSlug();
			$sTitle = $entity->getTitle();
			if (empty($sSlug)) :
				$sToSlug = $sTitle . ' ' . time('now');
			else :
				$sToSlug = $sSlug . ' ' . time('now');
			endif;
			$slug = $this->slugify($sToSlug);
			$entity->setSlug($slug);
			
			$entity->setCreated(new \DateTime('now'));
			$entity->setUpdated(new \DateTime('now'));
			$entity->setDelete(0);
		}
	}
	
	public function slugify($string) {
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}

}