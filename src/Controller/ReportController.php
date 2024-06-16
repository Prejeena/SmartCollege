<?php


namespace App\Controller;

use App\Entity\Report;
use App\Entity\Student;
use App\Entity\ReportStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ReportController extends AbstractController
{

    //adding report of a given student on a given date and with given status
    #[Route('/report/add', name: 'report_add', methods: ['POST'])]
    public function addReport(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $studentId = $data['student_id'] ?? null;
        $dateStr = $data['date'] ?? null;
        $statusId = $data['status_id'] ?? null;

        if (!$studentId || !$dateStr || !$statusId) {
            return new JsonResponse(['error' => 'Missing parameters'], JsonResponse::HTTP_BAD_REQUEST);
        }

        try {
            $date = new \DateTime($dateStr);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $student = $entityManager->getRepository(Student::class)->find($studentId);
        $status = $entityManager->getRepository(ReportStatus::class)->find($statusId);

        if (!$student || !$status) {
            return new JsonResponse(['error' => 'Invalid student or status'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $existingReport = $entityManager->getRepository(Report::class)->findOneBy([
            'student' => $student,
            'date' => $date,
        ]);

        if ($existingReport) {
            return new JsonResponse(['error' => 'Report for this student already exists for the given date'], JsonResponse::HTTP_CONFLICT);
        }

        $report = new Report();
        $report->setStudent($student);
        $report->setDate($date);
        $report->setReportStatus($status);

        $entityManager->persist($report);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Report added successfully'], JsonResponse::HTTP_CREATED);
    }
    #[Route('/report/view/{date}', name: 'report_view', methods: ['GET'])]
    public function viewReportsByDate(Request $request, EntityManagerInterface $entityManager, $date): JsonResponse
    {
        try {
            $dateObj = new \DateTime($date);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $reports = $entityManager->getRepository(Report::class)->findBy(['date' => $dateObj]);

        $response = [];

        foreach ($reports as $report) {
            $student = $report->getStudent();
            $response[] = [
                'student_id' => $student->getId(),
                'student_name' => $student->getName(), // Assuming you have a name field in the Student entity
                'report_id' => $report->getId(),
                'status_id' => $report->getReportStatus()->getId(),
                'status' => $report->getReportStatus()->getStatus(), // Assuming you have a status field in the ReportStatus entity
            ];
        }

        return new JsonResponse($response, JsonResponse::HTTP_OK);
    }
    #[Route('/report/view/{studentId}/{date}', name: 'report_view_by_student_and_date', methods: ['GET'])]
    public function viewReportByStudentAndDate(int $studentId, string $date, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $dateObj = new \DateTime($date);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid date format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $report = $entityManager->getRepository(Report::class)->findOneBy([
            'student' => $studentId,
            'date' => $dateObj,
        ]);

        if (!$report) {
            return new JsonResponse(['error' => 'Report not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $response = [
            'report_id' => $report->getId(),
            'student_id' => $report->getStudent()->getId(),
            'student_name' => $report->getStudent()->getName(), // Assuming you have a name field in the Student entity
            'date' => $report->getDate()->format('Y-m-d'),
            'status' => $report->getReportStatus()->getStatus(), // Assuming you have a status field in the ReportStatus entity
        ];

        return new JsonResponse($response, JsonResponse::HTTP_OK);
    }
}
