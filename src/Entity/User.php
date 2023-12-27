<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EventListener\UserListener'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Email cannot be blank')]
    #[Assert\Email(message: 'Email is not valid')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'First name cannot be blank')]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Last name cannot be blank')]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Address cannot be blank')]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'City cannot be blank')]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Zipcode cannot be blank')]
    private ?string $zipcode = null;

    private ?string $plainPassword = null;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function updateIdentifier(string $email, string $plainPassword): self
    {
        $this->email = $email == null ? $this->email : trim($email);
        $this->plainPassword = $plainPassword == null ? $this->plainPassword : trim($plainPassword);
        return $this;
    }

    public function updateIdentity(string $firstName, string $lastName): self
    {
        $this->firstName = $firstName == null ? $this->firstName : trim($firstName);
        $this->lastName = $lastName == null ? $this->lastName : trim($lastName);
        return $this;
    }

    public function updateAddress(string $address, string $city, string $zipcode): self
    {
        $this->address = $address == null ? $this->address : trim($address);
        $this->city = $city == null ? $this->city : trim($city);
        $this->zipcode = $zipcode == null ? $this->zipcode : trim($zipcode);
        return $this;
    }

    public function updatePlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword == null ? $this->plainPassword : trim($plainPassword);
        return $this;
    }

    public function updatePassword(string $password): self
    {
        $this->password = $password == null ? $this->password : trim($password);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'address' => $this->address,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

}
