<?php

namespace App\Controller;

use App\Repository\SongRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    /**
     * @Route("/songs", name="songs")
     */
    public function index(Request $request, SongRepository $songRepository): Response
    {
        return $this->render('song/index.html.twig', [
            'songs' => $songRepository->findAll(),
        ]);
    }
}
