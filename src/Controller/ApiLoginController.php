<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\UserRepository;



class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(#[CurrentUser] $user = null)
    {
        return $this->json([
            'user' => $user ? $user->getId() : null,
            'roles' => $user ? $user->getRoles() : null
        ]);
    }


    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Login user empty',
            'path' => 'src/Controller/ApiLoginController.php',
        ]);
    }
}
