<?php

namespace App\Entity;

use App\Enum\TransactionType;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
    'transaction' => Transaction::class,
    'recurring' => RecurringTransaction::class,
])]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(enumType: TransactionType::class)]
    private ?TransactionType $type = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Booklet $booklet = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?TransactionLabel $label = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?TransactionType
    {
        return $this->type;
    }

    public function setType(TransactionType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBooklet(): ?Booklet
    {
        return $this->booklet;
    }

    public function setBooklet(?Booklet $booklet): static
    {
        $this->booklet = $booklet;

        return $this;
    }

    public function getLabel(): ?TransactionLabel
    {
        return $this->label;
    }

    public function setLabel(?TransactionLabel $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
