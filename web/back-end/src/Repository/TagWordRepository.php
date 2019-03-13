<?php

namespace App\Repository;

use App\Entity\TagWord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TagWord|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagWord|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagWord[]    findAll()
 * @method TagWord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagWordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TagWord::class);
    }

    // /**
    //  * @return TagWord[] Returns an array of TagWord objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TagWord
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
