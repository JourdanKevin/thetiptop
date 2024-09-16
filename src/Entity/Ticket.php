<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Validator\Constraints\Ulid as ConstraintsUlid;
use App\Controller\TicketController;

use App\Repository\TicketRepository;

use App\Entity\User;
use App\Entity\Prize;
use App\Entity\Concours;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: 'admin/ticket', security: 'is_granted("ROLE_ADMIN")'),     
        new Get(uriTemplate: 'admin/ticket/{id}', security: 'is_granted("ROLE_ADMIN")'),
        new Get(
            name: 'get_existing_prize', 
            uriTemplate: 'ticket/{numero}/lot', 
            controller: TicketController::class
        ),
        new Post(uriTemplate: 'ticket', security: 'is_granted("ROLE_USER")', validationContext: ['groups' => ['ticket.create']]),
        new Put(uriTemplate: 'ticket/{id}', security: 'is_granted("ROLE_USER")', validationContext: ['groups' => ['ticket:update']]),
        new Patch(uriTemplate: 'admin/ticket/{id}', security: 'is_granted("ROLE_ADMIN")', validationContext: ['groups' => ['ticket:update']]),
        new Delete(uriTemplate: 'admin/ticket/{id}', security: 'is_granted("ROLE_ADMIN")'),
    ],
    normalizationContext: ['groups' => ['ticket:read'], 'skip_null_values' => false],
    denormalizationContext: ['groups' => ['ticket:create', 'ticket:update']],

)]
#[ApiFilter(SearchFilter::class, properties: [
    'utilisateur.id' => 'exact', 'utilisateur.email' => 'exact', 'utilisateur.name' => 'exact', 
    'prize.id' => 'exact', 'prize.nom' => 'exact',
    'concours.id' => 'exact', 'concours.nom' => 'exact',
    ])]
class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    #[SerializedName("numero")]
    #[Groups(['ticket:read', 'user:read', 'prize:read', 'concours:read'])]
    private ?Ulid $id;

    #[ORM\Column]
    #[Groups(['ticket:read', 'ticket:create', 'ticket:update'])]
    private ?\DateTimeImmutable $dateEmission = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['ticket:read','ticket:update', 'user:read', 'concours:read'])]
    private ?\DateTimeImmutable $dateReclamation = null;
    
    #[ORM\Column(length: 50)]
    #[Groups(['ticket:read','ticket:create', 'ticket:update', 'user:read', 'concours:read'])] 
    private ?string $statutReclamation = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:"tickets")]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['ticket:read','ticket:update', 'prize:read', 'concours:read'])]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(targetEntity: Prize::class, inversedBy:"tickets")]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['ticket:read', 'ticket:update', 'user:read', 'concours:read'])]
    private ?Prize $prize = null;

    #[ORM\ManyToOne(targetEntity: Concours::class, inversedBy:"tickets")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['ticket:read','ticket:create', 'user:read', 'prize:read'])]
    private ?Concours $concours = null;

     /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        // Generate the value only during creation
        if ($this->getDateEmission() === null) {
            $this->dateEmission = new \DateTimeImmutable();
        }
    }


    public function getId(): ?Ulid
    {
        return $this->id;
    }

    public function getDateEmission(): ?\DateTimeImmutable
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeImmutable $date_emission): self
    {
        $this->dateEmission = $date_emission;

        return $this;
    }

    public function getDateReclamation(): ?\DateTimeImmutable
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation(?\DateTimeImmutable $date_reclamation): self
    {
        $this->dateReclamation = $date_reclamation;

        return $this;
    }

    public function getStatutReclamation(): ?string
    {
        return $this->statutReclamation;
    }

    public function setStatutReclamation(string $statut_reclamation): self
    {
        $this->statutReclamation = $statut_reclamation;

        return $this;
    }
    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
    public function getPrize(): ?Prize
    {
        return $this->prize;
    }

    public function setPrize(Prize $prize): self
    {
        $this->prize = $prize;

        return $this;
    }
    public function getConcours(): ?Concours
    {
        return $this->concours;
    }

    public function setConcours(Concours $concours): self
    {
        $this->concours = $concours;

        return $this;
    }
}
