<?php
/**
 * This file is a part o Marta Soczyńska's SI project
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  Main Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="main"
     * )
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirectToRoute('songs');
    }
}
