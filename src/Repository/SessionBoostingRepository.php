<?php

namespace App\Repository;

use App\Entity\SessionBoosting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SessionBoosting>
 *
 * @method SessionBoosting|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionBoosting|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionBoosting[]    findAll()
 * @method SessionBoosting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionBoostingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionBoosting::class);
    }

    public function save(SessionBoosting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SessionBoosting $entity, bool $flush = false): void
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
//     * @return SessionBoosting[] Returns an array of SessionBoosting objects
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

//    public function findOneBySomeField($value): ?SessionBoosting
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
