<?php

namespace App\Entity;

use App\Repository\Grille1ED6161Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Grille1ED6161Repository::class)
 */
class Grille1ED6161
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=EvaluationED6161::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $evaluation_ED6161;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valeurs;

    private $value_Q1;
    private $value_Q2;
    private $value_Q3;
    private $value_Q4;
    private $value_Q5;
    private $value_Q6;
    private $value_Q7;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluationED6161(): ?EvaluationED6161
    {
        return $this->evaluation_ED6161;
    }

    public function setEvaluationED6161(EvaluationED6161 $evaluation_ED6161): self
    {
        $this->evaluation_ED6161 = $evaluation_ED6161;

        return $this;
    }

    public function getValeurs(): ?string
    {
        return $this->valeurs;
    }

    public function setValeurs(?string $valeurs): self
    {
        $this->valeurs = $valeurs;

        return $this;
    }

    public function getValueQ1(): ?string
    {
        return $this->value_Q1;
    }

    public function setValueQ1(string $value_Q1): self
    {
        $this->value_Q1 = $value_Q1;

        return $this;
    }

    public function getValueQ2(): ?string
    {
        return $this->value_Q2;
    }

    public function setValueQ2(string $value_Q2): self
    {
        $this->value_Q2 = $value_Q2;

        return $this;
    }

    public function getValueQ3(): ?string
    {
        return $this->value_Q3;
    }

    public function setValueQ3(string $value_Q3): self
    {
        $this->value_Q3 = $value_Q3;

        return $this;
    }

    public function getValueQ4(): ?string
    {
        return $this->value_Q4;
    }

    public function setValueQ4(string $value_Q4): self
    {
        $this->value_Q4 = $value_Q4;

        return $this;
    }

    public function getValueQ5(): ?string
    {
        return $this->value_Q5;
    }

    public function setValueQ5(string $value_Q5): self
    {
        $this->value_Q5 = $value_Q5;

        return $this;
    }

    public function getValueQ6(): ?string
    {
        return $this->value_Q6;
    }

    public function setValueQ6(string $value_Q6): self
    {
        $this->value_Q6 = $value_Q6;

        return $this;
    }

    public function getValueQ7(): ?string
    {
        return $this->value_Q7;
    }

    public function setValueQ7(string $value_Q7): self
    {
        $this->value_Q7 = $value_Q7;

        return $this;
    }
}
