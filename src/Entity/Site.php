<?php

namespace App\Entity;

use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteRepository::class)
 */
class Site
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
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="sites")
     */
    private $entreprise;

    /**
     * @ORM\OneToMany(targetEntity=Secteur::class, mappedBy="site")
     */
    private $secteurs;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="site")
     */
    private $evaluations;

    /**
     * @ORM\OneToMany(targetEntity=Evaluateur::class, mappedBy="site")
     */
    private $evaluateurs;

    /**
     * @ORM\OneToMany(targetEntity=Evaluateur::class, mappedBy="site_exterieur")
     */
    private $evaluateursExterne;

    public function __construct()
    {
        $this->secteurs = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->evaluateurs = new ArrayCollection();
        $this->evaluateursExterne = new ArrayCollection();
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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @return Collection|Secteur[]
     */
    public function getSecteurs(): Collection
    {
        return $this->secteurs;
    }

    public function addSecteur(Secteur $secteur): self
    {
        if (!$this->secteurs->contains($secteur)) {
            $this->secteurs[] = $secteur;
            $secteur->setSite($this);
        }

        return $this;
    }

    public function removeSecteur(Secteur $secteur): self
    {
        if ($this->secteurs->removeElement($secteur)) {
            // set the owning side to null (unless already changed)
            if ($secteur->getSite() === $this) {
                $secteur->setSite(null);
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
            $evaluation->setSite($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getSite() === $this) {
                $evaluation->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evaluateur[]
     */
    public function getEvaluateurs(): Collection
    {
        return $this->evaluateurs;
    }

    public function addEvaluateur(Evaluateur $evaluateur): self
    {
        if (!$this->evaluateurs->contains($evaluateur)) {
            $this->evaluateurs[] = $evaluateur;
            $evaluateur->setSite($this);
        }

        return $this;
    }

    public function removeEvaluateur(Evaluateur $evaluateur): self
    {
        if ($this->evaluateurs->removeElement($evaluateur)) {
            // set the owning side to null (unless already changed)
            if ($evaluateur->getSite() === $this) {
                $evaluateur->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evaluateur[]
     */
    public function getEvaluateursExterne(): Collection
    {
        return $this->evaluateursExterne;
    }

    public function addEvaluateursExterne(Evaluateur $evaluateursExterne): self
    {
        if (!$this->evaluateursExterne->contains($evaluateursExterne)) {
            $this->evaluateursExterne[] = $evaluateursExterne;
            $evaluateursExterne->setSiteExterieur($this);
        }

        return $this;
    }

    public function removeEvaluateursExterne(Evaluateur $evaluateursExterne): self
    {
        if ($this->evaluateursExterne->removeElement($evaluateursExterne)) {
            // set the owning side to null (unless already changed)
            if ($evaluateursExterne->getSiteExterieur() === $this) {
                $evaluateursExterne->setSiteExterieur(null);
            }
        }

        return $this;
    }
}
