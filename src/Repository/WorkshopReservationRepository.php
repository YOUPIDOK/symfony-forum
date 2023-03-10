<?php

namespace App\Repository;

use App\Entity\Forum;
use App\Entity\Student;
use App\Entity\WorkshopReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkshopReservation>
 *
 * @method WorkshopReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkshopReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkshopReservation[]    findAll()
 * @method WorkshopReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkshopReservation::class);
    }

    public function save(WorkshopReservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkshopReservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByForumAndStudent(Forum $forum, Student $student)
    {
        return $this
            ->createQueryBuilder('wr')
            ->innerJoin('wr.workshop','workshop')
            ->where('workshop.forum = :forum')->setParameter('forum', $forum)
            ->andWhere('wr.student = :student') ->setParameter('student', $student)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithNoUserHashed()
    {
        return $this
            ->createQueryBuilder('wr')
            ->innerJoin('wr.student', 'student')
            ->innerJoin('student.user', 'user')
            ->where('user.isHashed = FALSE')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return WorkshopReservation[] Returns an array of WorkshopReservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkshopReservation
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
