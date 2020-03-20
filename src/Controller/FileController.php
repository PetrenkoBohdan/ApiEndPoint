<?php

declare(strict_types=1);

namespace App\Controller;

use App\Sevices\FileManager\FileManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    /**
     * @Route("/file", name="get_files", methods={"GET"})
     * @param Request $request
     * @param FileManager $manager
     *
     * @return Response
     */
    public function index(Request $request, FileManager $manager)
    {
        return new Response($manager->manage($request->query->all()));
    }
}