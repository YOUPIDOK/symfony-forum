<?php

namespace App\Repository;

use App\Entity\HighSchool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HighSchool>
 *
 * @method HighSchool|null find($id, $lockMode = null, $lockVersion = null)
 * @method HighSchool|null findOneBy(array $criteria, array $orderBy = null)
 * @method HighSchool[]    findAll()
 * @method HighSchool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HighSchoolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HighSchool::class);
    }

    public function save(HighSchool $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HighSchool $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllNoHashedQb()
    {
        return $this
            ->createQueryBuilder('h')
            ->innerJoin('h.user', 'user')
            ->where('user.isHashed = FALSE')
            ->orderBy('h.name', 'ASC');
    }

    public function findAllNoHashed()
    {
        return $this
            ->createQueryBuilder('h')
            ->innerJoin('h.user', 'user')
            ->where('user.isHashed = FALSE')
            ->orderBy('h.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return HighSchool[] Returns an array of HighSchool objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HighSchool
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
