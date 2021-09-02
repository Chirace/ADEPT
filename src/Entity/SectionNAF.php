<?php

namespace App\Entity;

use App\Repository\SectionNAFRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectionNAFRepository::class)
 */
class SectionNAF
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=DivisionNAF::class, mappedBy="section_NAF")
     */
    private $divisionNAFs;

    public function __construct()
    {
        $this->divisionNAFs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|DivisionNAF[]
     */
    public function getDivisionNAFs(): Collection
    {
        return $this->divisionNAFs;
    }

    public function addDivisionNAF(DivisionNAF $divisionNAF): self
    {
        if (!$this->divisionNAFs->contains($divisionNAF)) {
            $this->divisionNAFs[] = $divisionNAF;
            $divisionNAF->setSectionNAF($this);
        }

        return $this;
    }

    public function removeDivisionNAF(DivisionNAF $divisionNAF): self
    {
        if ($this->divisionNAFs->removeElement($divisionNAF)) {
            // set the owning side to null (unless already changed)
            if ($divisionNAF->getSectionNAF() === $this) {
                $divisionNAF->setSectionNAF(null);
            }
        }

        return $this;
    }
}
