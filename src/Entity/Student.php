<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, Teacher>
     */
    #[ORM\ManyToMany(targetEntity: Teacher::class, mappedBy: 'students')]
    private Collection $teachers;

    #[ORM\Column]
    private ?int $semester = null;

    #[ORM\Column(length: 255)]
    private ?string $section = null;

    /**
     * @var Collection<int, Subject>
     */
    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'students')]
    private Collection $subject;

    /**
     * @var Collection<int, Attendance>
     */
    #[ORM\OneToMany(targetEntity: Attendance::class, mappedBy: 'student')]
    private Collection $attendance;

    /**
     * @var Collection<int, Report>
     */
    #[ORM\OneToMany(targetEntity: Report::class, mappedBy: 'student')]
    private Collection $reports;
//
//    /**
//     * @var Collection<int, Attendance>
//     */
//    #[ORM\ManyToMany(targetEntity: Attendance::class, inversedBy: 'students')]
//    private Collection $attendance;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->subject = new ArrayCollection();
//        $this->attendance = new ArrayCollection();
$this->reports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): static
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
            $teacher->addStudent($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): static
    {
        if ($this->teachers->removeElement($teacher)) {
            $teacher->removeStudent($this);
        }

        return $this;
    }

    public function getSemester(): ?int
    {
        return $this->semester;
    }

    public function setSemester(int $semester): static
    {
        $this->semester = $semester;

        return $this;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(string $section): static
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubject(): Collection
    {
        return $this->subject;
    }

    public function addSubject(Subject $subject): static
    {
        if (!$this->subject->contains($subject)) {
            $this->subject->add($subject);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        $this->subject->removeElement($subject);

        return $this;
    }
//
//    /**
//     * @return Collection<int, Attendance>
//     */
//    public function getAttendance(): Collection
//    {
//        return $this->attendance;
//    }
//
//    public function addAttendance(Attendance $attendance): static
//    {
//        if (!$this->attendance->contains($attendance)) {
//            $this->attendance->add($attendance);
//        }
//
//        return $this;
//    }
//
//    public function removeAttendance(Attendance $attendance): static
//    {
//        $this->attendance->removeElement($attendance);
//
//        return $this;
//    }

/**
 * @return Collection<int, Attendance>
 */
public function getAttendance(): Collection
{
    return $this->attendance;
}

public function addAttendance(Attendance $attendance): static
{
    if (!$this->attendance->contains($attendance)) {
        $this->attendance->add($attendance);
        $attendance->setStudent($this);
    }

    return $this;
}

public function removeAttendance(Attendance $attendance): static
{
    if ($this->attendance->removeElement($attendance)) {
        // set the owning side to null (unless already changed)
        if ($attendance->getStudent() === $this) {
            $attendance->setStudent(null);
        }
    }

    return $this;
}

/**
 * @return Collection<int, Report>
 */
public function getReports(): Collection
{
    return $this->reports;
}

public function addReport(Report $report): static
{
    if (!$this->reports->contains($report)) {
        $this->reports->add($report);
        $report->setStudent($this);
    }

    return $this;
}

public function removeReport(Report $report): static
{
    if ($this->reports->removeElement($report)) {
        // set the owning side to null (unless already changed)
        if ($report->getStudent() === $this) {
            $report->setStudent(null);
        }
    }

    return $this;
}

}
