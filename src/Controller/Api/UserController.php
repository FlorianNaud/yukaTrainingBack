<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'app_api', methods: 'GET')]
class UserController extends AbstractController
{
    #[Route('/user', name: '_user')]
    public function index(): JsonResponse
    {
        // On récupére l'utilisateur courant
        $user = $this->getUser();
        // Si aucun utilisateur n'est connecté
        if ($user === null) {
            // On renvoie un code reponse 404
            return $this->json("Aucun utilisateur n'est connecté !",Response::HTTP_NOT_FOUND);
        }
        // Sinon on renvoie l'utilisateur avec un code reponse 200
        return $this->json($user,Response::HTTP_OK,[],["groups"=>["readUser"]]);
    }
}
