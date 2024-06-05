<?php

namespace App\Controller;

use App\Service\VideoGameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VideoGameController extends AbstractController
{
    public function __construct(
        private VideoGameService $videoGameService
    ) {}

    #[Route('/videogame', name: 'videogame_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $videogames = $this->videoGameService->getAll();

        return $this->json($videogames);
    }

    #[Route('/videogame/{id}', name: 'videogame_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $videogames = $this->videoGameService->getOneById($id);

        return $this->json($videogames);
    }

    #[Route('/videogame', name: 'videogame_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $videoGame = $this->videoGameService->createByRequest($request);

        return $this->json($videoGame);
    }

    #[Route('/videogame/{id}', name: 'videogame_update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $videoGame = $this->videoGameService->updateOneByRequest($id, $request);

        return $this->json($videoGame);
    }

    #[Route('/videogame/{id}', name: 'videogame_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->videoGameService->deleteOneById($id);

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
