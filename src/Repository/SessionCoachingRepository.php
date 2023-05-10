<?php

namespace App\Repository;

use App\Entity\SessionCoaching;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SessionCoaching>
 *
 * @method SessionCoaching|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionCoaching|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionCoaching[]    findAll()
 * @method SessionCoaching[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionCoachingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionCoaching::class);
    }

    public function save(SessionCoaching $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SessionCoaching $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findAll($prixMax = null, $prixMin = null)
    {
        $queryBuilder = $this->createQueryBuilder('sc');
    
        if ($prixMax !== null) {
            $queryBuilder->andWhere('sc.Prix <= :prixMax')
                ->setParameter('prixMax', $prixMax);
        }
    
        if ($prixMin !== null) {
            $queryBuilder->andWhere('sc.Prix >= :prixMin')
                ->setParameter('prixMin', $prixMin);
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
    

//    /**
//     * @return SessionCoaching[] Returns an array of SessionCoaching objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SessionCoaching
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
