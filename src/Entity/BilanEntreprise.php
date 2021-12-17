<?php

namespace App\Entity;

use App\Entity\Site;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BilanEntrepriseRepository;

/**
 * @ORM\Entity(repositoryClass=BilanEntrepriseRepository::class)
 */
class BilanEntreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_bilan;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="bilanEntreprises")
     */
    private $Utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="bilanEntreprises")
     */
    private $entreprise;

    private $entreprises;

    private $sites;

    private $secteurs;

    private $posteDeTravails;

    private $situations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=BilanEvaluation::class, mappedBy="bilan")
     */
    private $bilanEvaluations;

    public function __construct()
    {
        $this->bilanEvaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateBilan(): ?\DateTimeInterface
    {
        return $this->date_bilan;
    }

    public function setDateBilan(\DateTimeInterface $date_bilan): self
    {
        $this->date_bilan = $date_bilan;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?Utilisateur $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

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

    public function getEntreprises(): ?Entreprise
    {
        return $this->entreprises;
    }

    public function setEntreprises(?Entreprise $entreprises): self
    {
        $this->entreprises = $entreprises;

        return $this;
    }

    public function getSites(): ?Site
    {
        return $this->sites;
    }

    public function setSites(?Site $sites): self
    {
        $this->sites = $sites;

        return $this;
    }

    public function getSecteurs(): ?Secteur
    {
        return $this->secteurs;
    }

    public function setSecteurs(?Secteur $secteurs): self
    {
        $this->secteurs = $secteurs;

        return $this;
    }

    public function getPosteDeTravails(): ?PosteDeTravail
    {
        return $this->posteDeTravails;
    }

    public function setPosteDeTravails(?PosteDeTravail $posteDeTravails): self
    {
        $this->posteDeTravails = $posteDeTravails;

        return $this;
    }

    public function getSituations(): ?Situation
    {
        return $this->situations;
    }

    public function setSituations(?Situation $situations): self
    {
        $this->situations = $situations;

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
            $bilanEvaluation->setBilan($this);
        }

        return $this;
    }

    public function removeBilanEvaluation(BilanEvaluation $bilanEvaluation): self
    {
        if ($this->bilanEvaluations->removeElement($bilanEvaluation)) {
            // set the owning side to null (unless already changed)
            if ($bilanEvaluation->getBilan() === $this) {
                $bilanEvaluation->setBilan(null);
            }
        }

        return $this;
    }
}
