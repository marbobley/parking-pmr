<?php

namespace App\Entity;

use App\Repository\VisitorConnexionRepository;
use Doctrine\ORM\Mapping as ORM;
use Marbobley\EntitiesVisitorBundle\Model\VisitorInformation as VisitorInformationModel;

#[ORM\Entity(repositoryClass: VisitorConnexionRepository::class)]
class VisitorConnexion extends VisitorInformationModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
