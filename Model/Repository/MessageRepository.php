<?php
namespace Model\Repository;

use Doctrine\ORM\EntityRepository;
use Model\Entity\Message;

/**
 *
 * @author Jan Macháček
 *        
 */
class MessageRepository extends EntityRepository
{
    
    public function getMessagesToSend()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $query = $qb->select("m", "t")
            ->from(Message::class, "m")
            ->innerJoin("m.task", "t")
            ->where("m.processed IS NULL")
            ->orderBy("m.created", "ASC");
        
        return $query->getQuery()->getResult();
    }

}