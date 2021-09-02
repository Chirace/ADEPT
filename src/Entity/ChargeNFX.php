<?php

namespace App\Entity;

use App\Repository\ChargeNFXRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChargeNFXRepository::class)
 */
class ChargeNFX
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $poids_charge;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prise_hauteur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prise_profondeur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $depose_hauteur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $depose_profondeur;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $force_initiale;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $force_initiale_reference;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $force_maintien;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $force_maintien_reference;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $distance_transport_charge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transport_charge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PT_action;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PT_manutention_type;

    private $PT_lit;

    private $PT_transpalette;

    private $PT_chariot;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PT_distance;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PT_hauteur_poignee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PT_frequence;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_charge_identique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contraintes_execution;

    private $contrainte_poignees_inadaptees;

    private $contrainte_torsion_tronc;

    private $contrainte_profondeur_prise;

    private $contrainte_hors_zone_atteinte;

    private $contrainte_posture;

    private $contrainte_charge_instable;

    private $contrainte_visibilite_limitee;

    private $contrainte_roulettes_inadequates;

    private $contrainte_absence_frein;

    /**
     * @ORM\ManyToOne(targetEntity=EvaluationNFX::class, inversedBy="chargeNFXes")
     */
    private $evaluation_nfx;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coefficient_correction_1;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coefficient_correction_2;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $masse_corrigee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intitule_coefficient_correction_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intitule_coefficient_correction_2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoidsCharge(): ?float
    {
        return $this->poids_charge;
    }

    public function setPoidsCharge(float $poids_charge): self
    {
        $this->poids_charge = $poids_charge;

        return $this;
    }

    public function getPriseHauteur(): ?float
    {
        return $this->prise_hauteur;
    }

    public function setPriseHauteur(float $prise_hauteur): self
    {
        $this->prise_hauteur = $prise_hauteur;

        return $this;
    }

    public function getPriseProfondeur(): ?float
    {
        return $this->prise_profondeur;
    }

    public function setPriseProfondeur(float $prise_profondeur): self
    {
        $this->prise_profondeur = $prise_profondeur;

        return $this;
    }

    public function getDeposeHauteur(): ?float
    {
        return $this->depose_hauteur;
    }

    public function setDeposeHauteur(float $depose_hauteur): self
    {
        $this->depose_hauteur = $depose_hauteur;

        return $this;
    }

    public function getDeposeProfondeur(): ?float
    {
        return $this->depose_profondeur;
    }

    public function setDeposeProfondeur(float $depose_profondeur): self
    {
        $this->depose_profondeur = $depose_profondeur;

        return $this;
    }

    public function getForceInitiale(): ?float
    {
        return $this->force_initiale;
    }

    public function setForceInitiale(float $force_initiale): self
    {
        $this->force_initiale = $force_initiale;

        return $this;
    }

    public function getForceInitialeReference(): ?float
    {
        return $this->force_initiale_reference;
    }

    public function setForceInitialeReference(float $force_initiale_reference): self
    {
        $this->force_initiale_reference = $force_initiale_reference;

        return $this;
    }

    public function getForceMaintien(): ?float
    {
        return $this->force_maintien;
    }

    public function setForceMaintien(?float $force_maintien): self
    {
        $this->force_maintien = $force_maintien;

        return $this;
    }

    public function getForceMaintienReference(): ?float
    {
        return $this->force_maintien_reference;
    }

    public function setForceMaintienReference(?float $force_maintien_reference): self
    {
        $this->force_maintien_reference = $force_maintien_reference;

        return $this;
    }

    public function getDistanceTransportCharge(): ?float
    {
        return $this->distance_transport_charge;
    }

    public function setDistanceTransportCharge(float $distance_transport_charge): self
    {
        $this->distance_transport_charge = $distance_transport_charge;

        return $this;
    }

    public function getTransportCharge(): ?string
    {
        return $this->transport_charge;
    }

    public function setTransportCharge(string $transport_charge): self
    {
        $this->transport_charge = $transport_charge;

        return $this;
    }

    public function getPTAction(): ?string
    {
        return $this->PT_action;
    }

    public function setPTAction(?string $PT_action): self
    {
        $this->PT_action = $PT_action;

        return $this;
    }

    public function getPTManutentionType(): ?string
    {
        return $this->PT_manutention_type;
    }

    public function setPTManutentionType(?string $PT_manutention_type): self
    {
        $this->PT_manutention_type = $PT_manutention_type;

        return $this;
    }

    public function getPTLit(): ?bool
    {
        return $this->PT_lit;
    }

    public function setPTLit(bool $PT_lit): self
    {
        $this->PT_lit = $PT_lit;

        return $this;
    }

    public function getPTTranspalette(): ?bool
    {
        return $this->PT_transpalette;
    }

    public function setPTTranspalette(bool $PT_transpalette): self
    {
        $this->PT_transpalette = $PT_transpalette;

        return $this;
    }

    public function getPTchariot(): ?bool
    {
        return $this->PT_chariot;
    }

    public function setPTchariot(bool $PT_chariot): self
    {
        $this->PT_chariot = $PT_chariot;

        return $this;
    }

    public function getPTDistance(): ?float
    {
        return $this->PT_distance;
    }

    public function setPTDistance(?float $PT_distance): self
    {
        $this->PT_distance = $PT_distance;

        return $this;
    }

    public function getPTHauteurPoignee(): ?float
    {
        return $this->PT_hauteur_poignee;
    }

    public function setPTHauteurPoignee(?float $PT_hauteur_poignee): self
    {
        $this->PT_hauteur_poignee = $PT_hauteur_poignee;

        return $this;
    }

    public function getPTFrequence(): ?string
    {
        return $this->PT_frequence;
    }

    public function setPTFrequence(?string $PT_frequence): self
    {
        $this->PT_frequence = $PT_frequence;

        return $this;
    }

    public function getNombreChargeIdentique(): ?int
    {
        return $this->nombre_charge_identique;
    }

    public function setNombreChargeIdentique(int $nombre_charge_identique): self
    {
        $this->nombre_charge_identique = $nombre_charge_identique;

        return $this;
    }

    public function getContraintesExecution(): ?string
    {
        return $this->contraintes_execution;
    }

    public function setContraintesExecution(string $contraintes_execution): self
    {
        $this->contraintes_execution = $contraintes_execution;

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

    public function getContraintePoigneesInadaptees(): ?bool
    {
        return $this->contrainte_poignees_inadaptees;
    }

    public function setContraintePoigneesInadaptees(bool $contrainte_poignees_inadaptees): self
    {
        $this->contrainte_poignees_inadaptees = $contrainte_poignees_inadaptees;

        return $this;
    }

    public function getContrainteTorsionTronc(): ?bool
    {
        return $this->contrainte_torsion_tronc;
    }

    public function setContrainteTorsionTronc(bool $contrainte_torsion_tronc): self
    {
        $this->contrainte_torsion_tronc = $contrainte_torsion_tronc;

        return $this;
    }

    public function getContrainteProfondeurPrise(): ?bool
    {
        return $this->contrainte_profondeur_prise;
    }

    public function setContrainteProfondeurPrise(bool $contrainte_profondeur_prise): self
    {
        $this->contrainte_profondeur_prise = $contrainte_profondeur_prise;

        return $this;
    }

    public function getContrainteHorsZoneAtteinte(): ?bool
    {
        return $this->contrainte_hors_zone_atteinte;
    }

    public function setContrainteHorsZoneAtteinte(bool $contrainte_hors_zone_atteinte): self
    {
        $this->contrainte_hors_zone_atteinte = $contrainte_hors_zone_atteinte;

        return $this;
    }

    public function getContraintePosture(): ?bool
    {
        return $this->contrainte_posture;
    }

    public function setContraintePosture(bool $contrainte_posture): self
    {
        $this->contrainte_posture = $contrainte_posture;

        return $this;
    }

    public function getContrainteChargeInstable(): ?bool
    {
        return $this->contrainte_charge_instable;
    }

    public function setContrainteChargeInstable(bool $contrainte_charge_instable): self
    {
        $this->contrainte_charge_instable = $contrainte_charge_instable;

        return $this;
    }

    public function getContrainteVisibiliteLimitee(): ?bool
    {
        return $this->contrainte_visibilite_limitee;
    }

    public function setContrainteVisibiliteLimitee(bool $contrainte_visibilite_limitee): self
    {
        $this->contrainte_visibilite_limitee = $contrainte_visibilite_limitee;

        return $this;
    }

    public function getContrainteRoulettesInadequates(): ?bool
    {
        return $this->contrainte_roulettes_inadequates;
    }

    public function setContrainteRoulettesInadequates(bool $contrainte_roulettes_inadequates): self
    {
        $this->contrainte_roulettes_inadequates = $contrainte_roulettes_inadequates;

        return $this;
    }

    public function getContrainteAbsenceFrein(): ?bool
    {
        return $this->contrainte_absence_frein;
    }

    public function setContrainteAbsenceFrein(bool $contrainte_absence_frein): self
    {
        $this->contrainte_absence_frein = $contrainte_absence_frein;

        return $this;
    }

    public function getCoefficientCorrection1(): ?float
    {
        return $this->coefficient_correction_1;
    }

    public function setCoefficientCorrection1(?float $coefficient_correction_1): self
    {
        $this->coefficient_correction_1 = $coefficient_correction_1;

        return $this;
    }

    public function getCoefficientCorrection2(): ?float
    {
        return $this->coefficient_correction_2;
    }

    public function setCoefficientCorrection2(?float $coefficient_correction_2): self
    {
        $this->coefficient_correction_2 = $coefficient_correction_2;

        return $this;
    }

    public function getMasseCorrigee(): ?float
    {
        return $this->masse_corrigee;
    }

    public function setMasseCorrigee(?float $masse_corrigee): self
    {
        $this->masse_corrigee = $masse_corrigee;

        return $this;
    }

    public function getIntituleCoefficientCorrection1(): ?string
    {
        return $this->intitule_coefficient_correction_1;
    }

    public function setIntituleCoefficientCorrection1(?string $intitule_coefficient_correction_1): self
    {
        $this->intitule_coefficient_correction_1 = $intitule_coefficient_correction_1;

        return $this;
    }

    public function getIntituleCoefficientCorrection2(): ?string
    {
        return $this->intitule_coefficient_correction_2;
    }

    public function setIntituleCoefficientCorrection2(?string $intitule_coefficient_correction_2): self
    {
        $this->intitule_coefficient_correction_2 = $intitule_coefficient_correction_2;

        return $this;
    }
}