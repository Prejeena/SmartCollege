<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Attendance>
 */
class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendance::class);
    }

    //    /**
    //     * @return Attendance[] Returns an array of Attendance objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Attendance
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findPresentStudentsByDate(\DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.student', 's')
            ->innerJoin('a.status', 'st')
            ->andWhere('a.date = :date')
            ->andWhere('st.statusName = :status')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('status', 'Present')
            ->getQuery()
            ->getResult();
    }
    public function findByStudentId(int $studentId): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.student', 's')
            ->where('s.id = :studentId')
            ->setParameter('studentId', $studentId)
            ->orderBy('a.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByStudentAndDate(int $studentId, \DateTimeInterface $date): ?Attendance
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.student', 's')
            ->andWhere('s.id = :studentId')
            ->andWhere('a.date = :date')
            ->setParameter('studentId', $studentId)
            ->setParameter('date', $date->format('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();
    }
}
