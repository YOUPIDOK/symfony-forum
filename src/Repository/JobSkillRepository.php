<?php

namespace App\Repository;

use App\Entity\JobSkill;
use App\Entity\Workshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobSkill>
 *
 * @method JobSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobSkill[]    findAll()
 * @method JobSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobSkill::class);
    }

    public function save(JobSkill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobSkill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByWorkshop(Workshop $workshop)
    {
        $qb = $this
            ->createQueryBuilder('s')
            ->innerJoin('s.jobs', 'job')
            ->innerJoin('job.workshops ', 'workshops');

        return $qb
            ->where($qb->expr()->in(':workshopFilter', 'workshops'))
            ->distinct('s')
            ->setParameter('workshopFilter', $workshop)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return JobSkill[] Returns an array of JobSkill objects
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

//    public function findOneBySomeField($value): ?JobSkill
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
