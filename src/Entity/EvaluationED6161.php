<?php

namespace App\Entity;

use App\Repository\EvaluationED6161Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationED6161Repository::class)
 */
class EvaluationED6161
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="evaluationED6161s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="evaluationED6161s")
     */
    private $secteur;

    private $secteur1;
    private $secteur2;
    private $secteur3;
    private $secteur4;

    /**
     * @ORM\ManyToOne(targetEntity=PosteDeTravail::class, inversedBy="evaluationED6161s")
     */
    private $posteDeTravail;

    private $posteDeTravail1;
    private $posteDeTravail2;
    private $posteDeTravail3;
    private $posteDeTravail4;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q1Non;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q1Oui;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q2Non;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q2OuiNonCritique;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Q2OuiCritique;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="evaluationED6161")
     */
    private $evaluations;

    /**
     * @ORM\Column(type="integer")
     */
    private $reperage_Q;

    public function __construct()
    {
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;

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

    public function getSecteur1(): ?Secteur
    {
        return $this->secteur1;
    }

    public function setSecteur1(?Secteur $secteur1): self
    {
        $this->secteur1 = $secteur1;

        return $this;
    }

    public function getSecteur2(): ?Secteur
    {
        return $this->secteur1;
    }

    public function setSecteur2(?Secteur $secteur2): self
    {
        $this->secteur2 = $secteur2;

        return $this;
    }

    public function getSecteur3(): ?Secteur
    {
        return $this->secteur3;
    }

    public function setSecteur3(?Secteur $secteur3): self
    {
        $this->secteur3 = $secteur3;

        return $this;
    }

    public function getSecteur4(): ?Secteur
    {
        return $this->secteur4;
    }

    public function setSecteur4(?Secteur $secteur4): self
    {
        $this->secteur4 = $secteur4;

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

    public function getPosteDeTravail1(): ?PosteDeTravail
    {
        return $this->posteDeTravail1;
    }

    public function setPosteDeTravail1(?PosteDeTravail $posteDeTravail1): self
    {
        $this->posteDeTravail1 = $posteDeTravail1;

        return $this;
    }

    public function getPosteDeTravail2(): ?PosteDeTravail
    {
        return $this->posteDeTravail2;
    }

    public function setPosteDeTravail2(?PosteDeTravail $posteDeTravail2): self
    {
        $this->posteDeTravail2 = $posteDeTravail2;

        return $this;
    }

    public function getPosteDeTravail3(): ?PosteDeTravail
    {
        return $this->posteDeTravail3;
    }

    public function setPosteDeTravail3(?PosteDeTravail $posteDeTravail3): self
    {
        $this->posteDeTravail3 = $posteDeTravail3;

        return $this;
    }

    public function getPosteDeTravail4(): ?PosteDeTravail
    {
        return $this->posteDeTravail4;
    }

    public function setPosteDeTravail4(?PosteDeTravail $posteDeTravail4): self
    {
        $this->posteDeTravail4 = $posteDeTravail4;

        return $this;
    }

    public function getQ1Non(): ?int
    {
        return $this->Q1Non;
    }

    public function setQ1Non(?int $Q1Non): self
    {
        $this->Q1Non = $Q1Non;

        return $this;
    }

    public function getQ1Oui(): ?int
    {
        return $this->Q1Oui;
    }

    public function setQ1Oui(?int $Q1Oui): self
    {
        $this->Q1Oui = $Q1Oui;

        return $this;
    }

    public function getQ2Non(): ?int
    {
        return $this->Q2Non;
    }

    public function setQ2Non(?int $Q2Non): self
    {
        $this->Q2Non = $Q2Non;

        return $this;
    }

    public function getQ2OuiNonCritique(): ?int
    {
        return $this->Q2OuiNonCritique;
    }

    public function setQ2OuiNonCritique(?int $Q2OuiNonCritique): self
    {
        $this->Q2OuiNonCritique = $Q2OuiNonCritique;

        return $this;
    }

    public function getQ2OuiCritique(): ?int
    {
        return $this->Q2OuiCritique;
    }

    public function setQ2OuiCritique(?int $Q2OuiCritique): self
    {
        $this->Q2OuiCritique = $Q2OuiCritique;

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
            $evaluation->setEvaluationED6161($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getEvaluationED6161() === $this) {
                $evaluation->setEvaluationED6161(null);
            }
        }

        return $this;
    }

    public function getReperageQ(): ?int
    {
        return $this->reperage_Q;
    }

    public function setReperageQ(int $reperage_Q): self
    {
        $this->reperage_Q = $reperage_Q;

        return $this;
    }
}
