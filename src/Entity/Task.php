<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $taskId = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $estimatedDuration = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Developer $assignedToDeveloper = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function setTaskId(int $taskId): self
    {
        $this->taskId = $taskId;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getEstimatedDuration(): ?int
    {
        return $this->estimatedDuration;
    }

    public function setEstimatedDuration(int $estimatedDuration): self
    {
        $this->estimatedDuration = $estimatedDuration;

        return $this;
    }

    public function getAssignedToDeveloper(): ?Developer
    {
        return $this->assignedToDeveloper;
    }

    public function setAssignedToDeveloper(?Developer $assignedToDeveloper): self
    {
        $this->assignedToDeveloper = $assignedToDeveloper;

        return $this;
    }
}
