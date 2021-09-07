<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  User Controller
 */
class UserController extends AbstractController
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route(
     *     "/user/{id}",
     *     name="user",
     *     requirements={"id": "\d+"}
     * )
     *
     * @param User $user
     *
     * @return Response
     */
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route(
     *     "/user/edit",
     *      name="user_edit",
     *      methods={"GET","PUT"}
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser(), ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            try {
                $this->userService->saveUser($user);

                $this->addFlash('success', 'message_success');

                return $this->redirectToRoute('user', ['id' => $user->getId()]);
            } catch (Exception $exception) {
                $this->addFlash('error', 'message_error');
            }
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }
}
