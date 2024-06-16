<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\AttendanceRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'app_all_student', methods: ['GET'])]
    public function index(StudentRepository $studentRepositiory): JsonResponse
    {
        $students = $studentRepositiory->findStudentsByTeacherName('Saugat Gautam');
        $data = array_map(function ($student) {
            return [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'semester' => $student->getSemester(),
                'section' => $student->getSection(),
            ];
        }, $students);
        return $this->json($data);
    }
    #[Route('/semester/{semester}', name: 'app_student_semester', methods: ['GET'])]
    public function withSemester(StudentRepository $studentRepositiory, int $semester,): JsonResponse
    {

        $students = $studentRepositiory->findStudentsByTeacherIdAndStudentSemester(1, $semester);
        $data = array_map(function ($student) {
            return [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'semester' => $student->getSemester(),
                'section' => $student->getSection(),
            ];
        }, $students);
        return $this->json($data);
    }
    #[Route('/section/{section}', name: 'app_student_section', methods: ['GET'])]
    public function withSection(StudentRepository $studentRepositiory, string $section,): JsonResponse
    {

        $students = $studentRepositiory->findStudentsByTeacherIdAndStudentSection(1, $section);
        $data = array_map(function ($student) {
            return [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'semester' => $student->getSemester(),
                'section' => $student->getSection(),
            ];
        }, $students);
        return $this->json($data);
    }
    #[Route('/subject/{subject}', name: 'app_student_subject', methods: ['GET'])]
    public function withsubject(StudentRepository $studentRepositiory, int $subject,): JsonResponse
    {

        $students = $studentRepositiory->findStudentsByTeacherIdAndStudentSubject(1, $subject);
        $data = array_map(function ($student) {
            return [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'semester' => $student->getSemester(),
                'section' => $student->getSection(),
            ];
        }, $students);
        return $this->json($data);
    }

    #[Route('/semester/{semester}/section/{section}', name: 'app_student_withsectionandsemester_index', methods: ['GET'])]
    public function studentSectionAndStudentSemester(StudentRepository $studentRepositiory, string $section, int $semester,): JsonResponse
    {

        $students = $studentRepositiory->findStudentsByTeacherIdAndStudentSectionAndStudentSemester(1, $section, $semester);
        $data = array_map(function ($student) {
            return [
                'id' => $student->getId(),
                'name' => $student->getName(),
                'email' => $student->getEmail(),
                'semester' => $student->getSemester(),
                'section' => $student->getSection(),
            ];
        }, $students);
        return $this->json($data);
    }

}
