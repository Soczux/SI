<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/user/{id}", name="user", requirements={"id": "\d+"})
     */
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $user
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
     * @param User $user
     *
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $this->getUser(), ['method' => 'PUT']);
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

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
}
