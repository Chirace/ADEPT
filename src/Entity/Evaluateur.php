<?php

namespace App\Entity;

use App\Repository\EvaluateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluateurRepository::class)
 */
class Evaluateur
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
     * @ORM\OneToMany(targetEntity=Entreprise::class, mappedBy="evaluateur")
     */
    private $entreprises;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="evaluateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="evaluateur")
     */
    private $evaluations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="evaluateurs")
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="evaluateurs")
     */
    private $site;

    /**
     * @ORM\Column(type="boolean")
     */
    private $evaluation_interne;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="evaluateursExterne")
     */
    private $entreprise_exterieure;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="evaluateursExterne")
     */
    private $site_exterieur;

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
        $this->entreprises = new ArrayCollection();
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

    /**
     * @return Collection|Entreprise[]
     */
    public function getEntreprises(): Collection
    {
        return $this->entreprises;
    }

    public function addEntreprise(Entreprise $entreprise): self
    {
        if (!$this->entreprises->contains($entreprise)) {
            $this->entreprises[] = $entreprise;
            $entreprise->setEvaluateur($this);
        }

        return $this;
    }

    public function removeEntreprise(Entreprise $entreprise): self
    {
        if ($this->entreprises->removeElement($entreprise)) {
            // set the owning side to null (unless already changed)
            if ($entreprise->getEvaluateur() === $this) {
                $entreprise->setEvaluateur(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

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
            $evaluation->setEvaluateur($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getEvaluateur() === $this) {
                $evaluation->setEvaluateur(null);
            }
        }

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

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

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

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

    public function getEntrepriseExterieure(): ?Entreprise
    {
        return $this->entreprise_exterieure;
    }

    public function setEntrepriseExterieure(?Entreprise $entreprise_exterieure): self
    {
        $this->entreprise_exterieure = $entreprise_exterieure;

        return $this;
    }

    public function getSiteExterieur(): ?Site
    {
        return $this->site_exterieur;
    }

    public function setSiteExterieur(?Site $site_exterieur): self
    {
        $this->site_exterieur = $site_exterieur;

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
}
