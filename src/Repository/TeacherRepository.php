<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Teacher>
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    //    /**
    //     * @return Teacher[] Returns an array of Teacher objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Teacher
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

                            public function findStudentsByTeacherName($teacherName, $studentName)
                            {
                                $teacher = $this->createQueryBuilder('t')
                                    ->join('t.students', 's') // Join the Student entity
                                    ->andWhere('t.name = :teacherName') // Filter by the teacher's name
                                    ->andWhere('s.section = :studentName') // Filter by the student's name
                                    ->setParameter('teacherName', $teacherName)
                                    ->setParameter('studentName', $studentName)
                                    ->getQuery()
                                    ->getOneOrNullResult(); // Get the Teacher entity

                                return $teacher ? $teacher->getStudents()->toArray() : []; // Get the Student entities from the Teacher entity
                            }
    public function findStudentsByTeacherId($teacherId)
    {
        $teacher = $this->createQueryBuilder('t')
            ->join('t.students', 's') // Join the Student entity
            ->andWhere('t.id = :val') // Filter by the teacher's name
            ->setParameter('val', $teacherId)
            ->getQuery()
            ->getOneOrNullResult(); // Get the Teacher entity

        return $teacher ? $teacher->getStudents()->toArray() : []; // Get the Student entities from the Teacher entity
    }

}
