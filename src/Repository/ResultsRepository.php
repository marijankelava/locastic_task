<?php

namespace App\Repository;

use App\Entity\Results;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Results>
 *
 * @method Results|null find($id, $lockMode = null, $lockVersion = null)
 * @method Results|null findOneBy(array $criteria, array $orderBy = null)
 * @method Results[]    findAll()
 * @method Results[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Results::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Results $entity, bool $flush = true): void
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
    public function remove(Results $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Results[] Returns an array of Results objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Results
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getResults(string $distance): array
    {     
            $qb = $this->createQueryBuilder('r');
            $qb->where($qb->expr()->like('r.distance', ':val'))
               ->setParameter('val', '%' . $distance . '%' )->orderBy('r.raceTime', 'ASC');

            return $qb->getQuery()->getResult();
    }
}
