<?php

namespace App\Controller;

use App\Entity\Song;
use App\Entity\SongComment;
use App\Form\SongCommentType;
use App\Repository\SongRepository;
use App\Service\SongService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class SongController extends AbstractController
{
    private SongService $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * @Route(
     *     "/songs",
     *     name="songs"
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->songService->createPaginatedList($page);

        return $this->render('song/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route(
     *     "/song/{id}",
     *     name="song",
     *     methods={"GET", "POST"},
     *     requirements={"id": "\d+"}
     * )
     */
    public function song(Request $request, Song $song, UserInterface $user = null): Response
    {
        $songComment = new SongComment();

        $commentForm = $this->createForm(SongCommentType::class, $songComment, ['method'=>'POST']);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->songService->addComment($song, $songComment, $user);

            return $this->redirectToRoute('song', ['id' => $song->getId()]);
        }

        return $this->render('song/song.html.twig', [
            'song' => $song,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
