<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function nameAction(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository('App\Entity\User')->findAll();
        return $this->render('user/user.html.twig', [
            'users' => $users,
        ]);
    }
}
