<?php

namespace App\Entity;

use App\Repository\EvaluationNFXRepository;
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
     * @ORM\Column(type="float")
     */
    private $poids_charge;

    /**
     * @ORM\Column(type="float")
     */
    private $prise_hauteur;

    /**
     * @ORM\Column(type="float")
     */
    private $prise_profondeur;

    /**
     * @ORM\Column(type="float")
     */
    private $depose_hauteur;

    /**
     * @ORM\Column(type="float")
     */
    private $depose_profondeur;

    /**
     * @ORM\Column(type="float")
     */
    private $force_initiale;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $force_maintien;

    /**
     * @ORM\Column(type="float")
     */
    private $distance_transport_charge;

    /**
     * @ORM\Column(type="float")
     */
    private $temps_tonnage;

    /**
     * @ORM\Column(type="float")
     */
    private $tonnage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transport_charge;

    /**
     * @ORM\Column(type="float")
     */
    private $frequence_charge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PT_action;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PT_distance;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PT_hauteur_poignee;

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

    public function getForceMaintien(): ?float
    {
        return $this->force_maintien;
    }

    public function setForceMaintien(?float $force_maintien): self
    {
        $this->force_maintien = $force_maintien;

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

    public function getTransportCharge(): ?string
    {
        return $this->transport_charge;
    }

    public function setTransportCharge(string $transport_charge): self
    {
        $this->transport_charge = $transport_charge;

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

    public function getPTAction(): ?string
    {
        return $this->PT_action;
    }

    public function setPTAction(?string $PT_action): self
    {
        $this->PT_action = $PT_action;

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
}
