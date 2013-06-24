<?php

namespace Likipe\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Likipe\BlogBundle\Repository\PostRepository;
 */
class PostRepository extends EntityRepository {

	public function getActivePosts($iLimit = null, $iOffset = null) {

		#$qb = $this->createQuery('SELECT j FROM post j WHERE j.delete_post = 0 ORDER BY j.created_post DESC');
		#$qb->setParameter('date', date('Y-m-d H:i:s', time()));

		/* $qb = $this->createQueryBuilder( 'p' )
		  ->select( 'p' )
		  ->from( 'LikipeBlogBundle:Post', 'p' )
		  ->where('p.delete_post = 0')
		  ->setParameter('date', date('Y-m-d H:i:s', time())); */
		#->orderBy('p.created_post', 'DESC');
		/* $qb = Doctrine_Query::create()
		  ->select('p')
		  ->from('post p')
		  ->setParameter('date', date('Y-m-d H:i:s', time()))
		  ->orderby('p.created_post DESC'); */
		#$qb = $this->getEntityManager()->createQueryBuilder('p');
		
	
		#foreach ($qb as $sSql) {
		$qb = $this->getEntityManager()->createQueryBuilder('p')
				->select('p')
				->from('LikipeBlogBundle:Post', 'p')
				->where('p.delete = 0')
				->orderBy('p.created', 'DESC')
				->setMaxResults($iLimit)
				->setFirstResult($iOffset)
				->getQuery();
			
			
		#}
		#var_dump($qb->getResult());exit;
		
		return $qb->getResult();
	}

}
