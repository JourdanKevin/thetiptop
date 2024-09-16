<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Prize;
use App\Repository\PrizeRepository;

class PrizeController extends AbstractController
{
    private function totalProbability($prizes){
        $totalProbability = 0;
        foreach ($prizes as $prize) {
            $totalProbability += $prize->getProbability();
        }
        return $totalProbability;
    }
    public function get_rand_prize($prizes){
        // $prizes = $prizeRepository->findAll();
        $randomNumber = mt_rand(1, $this->totalProbability($prizes));
        $accumulator = 0;
        foreach ($prizes as $prize) {
            $accumulator += $prize->getProbability();
            if ($randomNumber <= $accumulator) {
                $prizes = $prize;
                return $prize;
                // return ["name" => $lot->getNom(), "value" => $lot->getValeur()];
            }
        }
    }

    #[Route('api/random/prize', name: 'rand_prize', methods: ['GET'])]
    public function rand_lot(PrizeRepository $prizeRepository)
    {
        $prizes = $prizeRepository->findAll();
        return $this->json($this->get_rand_prize($prizes));
    }

}
