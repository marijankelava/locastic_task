<?php

namespace App\Repository;

use App\Entity\Race;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Race>
 *
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Race $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Race $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAll(){

        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.results', 'res')
            ->addSelect('res.id, res.fullName, res.raceTime, res.placement, res.distance');
            //->orderBy('res.placement', 'ASC');

        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function findByDistance(string $distance): array
    {     
            $qb = $this->createQueryBuilder('r')
              ->leftJoin('r.results', 'res')
              ->addSelect('res.id, res.fullName, res.raceTime, res.placement, res.distance');
            $qb->where($qb->expr()->like('res.distance', ':val'))
               ->setParameter('val', '%' . $distance . '%' );
              //->orderBy('res.placement', 'ASC');

            return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}
