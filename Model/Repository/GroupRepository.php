<?php
namespace Model\Repository;

use Doctrine\ORM\EntityRepository;
use Model\Entity\User;

class GroupRepository extends EntityRepository
{

//     public function getGroupsByUser($userID)
//     {
//         $qb = $this->getEntityManager()->createQueryBuilder();
        
//         $query = $qb->select("g")
//             ->from(User::class, "u")
//             ->innerJoin("u.groups", "g")
//             ->where("u.id = :id")
//             ->setParameter("id", $userID)
//             ->getQuery();

//         $res = $query->getResult();
        
//         foreach ($res as $r){
//         echo get_class($r);
//         }
        
//         die("asdf");
//     }
}

