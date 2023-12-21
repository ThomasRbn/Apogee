<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Product name cannot be blank')]
    #[Assert\Length(min: 3, max: 50,
        minMessage: 'Product name must be at least {{ limit }} characters long',
        maxMessage: 'Product name cannot be longer than {{ limit }} characters')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Product description cannot be blank')]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Product description must be at least {{ limit }} characters long',
        maxMessage: 'Product description cannot be longer than {{ limit }} characters')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Product price cannot be blank')]
    #[Assert\Positive(message: 'Product price must be positive')]
    private ?float $price = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public static function createProduct(string $name, string $description, float $price): self
    {
        $product = new Product();
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        return $product;
    }


    public function updateProduct(string $name, string $description, float $price): self
    {
        $this->name = $name == null ? $this->name : $name;
        $this->description = $description == null ? $this->description : $description;
        $this->price = $price == null ? $this->price : $price;
        $this->updatedAt = new \DateTimeImmutable();
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
        ];
    }

    //Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
