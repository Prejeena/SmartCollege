<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $statusName = null;

    /**
     * @var Collection<int, Attendance>
     */
    #[ORM\OneToMany(targetEntity: Attendance::class, mappedBy: 'status')]
    private Collection $attendance;

    public function __construct()
    {
        $this->attendance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusName(): ?string
    {
        return $this->statusName;
    }

    public function setStatusName(string $statusName): static
    {
        $this->statusName = $statusName;

        return $this;
    }

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
            $attendance->setStatus($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): static
    {
        if ($this->attendance->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getStatus() === $this) {
                $attendance->setStatus(null);
            }
        }

        return $this;
    }
}
