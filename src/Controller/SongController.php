<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Controller;

use App\Entity\Song;
use App\Entity\SongComment;
use App\Form\SongCommentType;
use App\Service\SongService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  Song Controller
 */
class SongController extends AbstractController
{
    private SongService $songService;

    /**
     * @param SongService $songService
     */
    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * @Route(
     *     "/songs",
     *     name="songs"
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['artist_id'] = $request->query->getInt('filters_artist_id');

        $page = $request->query->getInt('page', 1);
        $pagination = $this->songService->createPaginatedList($page, $filters);

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
     *
     * @param Request $request
     * @param Song    $song
     *
     * @return Response
     */
    public function song(Request $request, Song $song): Response
    {
        $songComment = new SongComment();

        $commentForm = $this->createForm(SongCommentType::class, $songComment, ['method' => 'POST']);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->songService->addComment($song, $songComment, $this->getUser());

            return $this->redirectToRoute('song', ['id' => $song->getId()]);
        }

        return $this->render('song/song.html.twig', [
            'song' => $song,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
