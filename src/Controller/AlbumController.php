<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Controller;

use App\Entity\Album;
use App\Entity\AlbumComment;
use App\Form\AlbumCommentType;
use App\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  Album Controller
 */
class AlbumController extends AbstractController
{
    private AlbumService $albumService;

    /**
     * @param AlbumService $albumService
     */
    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    /**
     * @Route(
     *     "/albums",
     *     name="albums"
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
        $pagination = $this->albumService->createPaginatedList($page, $filters);

        return $this->render('album/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route(
     *     "/album/{id}",
     *     name="album",
     *     methods={"GET","POST"},
     *     requirements={"id": "\d+"}
     * )
     *
     * @param Request $request
     * @param Album   $album
     *
     * @return Response
     */
    public function album(Request $request, Album $album): Response
    {
        $albumComment = new AlbumComment();

        $commentForm = $this->createForm(AlbumCommentType::class, $albumComment, ['method' => 'POST']);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->albumService->addComment($album, $albumComment, $this->getUser());

            return $this->redirectToRoute('album', ['id' => $album->getId()]);
        }

        return $this->render('album/album.html.twig', [
            'album' => $album,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
