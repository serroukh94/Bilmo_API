<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ApiResource(
 *  attributes={"pagination_items_per_page"=5},
 *
 *  collectionOperations={
 *      "GET"={
 *          "path"="/products",
 *          "status"=200,
 *          "normalization_context"={"groups"={"product:list"}},
 *
 *      },
 *      "post",
 *  },
 *
 *     itemOperations={
 *      "GET"={
 *          "path"="/products/{id}",
 *          "status"=200,
 *          "normalization_context"={"groups"={"product:single"}},
 *
 *      },
 *      "delete",
 *      "put",
 *  },
 * )
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"product:list", "product:single"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:list", "product:single"})
     *
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     minMessage="Le nom doit contenir au moins {{ limit }} caractères",
     *     maxMessage="Le nom doit contenir au plus {{ limit }} caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Brand is required")
     * @Groups({"product:list", "product:single"})
     */
    private $brand;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Price is required")
     * @Assert\Type(type="numeric", message ="Price must be numeric")
     * @Groups({"product:list", "product:single"})
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     * @Groups({"product:single"})
     */
    private $description;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
