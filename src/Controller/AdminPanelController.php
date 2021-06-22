<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Form\AlbumType;
use App\Form\ArtistType;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin_panel")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/", name="admin_panel")
     */
    public function index(): Response
    {
        return $this->render('admin_panel/index.html.twig');
    }

    /**
     * @Route("/song/add", name="admin_panel_song_add")
     */
    public function songAdd(): Response
    {
        return $this->render('admin_panel/index.html.twig');
    }

    /**
     * @Route("/album/add", name="admin_panel_album_add")
     */
    public function albumAdd(Request $request, AlbumRepository $albumRepository, LoggerInterface $logger): Response
    {
        $album = new Album();

        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();
            $coverFile = $form->get('logo')->getData();

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $album->getName());
            $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();

            try {
                $coverFile->move(
                    $this->getParameter('covers_directory'),
                    $newFilename
                );
            } catch (FileException $exception) {
                $logger->error('Cannot move file', [
                    'exception' => $exception->getMessage(),
                ]);
            }

            $album->setLogoUrl($newFilename);

            try {
                $albumRepository->add($album);
            } catch (Exception $exception) {
                $logger->error('Cannot add artist', [
                    'exception' => $exception->getMessage(),
                ]);
            }
        }

        return $this->render('admin_panel/album/add.html.twig', [
            'album_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artist/add", name="admin_panel_artist_add")
     */
    public function artistAdd(Request $request, ArtistRepository $artistRepository, LoggerInterface $logger): Response
    {
        $artist = new Artist();

        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            try {
                $artistRepository->add($artist);
            } catch (Exception $exception) {
                $logger->error('Cannot add artist', [
                    'exception' => $exception->getMessage(),
                    ]
                );
            }
        }

        return $this->render('admin_panel/artist/add.html.twig', [
            'add_artist_form' => $form->createView(),
        ]);
    }
}
