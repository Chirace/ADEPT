<?php

namespace App\Entity;

use App\Repository\PosteDeTravailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosteDeTravailRepository::class)
 */
class PosteDeTravail
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
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="posteDeTravails")
     */
    private $secteur;

    /**
     * @ORM\OneToMany(targetEntity=Situation::class, mappedBy="posteDeTravail")
     */
    private $situations;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="posteDeTravail")
     */
    private $evaluations;

    /**
     * @ORM\OneToMany(targetEntity=EvaluationED6161::class, mappedBy="posteDeTravail")
     */
    private $evaluationED6161s;

    public function __construct()
    {
        $this->situations = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->evaluationED6161s = new ArrayCollection();
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

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * @return Collection|Situation[]
     */
    public function getSituations(): Collection
    {
        return $this->situations;
    }

    public function addSituation(Situation $situation): self
    {
        if (!$this->situations->contains($situation)) {
            $this->situations[] = $situation;
            $situation->setPosteDeTravail($this);
        }

        return $this;
    }

    public function removeSituation(Situation $situation): self
    {
        if ($this->situations->removeElement($situation)) {
            // set the owning side to null (unless already changed)
            if ($situation->getPosteDeTravail() === $this) {
                $situation->setPosteDeTravail(null);
            }
        }

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
            $evaluation->setPosteDeTravail($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getPosteDeTravail() === $this) {
                $evaluation->setPosteDeTravail(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EvaluationED6161[]
     */
    public function getEvaluationED6161s(): Collection
    {
        return $this->evaluationED6161s;
    }

    public function addEvaluationED6161(EvaluationED6161 $evaluationED6161): self
    {
        if (!$this->evaluationED6161s->contains($evaluationED6161)) {
            $this->evaluationED6161s[] = $evaluationED6161;
            $evaluationED6161->setPosteDeTravail($this);
        }

        return $this;
    }

    public function removeEvaluationED6161(EvaluationED6161 $evaluationED6161): self
    {
        if ($this->evaluationED6161s->removeElement($evaluationED6161)) {
            // set the owning side to null (unless already changed)
            if ($evaluationED6161->getPosteDeTravail() === $this) {
                $evaluationED6161->setPosteDeTravail(null);
            }
        }

        return $this;
    }
    
    public function __toString(){
        return $this->nom;
    }
}