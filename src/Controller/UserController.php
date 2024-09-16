<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use App\Entity\Ticket;
use App\Entity\User;
use App\Entity\Lot;
use App\Entity\Concours;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('api/user/{email}', name: 'user_email', methods: ['GET'])]
    public function getUserByMail($email, UserRepository $userRepository, Security $security, Request $request) : Response
    {
       $user = $userRepository->findOneBy(array('email' => $email));
       return $this->json($user);
    }

    #[Route('api/account', name: 'account', methods: ['GET', 'PUT', 'PATCH'])]
    public function updateAccount(UserRepository $userRepository, Security $security, Request $request) : Response
    {
        $user = $security->getUser();
        if($request->getMethod() == "GET") {
            return $this->json($user);
        }
        
        $payload = json_decode($request->getContent(), true);

        if(array_key_exists("name", $payload))
            $user->setName($payload["name"]);
        if(array_key_exists("surname", $payload))
            $user->setSurname($payload["surname"]);
        if(array_key_exists("birthDate", $payload))
            $user->setBirthDate(new \DateTime($payload["birthDate"]));
        if(array_key_exists("address", $payload))
            $user->setAddress($payload["address"]);
        if(array_key_exists("address2", $payload))
            $user->setAddress2($payload["address2"]);
        if(array_key_exists("postalCode", $payload))
            $user->setPostalCode($payload["postalCode"]);
        if(array_key_exists("city", $payload))
            $user->setCity($payload["city"]);
        if(array_key_exists("country", $payload))
            $user->setCountry($payload["country"]);
        if(array_key_exists("password", $payload))
            $user->setPassword($payload["password"]);
        if(array_key_exists("email", $payload))
            $user->setEmail($payload["email"]);

        $userRepository->save($user, true);

        return $this->json($user);
    }
}
