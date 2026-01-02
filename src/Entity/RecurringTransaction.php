<?php

namespace App\Entity;

use App\Repository\RecurringTransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\RecurrenceType;

#[ORM\Entity(repositoryClass: RecurringTransactionRepository::class)]
class RecurringTransaction extends Transaction
{
    #[ORM\Column(enumType: RecurrenceType::class)]
    private ?RecurrenceType $recurrenceType = null;

    #[ORM\Column(nullable: true)]
    private ?int $day = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getRecurrenceType(): ?RecurrenceType
    {
        return $this->recurrenceType;
    }

    public function setRecurrenceType(RecurrenceType $recurrenceType): static
    {
        $this->recurrenceType = $recurrenceType;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(?int $day): static
    {
        $this->day = $day;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
