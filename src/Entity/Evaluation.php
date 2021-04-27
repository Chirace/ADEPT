<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvaluationRepository::class)
 */
class Evaluation
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
    private $type_evaluation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_evaluation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEvaluation(): ?string
    {
        return $this->type_evaluation;
    }

    public function setTypeEvaluation(string $type_evaluation): self
    {
        $this->type_evaluation = $type_evaluation;

        return $this;
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
}
