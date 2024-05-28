<?php

namespace App\Repository;

use App\Entity\PricingPlans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PricingPlans>
 *
 * @method PricingPlans|null find($id, $lockMode = null, $lockVersion = null)
 * @method PricingPlans|null findOneBy(array $criteria, array $orderBy = null)
 * @method PricingPlans[]    findAll()
 * @method PricingPlans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingPlansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PricingPlans::class);
    }

//    /**
//     * @return PricingPlans[] Returns an array of PricingPlans objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PricingPlans
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
