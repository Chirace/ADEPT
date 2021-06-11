<?php

namespace App\Entity;

use App\Repository\OperateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperateurRepository::class)
 */
class Operateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $Flag_Enceinte;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $lateralite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $Anciennete_poste;

    /**
     * @ORM\Column(type="integer")
     */
    private $Anciennete_entreprise;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getFlagEnceinte(): ?string
    {
        return $this->Flag_Enceinte;
    }

    public function setFlagEnceinte(string $Flag_Enceinte): self
    {
        $this->Flag_Enceinte = $Flag_Enceinte;

        return $this;
    }

    public function getLateralite(): ?string
    {
        return $this->lateralite;
    }

    public function setLateralite(string $lateralite): self
    {
        $this->lateralite = $lateralite;

        return $this;
    }

    public function getFormation(): ?string
    {
        return $this->Formation;
    }

    public function setFormation(string $Formation): self
    {
        $this->Formation = $Formation;

        return $this;
    }

    public function getAnciennetePoste(): ?int
    {
        return $this->Anciennete_poste;
    }

    public function setAnciennetePoste(int $Anciennete_poste): self
    {
        $this->Anciennete_poste = $Anciennete_poste;

        return $this;
    }

    public function getAncienneteEntreprise(): ?int
    {
        return $this->Anciennete_entreprise;
    }

    public function setAncienneteEntreprise(int $Anciennete_entreprise): self
    {
        $this->Anciennete_entreprise = $Anciennete_entreprise;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }
}
