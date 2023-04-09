<?php

namespace App\Controller;

use App\Entity\Library;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    /**
     * @Route("/libraries", name="library_index", methods={"GET"})
     */
    public function index()
    {
        $user_id = $this->getUser()->getId();
        $libraries = $this->getDoctrine()->getRepository(Library::class)->findBy(['user' => $user_id]);

        return new JsonResponse($libraries);
    }

    /**
     * @Route("/libraries", name="library_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $library = new Library();
        $library->setName($request->get('name'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($library);
        $entityManager->flush();

        return new JsonResponse($library);
    }

    /**
     * @Route("/libraries/{id}", name="library_show", methods={"GET"})
     */
    public function show(Library $library)
    {
        return new JsonResponse($library);
    }

    /**
     * @Route("/libraries/{id}", name="library_update", methods={"PUT"})
     */
    public function update(Request $request, Library $library)
    {
        $library->setName($request->get('name'));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse($library);
    }

    /**
     * @Route("/libraries/{id}", name="library_delete", methods={"DELETE"})
     */
    public function delete(Library $library)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($library);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Library deleted successfully']);
    }
}
