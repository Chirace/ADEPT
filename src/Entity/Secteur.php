<?php

namespace App\Entity;

use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecteurRepository::class)
 */
class Secteur
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class, inversedBy="secteurs")
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity=PosteDeTravail::class, mappedBy="secteur")
     */
    private $posteDeTravails;

    public function __construct()
    {
        $this->posteDeTravails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|PosteDeTravail[]
     */
    public function getPosteDeTravails(): Collection
    {
        return $this->posteDeTravails;
    }

    public function addPosteDeTravail(PosteDeTravail $posteDeTravail): self
    {
        if (!$this->posteDeTravails->contains($posteDeTravail)) {
            $this->posteDeTravails[] = $posteDeTravail;
            $posteDeTravail->setSecteur($this);
        }

        return $this;
    }

    public function removePosteDeTravail(PosteDeTravail $posteDeTravail): self
    {
        if ($this->posteDeTravails->removeElement($posteDeTravail)) {
            // set the owning side to null (unless already changed)
            if ($posteDeTravail->getSecteur() === $this) {
                $posteDeTravail->setSecteur(null);
            }
        }

        return $this;
    }
}
