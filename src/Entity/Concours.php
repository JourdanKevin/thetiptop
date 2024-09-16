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

use App\Repository\ConcoursRepository;

use App\Controller\ConcoursController;

use App\Entity\Ticket;

#[ORM\Entity(repositoryClass: ConcoursRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: 'concours'),
        new Get(
            name: 'concours_winner', 
            uriTemplate: 'concours/{id}/winner', 
            controller: ConcoursController::class
        ),
        new Get(
            name: 'current_concours', 
            uriTemplate: 'current/concours', 
            controller: ConcoursController::class
        ),
        new Get(uriTemplate: 'admin/concours/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['concours:read']]),
        new Post(uriTemplate: 'admin/concours', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['concours:create']]),
        new Put(uriTemplate: 'admin/concours/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['concours:update']]),
        new Patch(uriTemplate: 'admin/concours/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['concours:update']]),
        new Delete(uriTemplate: 'admin/concours/{id}', security: 'is_granted("ROLE_ADMIN")'),
    ],
    normalizationContext: ['groups' => ['concours:read', 'ticket:read'], 'skip_null_values' => false],
    denormalizationContext: ['groups' => ['concours:create', 'concours:update']]

)]

#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'partial', 'nom' => 'partial',
    'gagnant.id' => 'exact', 'gagnant.email' => 'exact'
    ])]
class Concours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['concours:read', 'ticket:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(groups: ['concours:create', 'concours:update'])]
    #[Assert\NotBlank(groups: ['concours:create', 'concours:update'])]
    #[Groups(['concours:read','concours:create', 'concours:update', 'ticket:read', 'user:read'])]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['concours:read', 'concours:create', 'concours:update'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['concours:read', 'concours:create', 'concours:update'])]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\Column]
    #[Groups(['concours:read','concours:create', 'concours:update'])]
    private ?\DateTimeImmutable $dateFin = null;

    #[ORM\Column]
    #[Groups(['concours:read','concours:create', 'concours:update'])]
    private ?\DateTimeImmutable $dateTirage = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:"concoursGagnes", cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['concours:read'])]
    private ?User $gagnant = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'concours', cascade: ['persist'])]
    #[Groups(['concours:read'])]
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

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): self
    {
        $this->dateDebut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeImmutable $date_fin): self
    {
        $this->dateFin = $date_fin;

        return $this;
    }

    public function getDateTirage(): ?\DateTimeImmutable
    {
        return $this->dateTirage;
    }

    public function setDateTirage(\DateTimeImmutable $date_tirage): self
    {
        $this->dateTirage = $date_tirage;

        return $this;
    }
    public function getTickets()
    {
        return $this->tickets;
    }

    public function getGagnant()
    {
        return $this->gagnant;
    }
    
    public function setGagnant(User $utilisateur): self
    {
        $this->gagnant = $utilisateur;

        return $this;
    }
}
