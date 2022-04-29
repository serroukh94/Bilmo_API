<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)

 * @ApiResource(
 *
 * collectionOperations={
 *      "GET"={
 *          "path"="/clients",
 *          "status"=200,
 *          "normalization_context"={"groups"={"clients:list"}}
 *      },
 *      "POST"={
 *          "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *          "path"="/clients",
 *          "status"=200
 *      }
 *  },
 *
 *     itemOperations={
 *      "GET"={
 *          "path"="/clients/{id}",
 *          "status"=200,
 *          "normalization_context"={"groups"={"clients:single"}}
 *      },
 *      "DELETE"={
 *          "path"="/clients/{id}",
 *          "status"=204,
 *      }
 *  },
 * )
 * @method string getUserIdentifier()
 */
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{

    const ROLE_ADMIN= 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"clients:single", "clients:list", "clients:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"clients:single", "clients:list", "clients:write"})
     * @Assert\NotBlank(message="Name is required")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Your name must be at least {{ limit }} characters long",
     *      maxMessage = "Your name cannot be longer than {{ limit }} characters",
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="client")
     * @Groups({"clients:single", "clients:list", "clients:write"})
     * @Assert\NotBlank(message="User is required")
     * @ApiSubresource()
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email is not a valid email.")
     * @Groups({"clients:single", "clients:list", "clients:write"})
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
     * @Groups({"clients:single", "clients:list", "clients:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_ADMIN"];

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setClient($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getClient() === $this) {
                $user->setClient(null);
            }
        }

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
        $roles = $this->roles;

        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {

    }


}
