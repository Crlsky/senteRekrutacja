<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Entity\Lang;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/lang", name="lang")
     */
    public function curr(){
        $entityManager = $this->getDoctrine()->getManager();
        $lang = new Lang();
        $lang->setName('Polski');
        $lang->setIsoCode('pl');

        $entityManager->persist($lang);
        $entityManager->flush();

        return $this->render('main/index.html.twig', [
            'controller_name' => $lang->getName(),
        ]);
    }
}
