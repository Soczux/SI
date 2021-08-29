<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\AlbumComment;
use App\Form\AlbumCommentType;
use App\Repository\AlbumRepository;
use App\Service\AlbumService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AlbumController extends AbstractController
{
    private AlbumService $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    /**
     * @Route(
     *     "/albums",
     *     name="albums"
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->albumService->createPaginatedList($page);

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
     */
    public function album(Request $request, Album $album, UserInterface $user = null): Response
    {
        $albumComment = new AlbumComment();

        $commentForm = $this->createForm(AlbumCommentType::class, $albumComment, ['method'=>'POST']);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->albumService->addComment($album, $albumComment, $user);

            return $this->redirectToRoute('album', ['id' => $album->getId()]);
        }

        return $this->render('album/album.html.twig', [
            'album' => $album,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
