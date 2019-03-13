<?php

namespace App\Repository;

use App\Entity\TagAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TagAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagAssociation[]    findAll()
 * @method TagAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagAssociationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TagAssociation::class);
    }

    // /**
    //  * @return TagAssociation[] Returns an array of TagAssociation objects
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
    public function findOneBySomeField($value): ?TagAssociation
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
