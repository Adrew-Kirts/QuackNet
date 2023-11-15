<?php

namespace App\Repository;

use App\Entity\Quack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quack>
 *
 * @method Quack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quack[]    findAll()
 * @method Quack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quack::class);
    }

    /**
     * @return Quack[] Returns an array of Quack objects
     */
    public function findByUser($user): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.user = :user')
            ->setParameter('user', $user)
            ->orderBy('q.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByOrdered(): array
    {
        return $this->createQueryBuilder('q')
            ->orderBy('q.id', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Quack
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
