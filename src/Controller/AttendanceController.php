<?php
// src/Controller/AttendanceController.php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Student;
use App\Entity\Status;
use App\Repository\AttendanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AttendanceController extends AbstractController
{

//    adding attendance of a given student on a given date and with given status
    #[Route('/attendance/add', name: 'attendance_add', methods: ['POST'])]
    public function addAttendance(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $studentId = $request->request->get('student_id');
        $dateStr = $request->request->get('date');
        $statusId = $request->request->get('status_id');

        if (!$studentId || !$dateStr || !$statusId) {
            return new JsonResponse(['error' => 'Missing parameters'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $date = new \DateTime($dateStr);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $student = $entityManager->getRepository(Student::class)->find($studentId);
        $status = $entityManager->getRepository(Status::class)->find($statusId);

        if (!$student || !$status) {
            return new JsonResponse(['error' => 'Invalid student or status'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $existingAttendance = $entityManager->getRepository(Attendance::class)->findOneBy([
            'student' => $student,
            'date' => $date,
        ]);

        if ($existingAttendance) {
            return new JsonResponse(['error' => 'Attendance record for this student already exists for the given date'], JsonResponse::HTTP_CONFLICT);
        }

        $attendance = new Attendance();
        $attendance->setStudent($student);
        $attendance->setDate($date);
        $attendance->setStatus($status);

        $entityManager->persist($attendance);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Attendance added successfully'], JsonResponse::HTTP_CREATED);
    }

    //    getting all the students present on a given date
    #[Route('/attendance/present', name: 'attendance_present', methods: ['POST'])]

    public function getPresentStudents(Request $request, AttendanceRepository $attendanceRepository): JsonResponse
    {
        $dateStr = $request->query->get('date');

        if (!$dateStr) {
            return $this->json(['error' => 'Date parameter is required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $date = new \DateTime($dateStr);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid date format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $attendances = $attendanceRepository->findPresentStudentsByDate($date);

        if (empty($attendances)) {
            return $this->json(['message' => 'No students found for the given date'], JsonResponse::HTTP_OK);
        }

        $students = array_map(function($attendance) {
            return [
                'id' => $attendance->getStudent()->getId(),
                'name' => $attendance->getStudent()->getName(),
                'date' => $attendance->getDate()->format('Y-m-d')
            ];
        }, $attendances);

        return $this->json($students);
    }
//    getting attendance of a given student
    #[Route("/attendance/student/{id}", name:"attendance_student", methods:["GET"])]

    public function getStudentAttendance(int $id, AttendanceRepository $attendanceRepository): JsonResponse
    {
        $attendances = $attendanceRepository->findByStudent($id);

        if (empty($attendances)) {
            return new JsonResponse(['message' => 'No attendance records found for this student'], JsonResponse::HTTP_NOT_FOUND);
        }

        $attendanceData = array_map(function($attendance) {
            return [
                'date' => $attendance->getDate()->format('Y-m-d'),
                'status' => $attendance->getStatus()->getStatusName()
            ];
        }, $attendances);

        return $this->json($attendanceData);
    }
//    getting attendance of a given student on a given date
    #[Route("/attendance/student/{id}/date  ", name:"attendance_student_date", methods:["GET"])]

    public function getStudentAttendanceByDate(int $id, Request $request, AttendanceRepository $attendanceRepository): JsonResponse
    {
        $dateStr = $request->query->get('date');

        if (!$dateStr) {
            return new JsonResponse(['error' => 'Date parameter is required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $date = new \DateTime($dateStr);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $attendance = $attendanceRepository->findOneByStudentAndDate($id, $date);

        if (!$attendance) {
            return new JsonResponse(['message' => 'No attendance record found for this student on the given date'], JsonResponse::HTTP_NOT_FOUND);
        }

        $attendanceData = [
            'date' => $attendance->getDate()->format('Y-m-d'),
            'status' => $attendance->getStatus()->getStatusName()
        ];

        return $this->json($attendanceData);
    }
}
