<?php

namespace App\Entity;

use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecteurRepository::class)
 */
class Secteur
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
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="secteurs")
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity=PosteDeTravail::class, mappedBy="secteur")
     */
    private $posteDeTravails;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="secteur")
     */
    private $evaluations;

    /**
     * @ORM\OneToMany(targetEntity=EvaluationED6161::class, mappedBy="secteur")
     */
    private $evaluationED6161s;

    public function __construct()
    {
        $this->posteDeTravails = new ArrayCollection();
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

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|PosteDeTravail[]
     */
    public function getPosteDeTravails(): Collection
    {
        return $this->posteDeTravails;
    }

    public function addPosteDeTravail(PosteDeTravail $posteDeTravail): self
    {
        if (!$this->posteDeTravails->contains($posteDeTravail)) {
            $this->posteDeTravails[] = $posteDeTravail;
            $posteDeTravail->setSecteur($this);
        }

        return $this;
    }

    public function removePosteDeTravail(PosteDeTravail $posteDeTravail): self
    {
        if ($this->posteDeTravails->removeElement($posteDeTravail)) {
            // set the owning side to null (unless already changed)
            if ($posteDeTravail->getSecteur() === $this) {
                $posteDeTravail->setSecteur(null);
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
            $evaluation->setSecteur($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getSecteur() === $this) {
                $evaluation->setSecteur(null);
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
            $evaluationED6161->setSecteur($this);
        }

        return $this;
    }

    public function removeEvaluationED6161(EvaluationED6161 $evaluationED6161): self
    {
        if ($this->evaluationED6161s->removeElement($evaluationED6161)) {
            // set the owning side to null (unless already changed)
            if ($evaluationED6161->getSecteur() === $this) {
                $evaluationED6161->setSecteur(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }
}
