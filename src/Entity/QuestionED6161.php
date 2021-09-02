<?php

namespace App\Entity;

use App\Repository\QuestionED6161Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionED6161Repository::class)
 */
class QuestionED6161
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=DomaineED6161::class, inversedBy="questionED6161s")
     * @ORM\JoinColumn(nullable=false)
     */
    private $domaine_ED6161;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomaineED6161(): ?DomaineED6161
    {
        return $this->domaine_ED6161;
    }

    public function setDomaineED6161(?DomaineED6161 $domaine_ED6161): self
    {
        $this->domaine_ED6161 = $domaine_ED6161;

        return $this;
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
}
