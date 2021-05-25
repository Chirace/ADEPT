<?php

namespace App\Entity;

use App\Repository\ContrainteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContrainteRepository::class)
 */
class Contrainte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieContrainte::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie_contrainte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getCategorieContrainte(): ?CategorieContrainte
    {
        return $this->categorie_contrainte;
    }

    public function setCategorieContrainte(?CategorieContrainte $categorie_contrainte): self
    {
        $this->categorie_contrainte = $categorie_contrainte;

        return $this;
    }
}
