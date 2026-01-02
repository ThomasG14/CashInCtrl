<?php

namespace App\Entity;

use App\Repository\TransactionLabelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionLabelRepository::class)]
class TransactionLabel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactionLabels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $userLabel = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $colorBg = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $colorTxt = null;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\OneToMany(targetEntity: Transaction::class, mappedBy: 'label')]
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLabel(): ?user
    {
        return $this->userLabel;
    }

    public function setUserLabel(?user $userLabel): static
    {
        $this->userLabel = $userLabel;

        return $this;
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

    public function getColorBg(): ?string
    {
        return $this->colorBg;
    }

    public function setColorBg(?string $colorBg): static
    {
        $this->colorBg = $colorBg;

        return $this;
    }

    public function getColorTxt(): ?string
    {
        return $this->colorTxt;
    }

    public function setColorTxt(?string $colorTxt): static
    {
        $this->colorTxt = $colorTxt;

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
            $transaction->setLabel($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getLabel() === $this) {
                $transaction->setLabel(null);
            }
        }

        return $this;
    }
}
