<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Form\AlbumType;
use App\Form\ArtistType;
use App\Form\SongType;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Repository\SongRepository;
use Doctrine\ORM\ORMException;
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
    public function songAdd(Request $request, SongRepository $songRepository, LoggerInterface $logger): Response
    {
        $song = new Song();

        $form = $this->createForm(SongType::class, $song);

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
                $songRepository->add($song);
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
     * @Route("/song/{id}/delete/{action?none}", name="song_delete", requirements={"id"="\d+"})
     */
    public function songDelete(int $id, string $action, SongRepository $songRepository)
    {
        $song = $songRepository->find($id);

        if ($action == 'confirm')
        {
            try {
                $songRepository->delete($song);
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
                $coverFile->move($this->getParameter('covers_directory'), $newFilename);
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
     * @Route("/album/{id}/delete/{action?none}", name="album_delete", requirements={"id"="\d+"})
     */
    public function albumDelete(int $id, string $action, AlbumRepository $albumRepository)
    {
        $album = $albumRepository->find($id);

        if ($action == 'confirm')
        {
            try {
                $albumRepository->delete($album);
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

    /**
     * @Route("/artist/{id}/delete/{action?none}", name="artist_delete", requirements={"id"="\d+"})
     */
    public function artistDelete(int $id, string $action, ArtistRepository $artistRepository)
    {
        $artist = $artistRepository->find($id);

        if ($action == 'confirm')
        {
            try {
                $artistRepository->delete($artist);
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
}
