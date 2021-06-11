<?php

namespace App\Entity;

use App\Repository\FichierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichierRepository::class)
 */
class Fichier
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
    private $nom_fichier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_fichier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_fichier;

    /**
     * @ORM\OneToOne(targetEntity=Situation::class, cascade={"persist", "remove"})
     */
    private $situation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier()
    {
        return $this->nom_fichier;
    }

    public function setNomFichier($nom_fichier)
    {
        $this->nom_fichier = $nom_fichier;

        return $this;
    }

    public function getTypeFichier(): ?string
    {
        return $this->type_fichier;
    }

    public function setTypeFichier(string $type_fichier): self
    {
        $this->type_fichier = $type_fichier;

        return $this;
    }

    public function getDateFichier(): ?\DateTimeInterface
    {
        return $this->date_fichier;
    }

    public function setDateFichier(\DateTimeInterface $date_fichier): self
    {
        $this->date_fichier = $date_fichier;

        return $this;
    }

    public function getSituation(): ?Situation
    {
        return $this->situation;
    }

    public function setSituation(?Situation $situation): self
    {
        $this->situation = $situation;

        return $this;
    }
}
