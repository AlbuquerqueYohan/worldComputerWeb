<?php

namespace App\Entity;

use App\Repository\OrdinateursRepository;
use Cassandra\Date;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: OrdinateursRepository::class)]
#[Vich\Uploadable]
class Ordinateurs
{

    const TYPE = [
        1 => 'fixe',
        2 => 'portable'
    ];

    const TYPE_STOCKAGE = [
        1 => 'HDD',
        2 => 'SSD'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $filename;

    #[Vich\UploadableField(mapping: 'computer_image', fileNameProperty: 'filename')]
    private $imageFile;

    #[ORM\Column(type: 'string', length: 255)]
    private $Nom;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Range(min: 2, max: 64)]
    private $Ram;

    #[ORM\Column(type: 'text')]
    private $Processeur;

    #[ORM\Column(type: 'text', nullable: true)]
    private $carte_graphique;

//    #[Assert\Regex("/[0-9]+\.[0-9]{3}/")]
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
    #[Assert\Length(min: 0, max: 200)]
    private $caracteristique;

    #[ORM\Column(type: 'text', nullable: true)]
    private $port_usb;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private $type_stockage;

    #[ORM\ManyToOne(targetEntity: Marques::class, inversedBy: 'marques_fk')]
    private $marques_fk;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updated_at;

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

    // Slug is use for URL
    public function getSlug(): string
    {
        $slugify = new Slugify();
        // retourne le nom de l'ordinateur en chaine de caractère pour l'URL
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

    public function getTypeText(): string
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

    public function getTypeStockage(): ?string
    {
        return $this->type_stockage;
    }

    public function getStockageText(): string
    {
        return self::TYPE_STOCKAGE[$this->type_stockage];
    }

    public function setTypeStockage(?string $type_stockage): self
    {
        $this->type_stockage = $type_stockage;

        return $this;
    }

    public function getMarquesFk(): ?Marques
    {
        return $this->marques_fk;
    }

    public function setMarquesFk(?Marques $marques_fk): self
    {
        $this->marques_fk = $marques_fk;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFileName($filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param mixed $imageFile
     */
    public function setImageFile(mixed $imageFile): Ordinateurs
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
