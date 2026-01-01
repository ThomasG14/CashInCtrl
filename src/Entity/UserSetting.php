<?php

namespace App\Entity;

use App\Repository\UserSettingRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSettingRepository::class)]
class UserSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'setting', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $attachedUser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilImg = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $colorAccent = null;

    #[ORM\Column(length: 5)]
    private ?string $lang = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttachedUser(): ?user
    {
        return $this->attachedUser;
    }

    public function setAttachedUser(user $attachedUser): static
    {
        $this->attachedUser = $attachedUser;

        return $this;
    }

    public function getProfilImg(): ?string
    {
        return $this->profilImg;
    }

    public function setProfilImg(?string $profilImg): static
    {
        $this->profilImg = $profilImg;

        return $this;
    }

    public function getColorAccent(): ?string
    {
        return $this->colorAccent;
    }

    public function setColorAccent(?string $colorAccent): static
    {
        $this->colorAccent = $colorAccent;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): static
    {
        $this->lang = $lang;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
