<?php

namespace App\Entity;

use App\Repository\DomaineED6161Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DomaineED6161Repository::class)
 */
class DomaineED6161
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
    private $intitule;

    /**
     * @ORM\OneToMany(targetEntity=QuestionED6161::class, mappedBy="domaine_ED6161")
     */
    private $questionED6161s;

    public function __construct()
    {
        $this->questionED6161s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection|QuestionED6161[]
     */
    public function getQuestionED6161s(): Collection
    {
        return $this->questionED6161s;
    }

    public function addQuestionED6161(QuestionED6161 $questionED6161): self
    {
        if (!$this->questionED6161s->contains($questionED6161)) {
            $this->questionED6161s[] = $questionED6161;
            $questionED6161->setDomaineED6161($this);
        }

        return $this;
    }

    public function removeQuestionED6161(QuestionED6161 $questionED6161): self
    {
        if ($this->questionED6161s->removeElement($questionED6161)) {
            // set the owning side to null (unless already changed)
            if ($questionED6161->getDomaineED6161() === $this) {
                $questionED6161->setDomaineED6161(null);
            }
        }

        return $this;
    }
}
