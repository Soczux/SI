<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\ArtistComment;
use App\Form\ArtistCommentType;
use App\Service\ArtistService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    private ArtistService $artistService;

    public function __construct(ArtistService $artistService)
    {
        $this->artistService = $artistService;
    }

    /**
     * @Route(
     *     "/artists",
     *     name="artists"
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        $page = $request->query->getInt('page', 1);
        $pagination = $this->artistService->createPaginatedList($page, $filters);

        return $this->render('artist/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route(
     *     "/artist/{id}",
     *     name="artist",
     *     methods={"GET","POST"},
     *     requirements={"id": "\d+"}
     * )
     */
    public function artist(Request $request, Artist $artist)
    {
        $artistComment = new ArtistComment();

        $commentForm = $this->createForm(ArtistCommentType::class, $artistComment, ['method'=>"POST"]);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $this->artistService->addComment($artist, $artistComment, $this->getUser());

            return $this->redirectToRoute('artist', ['id'=>$artist->getId()]);
        }

        return $this->render('artist/artist.html.twig', [
            'artist' => $artist,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
