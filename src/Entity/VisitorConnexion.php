<?php

namespace App\Entity;

use App\Repository\VisitorConnexionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorConnexionRepository::class)]
class VisitorConnexion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $clientIP = null;

    #[ORM\Column(length: 255)]
    private ?string $browser = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateConnexion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientIP(): ?string
    {
        return $this->clientIP;
    }

    public function setClientIP(string $clientIP): static
    {
        $this->clientIP = $clientIP;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function setBrowser(string $browser): static
    {
        $this->browser = $browser;

        return $this;
    }

    public function getDateConnexion(): ?\DateTimeImmutable
    {
        return $this->dateConnexion;
    }

    public function setDateConnexion(\DateTimeImmutable $dateConnexion): static
    {
        $this->dateConnexion = $dateConnexion;

        return $this;
    }
}
