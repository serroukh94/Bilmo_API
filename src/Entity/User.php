<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource()
 *
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Il existe déja un mail {{ value }}, veuillez saisir un autre mail."
 * )
 * @method string getUserIdentifier()
 */
class User implements UserInterface, \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    const ROLE_ADMIN= 'ROLE_ADMIN';
    const DEFAULT_ROLE= 'ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Username is required")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Username must be at least {{ limit }} characters long",
     *      maxMessage = "Username cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email is not a valid email.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Password is required")
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="users")
     */
    private $client;

    public function __construct()
    {

        $leRole[]=[self::DEFAULT_ROLE];
        $this->roles = $leRole;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getSalt()
    {

    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}
