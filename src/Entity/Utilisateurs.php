<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method string getUserIdentifier()
 */
#[ORM\Entity(repositoryClass: UtilisateursRepository::class)]
class Utilisateurs implements UserInterface, \Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $Nom;

    #[ORM\Column(type: 'string', length: 50)]
    private $Prenom;

    #[ORM\Column(type: 'string', length: 50)]
    private $pseudo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Ville;

    #[ORM\Column(type: 'boolean')]
    private $is_admin;

    #[ORM\Column(type: 'string', length: 255)]
    private $mot_de_passe;

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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->is_admin;
    }

    public function setIsAdmin(bool $is_admin): self
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function serialize()
    {
        return $this->serialize([
            $this->id,
            $this->pseudo,
            $this->mot_de_passe
        ]);
    }

    public function unserialize(string $data)
    {
        list(
            $this->id,
            $this->pseudo,
            $this->mot_de_passe
            ) = unserialize($data, ['allowed_classes' => false]);
    }

    public function __serialize(): array
    {
        // TODO: Implement __serialize() method.
    }

    public function __unserialize(array $data): void
    {
        // TODO: Implement __unserialize() method.
    }
}
