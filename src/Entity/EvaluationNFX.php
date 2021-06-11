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
}