<?php

namespace App\Entity;

use App\Repository\BilanEvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BilanEvaluationRepository::class)
 */
class BilanEvaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=BilanEntreprise::class, inversedBy="bilanEvaluations")
     */
    private $bilan;

    /**
     * @ORM\ManyToOne(targetEntity=Evaluation::class, inversedBy="bilanEvaluations")
     */
    private $evaluation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBilan(): ?BilanEntreprise
    {
        return $this->bilan;
    }

    public function setBilan(?BilanEntreprise $bilan): self
    {
        $this->bilan = $bilan;

        return $this;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
