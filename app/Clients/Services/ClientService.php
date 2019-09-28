<?php

namespace App\Clients\Services;

use App\Clients\Repositories\ClientRepository;

final class ClientService
{
    private $clientRepository;

    /**
     * ClientService constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    public function create(string $token): void
    {
        $client = $this->clientRepository->getByToken($token);
        $existClient = $this->clientRepository->getByExternalId($client->external_id);
    }
}
