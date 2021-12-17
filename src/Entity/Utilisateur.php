<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 *  fields={"mail"},
 *  message="L'adresse mail que vous avez renseignée est déjà utilisée !"
 * )
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe sont différents")
     */
    private $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=Evaluateur::class, mappedBy="utilisateur")
     */
    private $evaluateurs;

    /**
     * @ORM\OneToMany(targetEntity=BilanEntreprise::class, mappedBy="Utilisateur")
     */
    private $bilanEntreprises;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    public function __construct()
    {
        $this->evaluateurs = new ArrayCollection();
        $this->bilanEntreprises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    public function eraseCredentials() {}

    public function getSalt() {}

    public function getRoles() {
        //return ['ROLE_USER'];
        return $this->roles;
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Evaluateur[]
     */
    public function getEvaluateurs(): Collection
    {
        return $this->evaluateurs;
    }

    public function addEvaluateur(Evaluateur $evaluateur): self
    {
        if (!$this->evaluateurs->contains($evaluateur)) {
            $this->evaluateurs[] = $evaluateur;
            $evaluateur->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEvaluateur(Evaluateur $evaluateur): self
    {
        if ($this->evaluateurs->removeElement($evaluateur)) {
            // set the owning side to null (unless already changed)
            if ($evaluateur->getUtilisateur() === $this) {
                $evaluateur->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BilanEntreprise[]
     */
    public function getBilanEntreprises(): Collection
    {
        return $this->bilanEntreprises;
    }

    public function addBilanEntreprise(BilanEntreprise $bilanEntreprise): self
    {
        if (!$this->bilanEntreprises->contains($bilanEntreprise)) {
            $this->bilanEntreprises[] = $bilanEntreprise;
            $bilanEntreprise->setUtilisateur($this);
        }

        return $this;
    }

    public function removeBilanEntreprise(BilanEntreprise $bilanEntreprise): self
    {
        if ($this->bilanEntreprises->removeElement($bilanEntreprise)) {
            // set the owning side to null (unless already changed)
            if ($bilanEntreprise->getUtilisateur() === $this) {
                $bilanEntreprise->setUtilisateur(null);
            }
        }

        return $this;
    }
}
