<?php

namespace App\Repository;

use App\Entity\JobActivity;
use App\Entity\Workshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<JobActivity>
 *
 * @method JobActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobActivity[]    findAll()
 * @method JobActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobActivity::class);
    }

    public function save(JobActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByWorkshop(Workshop $workshop)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->innerJoin('a.jobs', 'job')
            ->innerJoin('job.workshops ', 'workshops');

        return $qb
            ->where($qb->expr()->in(':workshopFilter', 'workshops'))
            ->distinct('a')
            ->setParameter('workshopFilter', $workshop)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return JobActivity[] Returns an array of JobActivity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobActivity
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
