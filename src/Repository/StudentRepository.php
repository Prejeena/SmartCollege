<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    //    /**
    //     * @return Student[] Returns an array of Student objects
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

    //    public function findOneBySomeField($value): ?Student
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findStudentsByTeacherName($teacherName)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.name = :teacherName') // Filter by the teacher's name
            ->setParameter('teacherName', $teacherName)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherId($teacherId)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->setParameter('teacherId', $teacherId)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherIdAndStudentSemester($teacherId,$semester)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.semester = :semester') // Filter by the teacher's
            ->setParameter('teacherId', $teacherId)
            ->setParameter('semester', $semester)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherIdAndStudentSection($teacherId,$section)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.section = :section') // Filter by the teacher's section
            ->setParameter('teacherId', $teacherId)
            ->setParameter('section', $section)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }

    public function findStudentsByTeacherIdAndStudentSubject($teacherId,$subject)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.section = :subject') // Filter by the teacher's
            ->setParameter('teacherId', $teacherId)
            ->setParameter('subject', $subject)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherIdAndStudentSectionAndStudentSemester($teacherId,$section,$semester)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.section = :section') // Filter by the teacher's section
            ->andWhere('s.semester = :semester') // Filter by the teacher's Semester
            ->setParameter('teacherId', $teacherId)
            ->setParameter('section', $section)
            ->setParameter('semester', $semester)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherIdAndStudentSectionAndStudentSubject($teacherId,$section,$subject)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.section = :section') // Filter by the teacher's section
            ->andWhere('s.subject = :subject') // Filter by the teacher's subject
            ->setParameter('teacherId', $teacherId)
            ->setParameter('section', $section)
            ->setParameter('subject', $subject)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherIdAndStudentSemesterAndStudentSubject($teacherId,$semester,$subject)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.semester = :semester') // Filter by the teacher's Id
            ->andWhere('s.subject = :subject') // Filter by the teacher's subject
            ->setParameter('teacherId', $teacherId)
            ->setParameter('semester', $semester)
            ->setParameter('subject', $subject)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
    public function findStudentsByTeacherIdAndStudentSectionAndStudentSemesterAndStudentSubject($teacherId,$semester,$section,$subject)
    {
        return $this->createQueryBuilder('s')
            ->leftjoin('s.teachers', 't') // Join the Teacher entity
            ->andWhere('t.id = :teacherId') // Filter by the teacher's Id
            ->andWhere('s.semester = :semester') // Filter by the teacher's Id
            ->andWhere('s.section = :section') // Filter by the teacher's section
            ->andWhere('s.subject = :subject') // Filter by the teacher's section
            ->setParameter('teacherId', $teacherId)
            ->setParameter('semester', $semester)
            ->setParameter('section', $section)
            ->setParameter('subject', $subject)
            ->getQuery()
            ->getResult(); // Get the Student entities
    }
}
