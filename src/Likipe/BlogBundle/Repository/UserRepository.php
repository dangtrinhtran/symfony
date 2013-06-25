<?php

namespace Likipe\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Likipe\BlogBundle\Repository\UserRepository;
 */
class UserRepository extends EntityRepository {
	
	public function checkUsername($sUsername = null) {

		$oSql = $this->getEntityManager()->createQueryBuilder('u')
				->select('u')
				->from('LikipeBlogBundle:User', 'u')
				->where('u.username = '. $sUsername)
				->getQuery();
		#echo $oSql->getSQL();
		return $oSql->getResult();
	}
	
	public function checkEmail($sEmail = null) {

		$oSql = $this->getEntityManager()->createQueryBuilder('u')
				->select('u')
				->from('LikipeBlogBundle:User', 'u')
				->where('u.email = '. $sEmail)
				->getQuery();
		#echo $oSql->getSQL();
		return $oSql->getResult();
	}
}
