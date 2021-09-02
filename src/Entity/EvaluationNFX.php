<?php

namespace App\Entity;

use App\Repository\EvaluationNFXRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationNFXRepository::class)
 */
class EvaluationNFX
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
    private $date_evaluation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_manutention;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $temps_tonnage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tonnage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $frequence_charge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contraintes_environnement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contraintes_organisation;

    /**
     * @ORM\OneToMany(targetEntity=ChargeNFX::class, mappedBy="evaluation_nfx")
     */
    private $chargeNFXes;

    private $contraintes_thermiques;

    private $contraintes_acoustiques;

    private $contraintes_lumineuses;

    private $contrainte_vibrations;

    private $contrainte_poussieres;

    private $contrainte_sols_degrades;

    private $contrainte_encombrement;

    private $contrainte_obstacles;

    private $contrainte_espaces_inadequats;

    private $contrainte_etat_chariot;

    private $contrainte_temps;

    private $contrainte_marge_manoeuvre_reduite;

    private $contrainte_multiplicite_taches;

    private $contrainte_exigences_qualite;

    public function __construct()
    {
        $this->chargeNFXes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTypeManutention(): ?string
    {
        return $this->type_manutention;
    }

    public function setTypeManutention(string $type_manutention): self
    {
        $this->type_manutention = $type_manutention;

        return $this;
    }

    public function getTempsTonnage(): ?float
    {
        return $this->temps_tonnage;
    }

    public function setTempsTonnage(float $temps_tonnage): self
    {
        $this->temps_tonnage = $temps_tonnage;

        return $this;
    }

    public function getTonnage(): ?float
    {
        return $this->tonnage;
    }

    public function setTonnage(float $tonnage): self
    {
        $this->tonnage = $tonnage;

        return $this;
    }

    public function getFrequenceCharge(): ?float
    {
        return $this->frequence_charge;
    }

    public function setFrequenceCharge(float $frequence_charge): self
    {
        $this->frequence_charge = $frequence_charge;

        return $this;
    }

    public function getContraintesEnvironnement(): ?string
    {
        return $this->contraintes_environnement;
    }

    public function setContraintesEnvironnement(string $contraintes_environnement): self
    {
        $this->contraintes_environnement = $contraintes_environnement;

        return $this;
    }

    public function getContraintesOrganisation(): ?string
    {
        return $this->contraintes_organisation;
    }

    public function setContraintesOrganisation(string $contraintes_organisation): self
    {
        $this->contraintes_organisation = $contraintes_organisation;

        return $this;
    }

    /**
     * @return Collection|ChargeNFX[]
     */
    public function getChargeNFXes(): Collection
    {
        return $this->chargeNFXes;
    }

    public function addChargeNFX(ChargeNFX $chargeNFX): self
    {
        if (!$this->chargeNFXes->contains($chargeNFX)) {
            $this->chargeNFXes[] = $chargeNFX;
            $chargeNFX->setEvaluationNfx($this);
        }

        return $this;
    }

    public function removeChargeNFX(ChargeNFX $chargeNFX): self
    {
        if ($this->chargeNFXes->removeElement($chargeNFX)) {
            // set the owning side to null (unless already changed)
            if ($chargeNFX->getEvaluationNfx() === $this) {
                $chargeNFX->setEvaluationNfx(null);
            }
        }

        return $this;
    }

    public function getContraintesThermiques(): ?bool
    {
        return $this->contraintes_thermiques;
    }

    public function setContraintesThermiques(bool $contraintes_thermiques): self
    {
        $this->contraintes_thermiques = $contraintes_thermiques;

        return $this;
    }

    public function getContraintesAcoustiques(): ?bool
    {
        return $this->contraintes_acoustiques;
    }

    public function setContraintesAcoustiques(bool $contraintes_acoustiques): self
    {
        $this->contraintes_acoustiques = $contraintes_acoustiques;

        return $this;
    }

    public function getContraintesLumineuses(): ?bool
    {
        return $this->contraintes_lumineuses;
    }

    public function setContraintesLumineuses(bool $contraintes_lumineuses): self
    {
        $this->contraintes_lumineuses = $contraintes_lumineuses;

        return $this;
    }

    public function getContrainteVibrations(): ?bool
    {
        return $this->contrainte_vibrations;
    }

    public function setContrainteVibrations(bool $contrainte_vibrations): self
    {
        $this->contrainte_vibrations = $contrainte_vibrations;

        return $this;
    }

    public function getContraintePoussieres(): ?bool
    {
        return $this->contrainte_poussieres;
    }

    public function setContraintePoussieres(bool $contrainte_poussieres): self
    {
        $this->contrainte_poussieres = $contrainte_poussieres;

        return $this;
    }

    public function getContrainteSolsDegrades(): ?bool
    {
        return $this->contrainte_sols_degrades;
    }

    public function setContrainteSolsDegrades(bool $contrainte_sols_degrades): self
    {
        $this->contrainte_sols_degrades = $contrainte_sols_degrades;

        return $this;
    }

    public function getContrainteEncombrement(): ?bool
    {
        return $this->contrainte_encombrement;
    }

    public function setContrainteEncombrement(bool $contrainte_encombrement): self
    {
        $this->contrainte_encombrement = $contrainte_encombrement;

        return $this;
    }

    public function getContrainteObstacles(): ?bool
    {
        return $this->contrainte_obstacles;
    }

    public function setContrainteObstacles(bool $contrainte_obstacles): self
    {
        $this->contrainte_obstacles = $contrainte_obstacles;

        return $this;
    }

    public function getContrainteEspacesInadequats(): ?bool
    {
        return $this->contrainte_espaces_inadequats;
    }

    public function setContrainteEspacesInadequats(bool $contrainte_espaces_inadequats): self
    {
        $this->contrainte_espaces_inadequats = $contrainte_espaces_inadequats;

        return $this;
    }

    public function getContrainteEtatChariot(): ?bool
    {
        return $this->contrainte_etat_chariot;
    }

    public function setContrainteEtatChariot(bool $contrainte_etat_chariot): self
    {
        $this->contrainte_etat_chariot = $contrainte_etat_chariot;

        return $this;
    }

    public function getContrainteTemps(): ?bool
    {
        return $this->contrainte_temps;
    }

    public function setContrainteTemps(bool $contrainte_temps): self
    {
        $this->contrainte_temps = $contrainte_temps;

        return $this;
    }

    public function getContrainteMargeManoeuvreReduite(): ?bool
    {
        return $this->contrainte_marge_manoeuvre_reduite;
    }

    public function setContrainteMargeManoeuvreReduite(bool $contrainte_marge_manoeuvre_reduite): self
    {
        $this->contrainte_marge_manoeuvre_reduite = $contrainte_marge_manoeuvre_reduite;

        return $this;
    }

    public function getContrainteMultipliciteTaches(): ?bool
    {
        return $this->contrainte_multiplicite_taches;
    }

    public function setContrainteMultipliciteTaches(bool $contrainte_multiplicite_taches): self
    {
        $this->contrainte_multiplicite_taches = $contrainte_multiplicite_taches;

        return $this;
    }

    public function getContrainteExigencesQualite(): ?bool
    {
        return $this->contrainte_exigences_qualite;
    }

    public function setContrainteExigencesQualite(bool $contrainte_exigences_qualite): self
    {
        $this->contrainte_exigences_qualite = $contrainte_exigences_qualite;

        return $this;
    }
}