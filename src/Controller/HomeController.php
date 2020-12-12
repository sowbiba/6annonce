<?php

namespace App\Controller;

use App\Search\Finder\UserFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home",  methods={"GET"})
     *
     * @param Request $request
     * @param UserFinder $userFinder
     *
     * @return Response
     */
    public function index(Request $request, UserFinder $userFinder)
    {
        var_dump($userFinder->find(['username' => 'toto']));

        return $this->render('home.html.twig');
    }
}
