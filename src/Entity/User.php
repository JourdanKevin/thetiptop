<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

use App\Repository\UserRepository;

use App\Controller\UserController;

use App\Entity\Ticket;
use App\Entity\Concours;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: 'admin/user/{id}', security: 'is_granted("ROLE_ADMIN")'),
        new Get(
            name: 'user_email', 
            uriTemplate: 'api/user/{email}', 
            controller: UserController::class
        ),
        new Get(
            name: 'account', 
            uriTemplate: 'api/account', 
            controller: UserController::class
        ),   
        new Put(
            name: 'account', 
            uriTemplate: 'api/account', 
            controller: UserController::class,
            validationContext: ['groups' => ['user:update']]
        ),    
        new GetCollection(uriTemplate: 'admin/user', security: 'is_granted("ROLE_ADMIN")'),
        new Post(uriTemplate: 'register', validationContext: ['groups' => ['user:create']]),
        new Put(uriTemplate: 'admin/user/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['user:update']]),
        new Patch(uriTemplate: 'admin/user/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['user:update']]),
        new Delete(uriTemplate: 'admin/user/{id}', security: 'is_granted("ROLE_ADMIN")')
    ],
    normalizationContext: ['groups' => ['user:read', 'ticket:read'], 'skip_null_values' => false],
    denormalizationContext: ['groups' => ['user:create', 'user:update']],
    
)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
#[ApiFilter(SearchFilter::class, properties: [
        'id' => 'partial', 'email' => 'partial', 'name' => 'partial'
    ])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable("now");
        $this->updatedAt = new \DateTimeImmutable("now");
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'ticket:read', 'concours:read'])]
    private ?int $id = null;

    #[Assert\NotBlank(groups: ['user:create', 'user:update'])]
    #[Assert\Email(groups: ['user:create', 'user:update'])]
    #[Groups(['user:read', 'user:create', 'user:update', 'ticket:read', 'concours:read'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    
    #[ORM\Column]
    #[Groups(['user:read', 'user:create'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
	#[Groups(['user:read'])]
    private $password;
    
    #[Assert\NotCompromisedPassword]
    #[SerializedName("password")]
    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['user:create', 'user:update'])]
    private ?string $plainPassword = null;

    #[Assert\NotBlank(groups: ['user:create', 'user:update'])]
    #[Groups(['user:read', 'user:create', 'user:update', 'prize:read'])]
    #[ORM\Column(length: 120, nullable: true)]
    private ?string $name = null;

    #[Assert\NotBlank(groups: ['user:create', 'user:update'])]
    #[Groups(['user:read', 'user:create', 'user:update', 'prize:read'])]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $surname = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?\DateTimeInterface $birthDate = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address_2 = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(nullable: true)]
    private ?int $postalCode = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $city = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $country = null;

    #[Groups(['user:read', 'user:create'])]
    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'utilisateur', cascade: ['persist'])]
    #[Groups(['user:read'])]
    private $tickets;

    #[ORM\OneToMany(targetEntity: Concours::class, mappedBy: 'gagnant', cascade: ['persist'])]
    #[Groups(['user:read'])]
    private $concoursGagnes;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birth_date): self
    {
        $this->birthDate = $birth_date;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address_2;
    }

    public function setAddress2(?string $address_2): self
    {
        $this->address_2 = $address_2;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postal_code): self
    {
        $this->postalCode = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->createdAt = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updatedAt = $updated_at;

        return $this;
    }

    public function getTickets()
    {
        return $this->tickets;
    }
    public function getConcoursGagnes()
    {
        return $this->concoursGagnes;
    }
}
