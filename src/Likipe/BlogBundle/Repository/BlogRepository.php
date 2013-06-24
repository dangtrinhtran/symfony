<?php

namespace Likipe\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Likipe\BlogBundle\Repository\BlogRepository;
 */
class BlogRepository extends EntityRepository {
	public function getActiveBlogs($iLimit = null, $iOffset = null) {

		$oSql = $this->getEntityManager()->createQueryBuilder('p')
				->select('b')
				->from('LikipeBlogBundle:Blog', 'b')
				->where('b.delete = 0')
				->orderBy('b.created', 'DESC')
				->setMaxResults($iLimit)
				->setFirstResult($iOffset)
				->getQuery();
		return $oSql->getResult();
	}
}
