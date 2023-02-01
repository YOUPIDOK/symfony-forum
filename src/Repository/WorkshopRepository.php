<?php

namespace App\Repository;

use App\Entity\Forum;
use App\Entity\Room;
use App\Entity\Workshop;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workshop>
 *
 * @method Workshop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workshop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workshop[]    findAll()
 * @method Workshop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkshopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workshop::class);
    }

    public function save(Workshop $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Workshop $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function isAlreadyUsedDuringThisTimeForThisRoom(Room $room, DateTime $startAt, DateTime $endAt): bool
    {
        return $this
            ->createQueryBuilder('workshop')
            ->where('workshop.room = :room')
            ->andWhere('(workshop.startAt BETWEEN :startAt AND :endAt) OR (workshop.endAt BETWEEN :startAt AND :endAt)')
            ->setParameters([
                'startAt' => $startAt,
                'endAt' => $endAt,
                'room' => $room
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult() !== null;
    }

//    /**
//     * @return Workshop[] Returns an array of Workshop objects
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

//    public function findOneBySomeField($value): ?Workshop
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
