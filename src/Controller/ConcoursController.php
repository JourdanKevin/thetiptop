<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Concours;
use App\Entity\Ticket;
use App\Repository\ConcoursRepository;

class ConcoursController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('api/current/concours', name: 'current_concours', methods: ['GET'])]
    public function getCurrentConcours(ConcoursRepository $concoursRepository)
    {
        $currentConcours = $concoursRepository->findConcoursByCurrentDate();
        return $this->json(['current_concours' => $currentConcours]);
    }
    
    #[Route('api/concours/{id}/winner', name: 'concours_winner', methods: ['GET'])]
    public function getConcoursWinner(int $id, ConcoursRepository $concoursRepository)
    {
        $concours = $concoursRepository->find($id);
        $gagnant = $concours->getGagnant();
        if ($gagnant){
            return $this->json(["gagnant" => $gagnant->getName()." ".$gagnant->getSurname(), "email" => $gagnant->getEmail(), "id" => $gagnant->getId() ],200);
        }
        $tickets = $concours->getTickets();

        $users = []; // Tableau pour stocker les utilisateurs distincts
        
        foreach ($tickets as $ticket) {
            $user = $ticket->getUtilisateur();
            if ($user && !in_array($user, $users)) {
                $users[] = $user;
            }
        }

        $randomUser = null;
        if (!empty($users)) {
            $randomIndex = array_rand($users);
            $randomUser = $users[$randomIndex];
        }

        if($randomUser) {
            $concours->setGagnant($randomUser);
            $this->entityManager->persist($concours);
            $this->entityManager->flush();
        }
        $gagnant = $concours->getGagnant();
        
        return $this->json(["gagnant" => $gagnant->getName()." ".$gagnant->getSurname(), "email" => $gagnant->getEmail(), "id" => $gagnant->getId() ],200);
        
    }
    
}
