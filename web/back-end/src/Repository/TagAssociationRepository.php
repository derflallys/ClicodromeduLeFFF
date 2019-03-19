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


    public function findByCategory($id)
    {
        return $this->createQueryBuilder('t')
            ->join('t.category','category')
            ->andWhere('category.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }


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
