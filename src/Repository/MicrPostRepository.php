<?php

namespace App\Repository;

use App\Entity\MicrPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MicrPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicrPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicrPost[]    findAll()
 * @method MicrPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicrPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MicrPost::class);
    }

//    /**
//     * @return MicrPost[] Returns an array of MicrPost objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MicrPost
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
