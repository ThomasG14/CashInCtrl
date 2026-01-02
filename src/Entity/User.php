<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'attachedUser', cascade: ['persist', 'remove'])]
    private ?UserSetting $setting = null;

    /**
     * @var Collection<int, AccountBank>
     */
    #[ORM\OneToMany(targetEntity: AccountBank::class, mappedBy: 'userBank', orphanRemoval: true)]
    private Collection $accountBanks;

    /**
     * @var Collection<int, TransactionLabel>
     */
    #[ORM\OneToMany(targetEntity: TransactionLabel::class, mappedBy: 'userLabel', orphanRemoval: true)]
    private Collection $transactionLabels;

    public function __construct()
    {
        $this->accountBanks = new ArrayCollection();
        $this->transactionLabels = new ArrayCollection();
    }

    public function getId(): ?Uuid {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): static {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): static {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): static {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static {
        $this->roles = $roles;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getSetting(): ?UserSetting {
        return $this->setting;
    }

    public function setSetting(UserSetting $setting): static {
        if ($setting->getAttachedUser() !== $this) {
            $setting->setAttachedUser($this);
        }
        $this->setting = $setting;
        return $this;
    }

    public function getUserIdentifier(): string {
        return (string) $this->email;
    }

    /**
     * @return Collection<int, AccountBank>
     */
    public function getAccountBanks(): Collection
    {
        return $this->accountBanks;
    }

    public function addAccountBank(AccountBank $accountBank): static
    {
        if (!$this->accountBanks->contains($accountBank)) {
            $this->accountBanks->add($accountBank);
            $accountBank->setUserBank($this);
        }

        return $this;
    }

    public function removeAccountBank(AccountBank $accountBank): static
    {
        if ($this->accountBanks->removeElement($accountBank)) {
            // set the owning side to null (unless already changed)
            if ($accountBank->getUserBank() === $this) {
                $accountBank->setUserBank(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TransactionLabel>
     */
    public function getTransactionLabels(): Collection
    {
        return $this->transactionLabels;
    }

    public function addTransactionLabel(TransactionLabel $transactionLabel): static
    {
        if (!$this->transactionLabels->contains($transactionLabel)) {
            $this->transactionLabels->add($transactionLabel);
            $transactionLabel->setUserLabel($this);
        }

        return $this;
    }

    public function removeTransactionLabel(TransactionLabel $transactionLabel): static
    {
        if ($this->transactionLabels->removeElement($transactionLabel)) {
            // set the owning side to null (unless already changed)
            if ($transactionLabel->getUserLabel() === $this) {
                $transactionLabel->setUserLabel(null);
            }
        }

        return $this;
    }
}
