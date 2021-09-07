<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Entity\User;
use App\Form\AlbumType;
use App\Form\ArtistType;
use App\Form\SongType;
use App\Form\UserType;
use App\Service\AlbumService;
use App\Service\ArtistService;
use App\Service\FileUploader;
use App\Service\SongService;
use App\Service\UserService;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Admin Panel Controller
 * 
 * @Route("/admin_panel")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPanelController extends AbstractController
{
    private AlbumService $albumService;
    private ArtistService $artistService;
    private FileUploader $fileUploader;
    private SongService $songService;
    private UserService $userService;

    /**
     * @param AlbumService  $albumService
     * @param ArtistService $artistService
     * @param FileUploader  $fileUploader
     * @param SongService   $songService
     * @param UserService   $userService
     */
    public function __construct(AlbumService $albumService, ArtistService $artistService, FileUploader $fileUploader, SongService $songService, UserService $userService)
    {
        $this->albumService = $albumService;
        $this->artistService = $artistService;
        $this->fileUploader = $fileUploader;
        $this->songService = $songService;
        $this->userService = $userService;
    }

    /**
     * @Route(
     *     "/",
     *     name="admin_panel"
     * )
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin_panel/index.html.twig');
    }

    /**
     * @Route(
     *     "/song/add",
     *     name="admin_panel_song_add",
     *     methods={"GET","POST"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function songAdd(Request $request): Response
    {
        $song = new Song();

        $form = $this->createForm(SongType::class, $song);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $song = $form->getData();

            $songFile = $form->get('url')->getData();

            if ($songFile) {
                $songFilename = $this->fileUploader->uploadSong($songFile);
                $song->setUrl($songFilename);
            }

            try {
                $this->songService->saveSong($song);

                $this->addFlash('success', 'message_success');

                $this->redirectToRoute('admin_panel');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/song/add.html.twig', [
            'song_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/song/{id}/delete/{action?none}",
     *     name="admin_panel_song_delete",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param Song   $song
     * @param string $action
     *
     * @return Response
     */
    public function songDelete(Song $song, string $action): Response
    {
        if ('confirm' === $action) {
            try {
                $this->songService->deleteSong($song);

                $this->addFlash('success', 'message_success');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }

            return $this->redirectToRoute('songs');
        }

        return $this->render('admin_panel/song/delete.html.twig', [
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
     *
     * @param Request $request
     * @param Song    $song
     *
     * @return Response
     */
    public function songEdit(Request $request, Song $song): Response
    {
        $form = $this->createForm(SongType::class, $song, ['method' => 'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $song = $form->getData();

            $songFile = $form->get('url')->getData();

            if ($songFile) {
                $songFilename = $this->fileUploader->uploadSong($songFile);
                $song->setUrl($songFilename);
            }

            try {
                $this->songService->saveSong($song);

                $this->addFlash('success', 'message_success');

                return $this->redirectToRoute('songs');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/song/add.html.twig', [
            'song_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/album/add",
     *     name="admin_panel_album_add",
     *     methods={"GET","POST"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function albumAdd(Request $request): Response
    {
        $album = new Album();

        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();

            $coverFile = $form->get('logo')->getData();

            if ($coverFile) {
                $coverFilename = $this->fileUploader->uploadAlbum($coverFile);
                $album->setLogoUrl($coverFilename);
            }

            try {
                $this->albumService->saveAlbum($album);

                $this->addFlash('success', 'message_success');

                $this->redirectToRoute('admin_panel');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/album/add.html.twig', [
            'album_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/album/{id}/delete/{action?none}",
     *     name="admin_panel_album_delete",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param Album  $album
     * @param string $action
     *
     * @return Response
     */
    public function albumDelete(Album $album, string $action): Response
    {
        if ('confirm' === $action) {
            try {
                $this->albumService->deleteAlbum($album);

                $this->addFlash('success', 'message_success');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }

            return $this->redirectToRoute('albums');
        }

        return $this->render('admin_panel/album/delete.html.twig', [
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
     *
     * @param Request $request
     * @param Album   $album
     *
     * @return Response
     */
    public function albumEdit(Request $request, Album $album): Response
    {
        $form = $this->createForm(AlbumType::class, $album, ['method' => 'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();

            $coverFile = $form->get('logo')->getData();

            if ($coverFile) {
                $coverFilename = $this->fileUploader->uploadAlbum($coverFile);
                $album->setLogoUrl($coverFilename);
            }

            try {
                $this->albumService->saveAlbum($album);

                $this->addFlash('success', 'message_success');

                return $this->redirectToRoute('albums');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/album/add.html.twig', [
            'album_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/artist/add",
     *     name="admin_panel_artist_add",
     *     methods={"GET","POST"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function artistAdd(Request $request): Response
    {
        $artist = new Artist();

        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            try {
                $this->artistService->saveArtist($artist);

                $this->addFlash('success', 'message_success');

                $this->redirectToRoute('admin_panel');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/artist/add.html.twig', [
            'add_artist_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/artist/{id}/delete/{action?none}",
     *     name="admin_panel_artist_delete",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param Artist $artist
     * @param string $action
     *
     * @return Response
     */
    public function artistDelete(Artist $artist, string $action): Response
    {
        if ('confirm' === $action) {
            try {
                $this->artistService->deleteArtist($artist);

                $this->addFlash('success', 'message_success');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }

            return $this->redirectToRoute('artists');
        }

        return $this->render('admin_panel/artist/delete.html.twig', [
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
     *
     * @param Request $request
     * @param Artist  $artist
     *
     * @return Response
     */
    public function artistEdit(Request $request, Artist $artist): Response
    {
        $form = $this->createForm(ArtistType::class, $artist, ['method' => 'PUT']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $artist = $form->getData();

            try {
                $this->artistService->saveArtist($artist);

                $this->addFlash('success', 'message_success');

                return $this->redirectToRoute('artists');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/artist/add.html.twig', [
            'add_artist_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *      "/users",
     *     name="admin_panel_user_list",
     *     requirements={"id": "\d+"},
     *     methods={"GET", "PUT"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userList(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->userService->createPaginatedList($page);

        return $this->render('admin_panel/user/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route(
     *      "/user/{id}/edit",
     *     name="admin_panel_user_edit",
     *     requirements={"id": "\d+"},
     *     methods={"GET", "PUT"}
     * )
     *
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     */
    public function userEdit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            try {
                $this->userService->saveUser($user);

                $this->addFlash('success', 'message_success');

                return $this->redirectToRoute('admin_panel_user_list');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('admin_panel/user/edit.html.twig', [
            'user' => $this->getUser(),
            'user_add_form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/user/{id}/delete/{action?none}",
     *     name="admin_panel_user_delete",
     *     requirements={"id"="\d+"}
     * )
     *
     * @param User   $user
     * @param string $action
     *
     * @return Response
     */
    public function userDelete(User $user, string $action): Response
    {
        if ('confirm' === $action) {
            try {
                $this->userService->deleteUser($user);

                $this->addFlash('success', 'message_success');
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }

            return $this->redirectToRoute('admin_panel_user_list');
        }

        return $this->render('admin_panel/user/delete.html.twig', [
            'user' => $user,
        ]);
    }
}
