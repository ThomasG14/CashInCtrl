<?php

namespace App\Entity;

use App\Repository\AccountBankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountBankRepository::class)]
class AccountBank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $bankName = null;

    #[ORM\ManyToOne(inversedBy: 'accountBanks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $userBank = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Booklet>
     */
    #[ORM\OneToMany(targetEntity: Booklet::class, mappedBy: 'bank', orphanRemoval: true)]
    private Collection $booklets;

    public function __construct()
    {
        $this->booklets = new ArrayCollection();
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

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): static
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getUserBank(): ?user
    {
        return $this->userBank;
    }

    public function setUserBank(?user $userBank): static
    {
        $this->userBank = $userBank;

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

    /**
     * @return Collection<int, Booklet>
     */
    public function getBooklets(): Collection
    {
        return $this->booklets;
    }

    public function addBooklet(Booklet $booklet): static
    {
        if (!$this->booklets->contains($booklet)) {
            $this->booklets->add($booklet);
            $booklet->setBank($this);
        }

        return $this;
    }

    public function removeBooklet(Booklet $booklet): static
    {
        if ($this->booklets->removeElement($booklet)) {
            // set the owning side to null (unless already changed)
            if ($booklet->getBank() === $this) {
                $booklet->setBank(null);
            }
        }

        return $this;
    }
}
