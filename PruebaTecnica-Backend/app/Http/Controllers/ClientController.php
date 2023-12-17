<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Http\Services\ClientService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(Request $request): JsonResponse
    {

            $clients = $this->clientService->getClients($request);

            return response()->json(['resource' => $clients], 200);

    }
    public function store(CreateClientRequest $request): JsonResponse
    {
        $client = $this->clientService->createClient($request);
        return response()->json(['message' => 'Client created successfully',
            'resource' => new ClientResource($client)], 201);
    }

    public function show(Request $request, string $id): JsonResponse
    {
            $client = $this->clientService->getClientById($id, $request->user()->id);
            return response()->json(['resource' => new ClientResource(
                $client
            )], 200);
    }
    public function update(UpdateClientRequest $request, string $id): JsonResponse
    {
            $client = $this->clientService->updateClient($request, $id);

            return response()->json(['message' => 'Client updated succesfully',
                'resource' => $client], 200);

    }
    public function destroy(Request $request, string $id): JsonResponse
    {
            $this->clientService->deleteClient($id, $request->user()->id);
            return response()->json(['message' => 'Client deleted succesfully'], 200);

    }
}
