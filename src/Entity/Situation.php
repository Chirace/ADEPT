<?php

namespace App\Entity;

use App\Repository\SituationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SituationRepository::class)
 */
class Situation
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
    private $dimension_temporelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre;

    /**
     * @ORM\ManyToOne(targetEntity=PosteDeTravail::class, inversedBy="situations")
     */
    private $posteDeTravail;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="situation")
     */
    private $evaluations;

    /**
     * @ORM\OneToOne(targetEntity=Operateur::class, inversedBy="situation", cascade={"persist", "remove"})
     */
    private $operateur;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

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

    public function getQuoi(): ?string
    {
        return $this->quoi;
    }

    public function setQuoi(string $quoi): self
    {
        $this->quoi = $quoi;

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

    public function getDimensionTemporelle(): ?string
    {
        return $this->dimension_temporelle;
    }

    public function setDimensionTemporelle(string $dimension_temporelle): self
    {
        $this->dimension_temporelle = $dimension_temporelle;

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

    public function getPosteDeTravail(): ?PosteDeTravail
    {
        return $this->posteDeTravail;
    }

    public function setPosteDeTravail(?PosteDeTravail $posteDeTravail): self
    {
        $this->posteDeTravail = $posteDeTravail;

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setSituation($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getSituation() === $this) {
                $evaluation->setSituation(null);
            }
        }

        return $this;
    }

    public function getOperateur(): ?Operateur
    {
        return $this->operateur;
    }

    public function setOperateur(?Operateur $operateur): self
    {
        $this->operateur = $operateur;

        return $this;
    }
}