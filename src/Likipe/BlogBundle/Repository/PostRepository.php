<?php

namespace Likipe\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Likipe\BlogBundle\Repository\PostRepository;
 */
class PostRepository extends EntityRepository {

	public function getActivePosts($iLimit = null, $iOffset = null) {

		$oSql = $this->getEntityManager()->createQueryBuilder('p')
				->select('p')
				->from('LikipeBlogBundle:Post', 'p')
				->where('p.delete = 0')
				->orderBy('p.created', 'DESC')
				->setMaxResults($iLimit)
				->setFirstResult($iOffset)
				->getQuery();
		return $oSql->getResult();
	}

}