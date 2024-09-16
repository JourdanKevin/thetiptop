<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/{slug?}', name: 'app', requirements: ['slug' => '^((?!api).)*$'])]
    public function app(): Response
    {
      return $this->render('app.html.twig');
    }
}