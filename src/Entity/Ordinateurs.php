<?php

namespace App\Entity;

use App\Repository\OrdinateursRepository;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: OrdinateursRepository::class)]
class Ordinateurs
{

    const TYPE = [
        0 => 'fixe',
        1 => 'portable'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Ram;

    #[ORM\Column(type: 'text')]
    private $Processeur;

    #[ORM\Column(type: 'text', nullable: true)]
    private $carte_graphique;

    #[ORM\Column(type: 'float', nullable: true)]
    private $Poids;

    #[ORM\Column(type: 'text', nullable: true)]
    private $dimensions_ecran;

    #[ORM\Column(type: 'datetime')]
    private $ajoute_le;

    #[ORM\Column(type: 'text')]
    private $type;

    #[ORM\Column(type: 'text', nullable: true)]
    private $stockage;

    #[ORM\Column(type: 'text', nullable: true)]
    private $caracteristique;

    #[ORM\Column(type: 'text', nullable: true)]
    private $port_usb;

    public function __construct()
    {
        $this->ajoute_le = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    // Slug is use for made a good URL
    public function getSlug(): string
    {
        $slugify = new Slugify();
        return $slugify->slugify($this->Nom);
    }

    public function getRam(): ?int
    {
        return $this->Ram;
    }

    public function setRam(?int $Ram): self
    {
        $this->Ram = $Ram;

        return $this;
    }

    public function getProcesseur(): ?string
    {
        return $this->Processeur;
    }

    public function setProcesseur(string $Processeur): self
    {
        $this->Processeur = $Processeur;

        return $this;
    }

    public function getCarteGraphique(): ?string
    {
        return $this->carte_graphique;
    }

    public function setCarteGraphique(?string $carte_graphique): self
    {
        $this->carte_graphique = $carte_graphique;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->Poids;
    }

    public function setPoids(?float $Poids): self
    {
        $this->Poids = $Poids;

        return $this;
    }

    public function getDimensionsEcran(): ?string
    {
        return $this->dimensions_ecran;
    }

    public function setDimensionsEcran(?string $dimensions_ecran): self
    {
        $this->dimensions_ecran = $dimensions_ecran;

        return $this;
    }

    public function getAjouteLe(): ?\DateTimeInterface
    {
        return $this->ajoute_le;
    }

    public function setAjouteLe(\DateTimeInterface $ajoute_le): self
    {
        $this->ajoute_le = $ajoute_le;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeText():string
    {
        return self::TYPE[$this->type];
    }

    public function getStockage(): ?string
    {
        return $this->stockage;
    }

    public function setStockage(?string $stockage): self
    {
        $this->stockage = $stockage;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(?string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    public function getPortUsb(): ?string
    {
        return $this->port_usb;
    }

    public function setPortUsb(?string $port_usb): self
    {
        $this->port_usb = $port_usb;

        return $this;
    }
}
