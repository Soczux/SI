<?php

namespace App\Controller;

use App\Repository\SongRepository;
use App\Service\SongService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongController extends AbstractController
{
    private SongService $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * @Route("/songs", name="songs")
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->songService->createPaginatedList($page);

        return $this->render('song/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
