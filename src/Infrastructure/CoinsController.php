<?php
declare(strict_types = 1);

namespace App\Infrastructure;


use App\Domain\Coin;
use App\Domain\CoinNotFoundException;
use App\Domain\CoinRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

class CoinsController
{
    public function __construct(
        private CoinRepository $coinRepository,
        private CoinPayloadValidator $coinPayloadValidator
    ) {}

    #[Route('/coins/{id}', methods: ['GET'])]
    public function single(string $id): Response
    {
        try {
            $coin = $this->coinRepository->getById($id);
        } catch (CoinNotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($coin->toArray(), Response::HTTP_OK);
    }

    #[Route('/coins', methods: ['GET'])]
    public function list(): Response
    {
        $coins = $this->coinRepository->getAll();
        $serializedCoins = [];
        foreach ($coins as $coin) {
            $serializedCoins[] = $coin->toArray();
        }

        return new JsonResponse($serializedCoins, Response::HTTP_OK);
    }

    #[Route('/coins', methods: ['POST'])]
    public function save(Request $request): Response
    {
        $payload = $request->toArray();
        if (! $this->coinPayloadValidator->validate($payload)) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }
        $payload['id'] = Uuid::uuid4()->toString();

        $coin = Coin::fromArray($payload);
        $this->coinRepository->save($coin);

        return new Response($coin->getId(), Response::HTTP_CREATED);
    }

    #[Route('/coins/{id}', methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        try {
            $this->coinRepository->delete($id);
        } catch (CoinNotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response("Coin deleted", Response::HTTP_OK);
    }
}