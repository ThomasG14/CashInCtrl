<?php

namespace App\Entity;

use App\Repository\BookletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookletRepository::class)]
class Booklet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxAmount = null;

    #[ORM\ManyToOne(inversedBy: 'booklets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?accountBank $bank = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'booklet', orphanRemoval: true)]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
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

    public function getMaxAmount(): ?int
    {
        return $this->maxAmount;
    }

    public function setMaxAmount(?int $maxAmount): static
    {
        $this->maxAmount = $maxAmount;

        return $this;
    }

    public function getBank(): ?accountBank
    {
        return $this->bank;
    }

    public function setBank(?accountBank $bank): static
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->setBooklet($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getBooklet() === $this) {
                $transaction->setBooklet(null);
            }
        }

        return $this;
    }
}
