<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Form\AlbumType;
use App\Form\ArtistType;
use App\Form\SongType;
use App\Service\AlbumService;
use App\Service\ArtistService;
use App\Service\FileUploader;
use App\Service\SongService;
use Doctrine\ORM\ORMException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/song/add", name="admin_panel_song_add", methods={"GET","POST"})
     */
    public function songAdd(Request $request, SongService $songService, LoggerInterface $logger, FileUploader $fileUploader): Response
    {
        $song = new Song();

        $form = $this->createForm(SongType::class, $song);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $song = $form->getData();

            $songFile = $form->get('url')->getData();

            if ($songFile) {
                $songFilename = $fileUploader->uploadSong($songFile);
                $song->setUrl($songFilename);
            }

            try {
                $songService->saveSong($song);

                $this->redirectToRoute('admin_panel');
            } catch(Exception $exception) {
                $logger->error('Cannot add song', [
                    'exception' => $exception->getMessage(),
                ]);
            }
        }

        return $this->render('admin_panel/song/add.html.twig', [
            'song_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/song/{id}/delete/{action?none}", name="admin_panel_song_delete", requirements={"id"="\d+"})
     */
    public function songDelete(Song $song, string $action, SongService $songService)
    {
        if ('confirm' === $action)
        {
            try {
                $songService->deleteSong($song);
                $this->addFlash('success', 'message_deleted_successfully');
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }

            return $this->redirectToRoute('songs');
        }

        return $this->render('song/delete.html.twig', [
            'song' => $song,
        ]);
    }

    /**
     * @Route(
     *     "/song/{id}/edit",
     *     name="admin_panel_song_edit",
     *     requirements={"id": "\d+"},
     *     methods={"GET","PUT"}
     * )
     */
    public function songEdit(Request $request, Song $song, SongService $songService, LoggerInterface $logger): Response
    {
        $form = $this->createForm(SongType::class, $song, ['method' => 'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $song = $form->getData();
            $songFile = $form->get('url')->getData();

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $song->getTitle());
            $newFilename = $safeFilename.'-'.uniqid().'.'.$songFile->guessExtension();

            try {
                $songFile->move($this->getParameter('audio_file_directory'), $newFilename);
            } catch (FileException $exception) {
                $logger->error('Cannot move file', [
                    'exception' => $exception->getMessage(),
                ]);
            }

            $song->setUrl($newFilename);

            try {
                $songService->saveSong($song);

                return $this->redirectToRoute('songs');
            } catch(Exception $exception) {
                $logger->error('Cannot add song', [
                    'exception' => $exception->getMessage(),
                ]);
            }
        }

        return $this->render('admin_panel/song/add.html.twig', [
            'song_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/album/add", name="admin_panel_album_add", methods={"GET","POST"})
     */
    public function albumAdd(Request $request, AlbumService $albumService, LoggerInterface $logger, FileUploader $fileUploader): Response
    {
        $album = new Album();

        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();

            $coverFile = $form->get('logo')->getData();

            if ($coverFile) {
                $coverFilename = $fileUploader->uploadAlbum($coverFile);
                $album->setUrl($coverFilename);
            }

            try {
                $albumService->saveAlbum($album);

                $this->redirectToRoute('admin_panel');
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
     * @Route("/album/{id}/delete/{action?none}", name="admin_panel_album_delete", requirements={"id"="\d+"})
     */
    public function albumDelete(Album $album, string $action, AlbumService $albumService)
    {
        if ('confirm' === $action)
        {
            try {
                $albumService->deleteAlbum($album);
                $this->addFlash('success', 'message_deleted_successfully');
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getMessage());
            }

            return $this->redirectToRoute('albums');
        }

        return $this->render('album/delete.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route(
     *     "/album/{id}/edit",
     *     name="admin_panel_album_edit",
     *     requirements={"id": "\d+"},
     *     methods={"GET","PUT"}
     * )
     */
    public function albumEdit(Request $request, Album $album, AlbumService $albumService, LoggerInterface $logger): Response
    {
        $form = $this->createForm(AlbumType::class, $album, ['method'=>'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();
            $coverFile = $form->get('logo')->getData();

            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $album->getName());
            $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();

            try {
                $coverFile->move($this->getParameter('covers_directory'), $newFilename);
            } catch (FileException $exception) {
                $logger->error('Cannot move file', [
                    'exception' => $exception->getMessage(),
                ]);
            }

            $album->setLogoUrl($newFilename);

            try {
                $albumService->saveAlbum($album);

                return $this->redirectToRoute('albums');
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
     * @Route("/artist/add", name="admin_panel_artist_add", methods={"GET","POST"})
     */
    public function artistAdd(Request $request, ArtistService $artistService, LoggerInterface $logger): Response
    {
        $artist = new Artist();

        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            try {
                $artistService->saveArtist($artist);

                $this->redirectToRoute('admin_panel');
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

    /**
     * @Route("/artist/{id}/delete/{action?none}", name="admin_panel_artist_delete", requirements={"id"="\d+"})
     */
    public function artistDelete(Artist $artist, string $action, ArtistService $artistService)
    {
        if ('confirm' === $action)
        {
            try {
                $artistService->deleteArtist($artist);
                $this->addFlash('success', 'message_deleted_successfully');
            } catch (Exception $exception) {
                $this->addFlash('error', $exception->getCode());
            }

            return $this->redirectToRoute('artists');
        }

        return $this->render('artist/delete.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route(
     *     "/artist/{id}/edit",
     *     name="admin_panel_artist_edit",
     *     requirements={"id": "\d+"},
     *     methods={"GET","PUT"}
     * )
     */
    public function artistEdit(Request $request, Artist $artist, ArtistService $artistService, LoggerInterface $logger): Response
    {
        $form = $this->createForm(ArtistType::class, $artist, ['method' => 'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            try {
                $artistService->saveArtist($artist);

                return $this->redirectToRoute('artists');
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
