<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;

use App\Controller\PrizeController;

use App\Repository\PrizeRepository;

use App\Entity\Ticket;

#[ORM\Entity(repositoryClass: PrizeRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: 'prize'),       
        new Get(uriTemplate: 'prize/{id}'),
        new Get(
            name: 'rand_prize', 
            uriTemplate: 'random/prize', 
            controller: PrizeController::class,
            normalizationContext: ['groups' => ['prize:random']]
        ),
        new Post(uriTemplate: 'admin/prize', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['prize:create']]),
        new Put(uriTemplate: 'admin/prize/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['prize:update']]),
        new Patch(uriTemplate: 'admin/prize/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['prize:update']]),
        new Delete(uriTemplate: 'admin/prize/{id}', security: 'is_granted("ROLE_ADMIN")'),
    ],
    normalizationContext: ['groups' => ['prize:read', 'ticket:read','prize:random'], 'skip_null_values' => false],
    denormalizationContext: ['groups' => ['prize:create', 'prize:update']],

)]

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'partial', 'nom' => 'partial'
])]
class Prize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['prize:read', 'ticket:read', 'user:read','prize:random'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(groups: ['prize:create', 'prize:update'])]
    #[Assert\NotBlank(groups: ['prize:create', 'prize:update'])]
    #[Groups(['prize:read', 'prize:create', 'prize:update', 'ticket:read', 'user:read', 'prize:random'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['prize:read', 'prize:create', 'prize:update','prize:random'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups(['prize:read', 'prize:create', 'prize:update','prize:random'])]
    private ?float $valeur = null;

    #[ORM\Column]
    #[Assert\NotNull(groups: ['prize:create', 'prize:update'])]
    #[Assert\Positive]
    #[Groups(['prize:read', 'prize:create', 'prize:update','prize:random'])]
    private ?int $probability = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'prize', cascade: ['persist'])]
    #[Groups(['prize:read'])]
    private $tickets;
	
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getProbability(): ?int
    {
        return $this->probability;
    }

    public function setProbability(int $probability): self
    {
        $this->probability = $probability;

        return $this;
    }
    
    public function getTickets(){
        return $this->tickets;
    }
}
