<?php

namespace App\Service;

use App\Entity\VideoGame;
use App\Repository\VideoGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class VideoGameService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private VideoGameRepository $videoGameRepository
    ) {}

    public function getAll(): array
    {
        $videoGames = $this->videoGameRepository->findAll();

        return $videoGames;
    }

    public function getOneById(int $id): ?VideoGame
    {
        $videoGame = $this->videoGameRepository->findOneById($id);

        return $videoGame;
    }

    private function create(string $name): VideoGame
    {
        $videoGame = new VideoGame($name);
        $this->entityManager->persist($videoGame);
        $this->entityManager->flush();

        return $videoGame;
    }

    public function createByRequest(Request $request): VideoGame
    {
        $requestData = $this->getAttributesFromRequest($request);
        $videoGame = $this->create($requestData['name']);

        return $videoGame;
    }

    private function update(VideoGame $videoGame, array $newAttributes): VideoGame
    {
        $videoGame->setName($newAttributes['name']);
        $this->entityManager->persist($videoGame);
        $this->entityManager->flush();

        return $videoGame;
    }

    public function updateOneByRequest(int $id, Request $request): VideoGame
    {
        $videoGameToUpdate = $this->getOneById($id);
        $requestData = $this->getAttributesFromRequest($request);
        $updatedVideoGame = $this->update($videoGameToUpdate, $requestData);

        return $updatedVideoGame;
    }

    public function deleteOneById(int $id): void
    {
        $videoGame = $this->videoGameRepository->findOneById($id);
        $this->entityManager->remove($videoGame);
        $this->entityManager->flush();
    }

    private function getAttributesFromRequest(Request $request): array
    {
        $requestData = $request->toArray();

        return $requestData;
    }
}
