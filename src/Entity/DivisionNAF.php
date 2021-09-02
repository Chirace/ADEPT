<?php

namespace App\Entity;

use App\Repository\DivisionNAFRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DivisionNAFRepository::class)
 */
class DivisionNAF
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SectionNAF::class, inversedBy="divisionNAFs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section_NAF;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Evaluateur::class, mappedBy="secteur_activite")
     */
    private $evaluateursExterne;

    public function __construct()
    {
        $this->evaluateursExterne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectionNAF(): ?SectionNAF
    {
        return $this->section_NAF;
    }

    public function setSectionNAF(?SectionNAF $section_NAF): self
    {
        $this->section_NAF = $section_NAF;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $evaluateursExterne->setSecteurActivite($this);
        }

        return $this;
    }

    public function removeEvaluateursExterne(Evaluateur $evaluateursExterne): self
    {
        if ($this->evaluateursExterne->removeElement($evaluateursExterne)) {
            // set the owning side to null (unless already changed)
            if ($evaluateursExterne->getSecteurActivite() === $this) {
                $evaluateursExterne->setSecteurActivite(null);
            }
        }

        return $this;
    }
}
