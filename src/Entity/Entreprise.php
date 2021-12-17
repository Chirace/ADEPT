<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
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
     * @ORM\ManyToOne(targetEntity=Evaluateur::class, inversedBy="entreprises")
     */
    private $evaluateur;

    /**
     * @ORM\OneToMany(targetEntity=Site::class, mappedBy="entreprise")
     */
    private $sites;

    /**
     * @ORM\OneToMany(targetEntity=BilanEntreprise::class, mappedBy="entreprise")
     */
    private $bilanEntreprises;

    /**
     * @ORM\OneToMany(targetEntity=Evaluateur::class, mappedBy="entreprise")
     */
    private $evaluateurs;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="entreprise")
     */
    private $evaluations;

    /**
     * @ORM\OneToMany(targetEntity=Evaluateur::class, mappedBy="entreprise_exterieure")
     */
    private $evaluateursExterne;

    /**
     * @ORM\ManyToOne(targetEntity=DivisionNAF::class, inversedBy="evaluateursExterne")
     */
    private $secteur_activite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $effectif;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->bilanEntreprises = new ArrayCollection();
        $this->evaluateurs = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
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

    public function getEvaluateur(): ?Evaluateur
    {
        return $this->evaluateur;
    }

    public function setEvaluateur(?Evaluateur $evaluateur): self
    {
        $this->evaluateur = $evaluateur;

        return $this;
    }

    /**
     * @return Collection|Site[]
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites[] = $site;
            $site->setEntreprise($this);
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getEntreprise() === $this) {
                $site->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BilanEntreprise[]
     */
    public function getBilanEntreprises(): Collection
    {
        return $this->bilanEntreprises;
    }

    public function addBilanEntreprise(BilanEntreprise $bilanEntreprise): self
    {
        if (!$this->bilanEntreprises->contains($bilanEntreprise)) {
            $this->bilanEntreprises[] = $bilanEntreprise;
            $bilanEntreprise->setEntreprise($this);
        }

        return $this;
    }

    public function removeBilanEntreprise(BilanEntreprise $bilanEntreprise): self
    {
        if ($this->bilanEntreprises->removeElement($bilanEntreprise)) {
            // set the owning side to null (unless already changed)
            if ($bilanEntreprise->getEntreprise() === $this) {
                $bilanEntreprise->setEntreprise(null);
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
            $evaluateur->setEntreprise($this);
        }

        return $this;
    }

    public function removeEvaluateur(Evaluateur $evaluateur): self
    {
        if ($this->evaluateurs->removeElement($evaluateur)) {
            // set the owning side to null (unless already changed)
            if ($evaluateur->getEntreprise() === $this) {
                $evaluateur->setEntreprise(null);
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
            $evaluation->setEntreprise($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getEntreprise() === $this) {
                $evaluation->setEntreprise(null);
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
            $evaluateursExterne->setEntrepriseExterieure($this);
        }

        return $this;
    }

    public function removeEvaluateursExterne(Evaluateur $evaluateursExterne): self
    {
        if ($this->evaluateursExterne->removeElement($evaluateursExterne)) {
            // set the owning side to null (unless already changed)
            if ($evaluateursExterne->getEntrepriseExterieure() === $this) {
                $evaluateursExterne->setEntrepriseExterieure(null);
            }
        }

        return $this;
    }

    public function getSecteurActivite(): ?DivisionNAF
    {
        return $this->secteur_activite;
    }

    public function setSecteurActivite(?DivisionNAF $secteur_activite): self
    {
        $this->secteur_activite = $secteur_activite;

        return $this;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(?int $effectif): self
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function __toString(){
        return $this->nom;
    }
}
