<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
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
    private $type_evaluation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_evaluation;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluateur::class, inversedBy="evaluations")
     */
    private $evaluateur;

    /**
     * @ORM\ManyToOne(targetEntity=Situation::class, inversedBy="evaluations")
     */
    private $situation;

    /**
     * @ORM\OneToOne(targetEntity=EvaluationNFX::class, cascade={"persist", "remove"})
     */
    private $evaluation_nfx;

    /**
     * @ORM\ManyToOne(targetEntity=PosteDeTravail::class, inversedBy="evaluations")
     */
    private $posteDeTravail;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="evaluations")
     */
    private $secteur;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="evaluations")
     */
    private $site;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="evaluations")
     */
    private $entreprise;

    private $situation_nom;

    /**
     * @ORM\OneToMany(targetEntity=EvaluationED6161::class, mappedBy="evaluation")
     */
    private $evaluationED6161s;

    /**
     * @ORM\ManyToOne(targetEntity=EvaluationED6161::class, inversedBy="evaluations")
     */
    private $evaluationED6161;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $evaluation_interne;

    /**
     * @ORM\OneToMany(targetEntity=BilanEvaluation::class, mappedBy="evaluation")
     */
    private $bilanEvaluations;

    public function __construct()
    {
        $this->evaluationED6161s = new ArrayCollection();
        $this->bilanEvaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEvaluation(): ?string
    {
        return $this->type_evaluation;
    }

    public function setTypeEvaluation(string $type_evaluation): self
    {
        $this->type_evaluation = $type_evaluation;

        return $this;
    }

    public function getDateEvaluation(): ?\DateTimeInterface
    {
        return $this->date_evaluation;
    }

    public function setDateEvaluation(\DateTimeInterface $date_evaluation): self
    {
        $this->date_evaluation = $date_evaluation;

        return $this;
    }

    public function getEvaluateur(): ?Evaluateur
    {
        return $this->evaluateur;
    }

    public function setEvaluateur(?Evaluateur $evaluateur): self
    {
        $this->evaluateur = $evaluateur;

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

    public function getEvaluationNfx(): ?EvaluationNFX
    {
        return $this->evaluation_nfx;
    }

    public function setEvaluationNfx(?EvaluationNFX $evaluation_nfx): self
    {
        $this->evaluation_nfx = $evaluation_nfx;

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

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getSituationNom(): ?string
    {
        return $this->situation_nom;
    }

    public function setSituationNom(?string $situation_nom): self
    {
        $this->situation_nom = $situation_nom;

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
            $evaluationED6161->setEvaluation($this);
        }

        return $this;
    }

    public function removeEvaluationED6161(EvaluationED6161 $evaluationED6161): self
    {
        if ($this->evaluationED6161s->removeElement($evaluationED6161)) {
            // set the owning side to null (unless already changed)
            if ($evaluationED6161->getEvaluation() === $this) {
                $evaluationED6161->setEvaluation(null);
            }
        }

        return $this;
    }

    public function getEvaluationED6161(): ?EvaluationED6161
    {
        return $this->evaluationED6161;
    }

    public function setEvaluationED6161(?EvaluationED6161 $evaluationED6161): self
    {
        $this->evaluationED6161 = $evaluationED6161;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEvaluationInterne(): ?bool
    {
        return $this->evaluation_interne;
    }

    public function setEvaluationInterne(bool $evaluation_interne): self
    {
        $this->evaluation_interne = $evaluation_interne;

        return $this;
    }

    /**
     * @return Collection|BilanEvaluation[]
     */
    public function getBilanEvaluations(): Collection
    {
        return $this->bilanEvaluations;
    }

    public function addBilanEvaluation(BilanEvaluation $bilanEvaluation): self
    {
        if (!$this->bilanEvaluations->contains($bilanEvaluation)) {
            $this->bilanEvaluations[] = $bilanEvaluation;
            $bilanEvaluation->setEvaluation($this);
        }

        return $this;
    }

    public function removeBilanEvaluation(BilanEvaluation $bilanEvaluation): self
    {
        if ($this->bilanEvaluations->removeElement($bilanEvaluation)) {
            // set the owning side to null (unless already changed)
            if ($bilanEvaluation->getEvaluation() === $this) {
                $bilanEvaluation->setEvaluation(null);
            }
        }

        return $this;
    }
}
