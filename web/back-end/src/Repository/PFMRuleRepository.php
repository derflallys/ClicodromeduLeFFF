<?php

namespace App\Repository;

use App\Entity\PFMRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PFMRule|null find($id, $lockMode = null, $lockVersion = null)
 * @method PFMRule|null findOneBy(array $criteria, array $orderBy = null)
 * @method PFMRule[]    findAll()
 * @method PFMRule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PFMRuleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PFMRule::class);
    }

    /** Récupère les règles selon la catégory renseignée en paramètre
     * @param $id
     * @return mixed
     */
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

    // /**
    //  * @return PFMRules[] Returns an array of PFMRules objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PFMRules
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
