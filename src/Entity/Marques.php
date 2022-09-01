<?php

namespace App\Entity;

use App\Repository\MarquesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarquesRepository::class)]
class Marques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\OneToMany(mappedBy: 'marques_fk', targetEntity: Ordinateurs::class)]
    private $marques_fk;

    public function __construct()
    {
        $this->marques_fk = new ArrayCollection();
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

    /**
     * @return Collection<int, Ordinateurs>
     */
    public function getMarquesFk(): Collection
    {
        return $this->marques_fk;
    }

    public function addMarquesFk(Ordinateurs $marquesFk): self
    {
        if (!$this->marques_fk->contains($marquesFk)) {
            $this->marques_fk[] = $marquesFk;
            $marquesFk->setMarquesFk($this);
        }

        return $this;
    }

    public function removeMarquesFk(Ordinateurs $marquesFk): self
    {
        if ($this->marques_fk->removeElement($marquesFk)) {
            // set the owning side to null (unless already changed)
            if ($marquesFk->getMarquesFk() === $this) {
                $marquesFk->setMarquesFk(null);
            }
        }

        return $this;
    }

}
