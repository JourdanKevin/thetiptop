<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Ticket;
use App\Entity\User;
use App\Entity\Lot;
use App\Entity\Concours;
use App\Repository\TicketRepository;
// use App\Repository\UserRepository;

// use App\Repository\UserRepository;
// use App\Repository\ConcoursRepositoryRepository;
// use App\Repository\LotRepository;

class TicketController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('api/ticket/{numero}/lot', name: 'get_existing_prize', methods: ['GET'])]
    public function get_existing_prize(String $numero, TicketRepository $ticketRepository): Response
    {
        $ticket = $ticketRepository->find($numero);
        $prize = $ticket->getPrize();
        if ($prize == null){
            $prize = null;
        }else{
            $user = $ticket->getUtilisateur()->getId();
            $prize = ["prize" => $prize, "user" => $user];
        }        
        return $this->json($prize);
    }

    // public function generateUniqueTicketNumber(): string
    // {
    //     $datePrefix = date('Ymd_His');
    //     $datePrefix = substr(base64_encode(date('Ymd_His')), 0, 10);
    //     $randomBytes = random_bytes(7);
    //     $randomString = substr(base64_encode($randomBytes), 0, 10);
    //     $ticketNumber = $datePrefix . $randomString;
    
    //     // Check if the generated ticket number already exists in the database
    //     $existingTicket = $this->entityManager->getRepository(Ticket::class)->findOneBy(['numero' => $ticketNumber]);
    
    //     if ($existingTicket) {
    //         // Collision detected, regenerate the ticket number
    //         return $this->generateUniqueTicketNumber();
    //     }
    
    //     return $ticketNumber;
    // }

    // #[Route('api/ticket/create', name: 'create_ticket', methods: ['POST'])]
    // public function createConcours(Request $request): Response
    // {
    //     $data = json_decode($request->getContent(), true);
    //     $ticket = new Ticket();
    //     $ticket->setNumero($this->generateUniqueTicketNumber());
    //     $ticket->setDate_emission(new \DateTimeImmutable());
    //     $ticket->setStatut_reclamation("generate");
    //     $concours = $this->entityManager->getRepository(Concours::class)->find($data['concours_id']);
    //     $ticket->setConcours($concours);
    //     $this->entityManager->persist($ticket);
    //     $this->entityManager->flush();
    //     return $this->json(['message' => 'Ticket created successfully']);
    // }

    // #[Route('api/ticket/{numero}', name: 'update_ticket', methods: ['POST'])]
    // public function updateConcours(string $numero,Request $request, TicketRepository $ticketRepository): Response
    // {
    //     $data = json_decode($request->getContent(), true);
    //     $ticket = $ticketRepository->findOneBy(['numero' => $numero]);
    //     if (!$ticket){
    //         return $this->json(['message' => "ticket doesn't exist"]);
    //     }
    //     $ticket->setStatut_reclamation("lot tiré");

    //     $utilisateur = $this->entityManager->getRepository(User::class)->find($data['utilisateur_id']);
    //     $lot = $this->entityManager->getRepository(Lot::class)->find($data["lot_id"]);

    //     $ticket->setUtilisateur($utilisateur);
    //     $ticket->setLot($lot);
    
    //     $this->entityManager->persist($ticket);
    //     $this->entityManager->flush();
    //     return $this->json(['message' => 'Ticket updated successfully']);
    // }

    // #[Route('/ticket/tirage', name: 'current_ticket', methods: ['GET'])]
    // public function getCurrentConcours(ConcoursRepository $concoursRepository): Response
    // {
    //     $currentConcours = $concoursRepository->findConcoursByCurrentDate();
    //     return $this->json(['current_concours' => $currentConcours]);
    // }
}
