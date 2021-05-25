<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pourquoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avec_qui;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avec_quoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organisation_travail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPourquoi(): ?string
    {
        return $this->pourquoi;
    }

    public function setPourquoi(string $pourquoi): self
    {
        $this->pourquoi = $pourquoi;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getAvecQui(): ?string
    {
        return $this->avec_qui;
    }

    public function setAvecQui(string $avec_qui): self
    {
        $this->avec_qui = $avec_qui;

        return $this;
    }

    public function getAvecQuoi(): ?string
    {
        return $this->avec_quoi;
    }

    public function setAvecQuoi(string $avec_quoi): self
    {
        $this->avec_quoi = $avec_quoi;

        return $this;
    }

    public function getOrganisationTravail(): ?string
    {
        return $this->organisation_travail;
    }

    public function setOrganisationTravail(string $organisation_travail): self
    {
        $this->organisation_travail = $organisation_travail;

        return $this;
    }

    public function getAutre(): ?string
    {
        return $this->autre;
    }

    public function setAutre(string $autre): self
    {
        $this->autre = $autre;

        return $this;
    }
}