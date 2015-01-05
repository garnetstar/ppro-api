<?php
namespace Model\Repository;

use Doctrine\ORM\EntityRepository;
use Model\Entity\Task;

/**
 *
 * @author Jan Macháček
 *        
 */
class TaskRepository extends EntityRepository
{

    /**
     * 
     * @param unknown $sort
     * @param string $statusID
     * @param string $assigneeID
     * @param unknown $groupIDs
     * @return array
     */
    public function getAll($sort, $statusID = null, $assigneeID = null, $groupIDs = array())
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $query = $qb->select("t", "s", "a", "g")
            ->from(Task::class, "t")
            ->innerJoin("t.status", "s")
            ->innerJoin("t.assignee", "a")
            ->innerJoin("a.groups", "g")
            ->orderBy("t.created", $sort);
        
        if (! empty($statusID)) {
            $query->andWhere("s.id =:statusID")->setParameter("statusID", $statusID);
        }
        
        if (! empty($assigneeID)) {
            $query->andWhere("a.id =:assigneeID")->setParameter("assigneeID", 2);
        }
        
        if (! empty($groupIDs)) {
            $query->andWhere($qb->expr()
                ->in("g.id", $groupIDs));
        }
        
        return $query->getQuery()->getResult();
    }
}