<?php

namespace App\Entity;

use App\Repository\Grille2ED6161Repository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Grille2ED6161Repository::class)
 */
class Grille2ED6161
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
    private $value_Q8;
    private $value_Q9;
    private $value_Q10;
    private $value_Q11;
    private $value_Q12;
    private $value_Q13;
    private $value_Q14;
    private $value_Q15;
    private $value_Q16;
    private $value_Q17;
    private $value_Q18;
    private $value_Q19;
    private $value_Q20;
    private $value_Q21;
    private $value_Q22;
    private $value_Q23;
    private $value_Q24;
    private $value_Q25;

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

    public function getValueQ8(): ?string
    {
        return $this->value_Q8;
    }

    public function setValueQ8(string $value_Q8): self
    {
        $this->value_Q8 = $value_Q8;

        return $this;
    }

    public function getValueQ9(): ?string
    {
        return $this->value_Q9;
    }

    public function setValueQ9(string $value_Q9): self
    {
        $this->value_Q9 = $value_Q9;

        return $this;
    }

    public function getValueQ10(): ?string
    {
        return $this->value_Q10;
    }

    public function setValueQ10(string $value_Q10): self
    {
        $this->value_Q10 = $value_Q10;

        return $this;
    }

    public function getValueQ11(): ?string
    {
        return $this->value_Q11;
    }

    public function setValueQ11(string $value_Q11): self
    {
        $this->value_Q11 = $value_Q11;

        return $this;
    }

    public function getValueQ12(): ?string
    {
        return $this->value_Q12;
    }

    public function setValueQ12(string $value_Q12): self
    {
        $this->value_Q12 = $value_Q12;

        return $this;
    }

    public function getValueQ13(): ?string
    {
        return $this->value_Q13;
    }

    public function setValueQ13(string $value_Q13): self
    {
        $this->value_Q13 = $value_Q13;

        return $this;
    }

    public function getValueQ14(): ?string
    {
        return $this->value_Q14;
    }

    public function setValueQ14(string $value_Q14): self
    {
        $this->value_Q14 = $value_Q14;

        return $this;
    }

    public function getValueQ15(): ?string
    {
        return $this->value_Q15;
    }

    public function setValueQ15(string $value_Q15): self
    {
        $this->value_Q15 = $value_Q15;

        return $this;
    }

    public function getValueQ16(): ?string
    {
        return $this->value_Q16;
    }

    public function setValueQ16(string $value_Q16): self
    {
        $this->value_Q16 = $value_Q16;

        return $this;
    }

    public function getValueQ17(): ?string
    {
        return $this->value_Q17;
    }

    public function setValueQ17(string $value_Q17): self
    {
        $this->value_Q17 = $value_Q17;

        return $this;
    }

    public function getValueQ18(): ?string
    {
        return $this->value_Q18;
    }

    public function setValueQ18(string $value_Q18): self
    {
        $this->value_Q18 = $value_Q18;

        return $this;
    }

    public function getValueQ19(): ?string
    {
        return $this->value_Q19;
    }

    public function setValueQ19(string $value_Q19): self
    {
        $this->value_Q19 = $value_Q19;

        return $this;
    }

    public function getValueQ20(): ?string
    {
        return $this->value_Q20;
    }

    public function setValueQ20(string $value_Q20): self
    {
        $this->value_Q20 = $value_Q20;

        return $this;
    }

    public function getValueQ21(): ?string
    {
        return $this->value_Q21;
    }

    public function setValueQ21(string $value_Q21): self
    {
        $this->value_Q21 = $value_Q21;

        return $this;
    }

    public function getValueQ22(): ?string
    {
        return $this->value_Q22;
    }

    public function setValueQ22(string $value_Q22): self
    {
        $this->value_Q22 = $value_Q22;

        return $this;
    }

    public function getValueQ23(): ?string
    {
        return $this->value_Q23;
    }

    public function setValueQ23(string $value_Q23): self
    {
        $this->value_Q23 = $value_Q23;

        return $this;
    }

    public function getValueQ24(): ?string
    {
        return $this->value_Q24;
    }

    public function setValueQ24(string $value_Q24): self
    {
        $this->value_Q24 = $value_Q24;

        return $this;
    }

    public function getValueQ25(): ?string
    {
        return $this->value_Q25;
    }

    public function setValueQ25(string $value_Q25): self
    {
        $this->value_Q25 = $value_Q25;

        return $this;
    }
}
