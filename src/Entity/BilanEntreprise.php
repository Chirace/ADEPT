<?php

namespace App\Entity;

use App\Repository\BilanEntrepriseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BilanEntrepriseRepository::class)
 */
class BilanEntreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_bilan;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="bilanEntreprises")
     */
    private $Utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="bilanEntreprises")
     */
    private $entreprise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateBilan(): ?\DateTimeInterface
    {
        return $this->date_bilan;
    }

    public function setDateBilan(\DateTimeInterface $date_bilan): self
    {
        $this->date_bilan = $date_bilan;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
