<?php
namespace App\Http\Services;

use App\Exceptions\InvalidOwnerException;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientService
{

    public function getClients(Request $request)
    {
        $clients = Client::query();
        $user_id = $request->user()->id;
        $clients->where(function ($clients) use ($user_id) {
            $clients->where('user_id', $user_id);
        });

        $this->applyKeywordFilter($request, $clients);
        $this->applySorting($request, $clients);

        $clients = $clients->paginate(20)->appends($request->query());

        return $clients;
    }

    private function applyKeywordFilter(Request $request, $query)
    {
        $keyword = $request->query('keyword');
        $status = $request->query('status');

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere("phone_number", "LIKE", "%{$keyword}%");
            });
        }

        if ($status) {
            $query->where(function ($query) use ($status) {
                $query->where('status', $status);
            });
        }
    }


    private function applySorting(Request $request, $query)
    {
        $sort = $request->query('sort');
        $order = $request->query('order');

        if ($sort && $order) {
            $query->orderBy($sort, $order);
        }
    }

    public function createClient(CreateClientRequest $request)
    {
        $client = new Client($request->except('id', 'user_id'));
        $client->user_id = $request->user()->id;
        $client->save();
        return $client;
    }

    public function getClientById($id, $user_id)
    {
            $client = Client::findOrFail($id);

            $this->validateOwner($client->user_id, $user_id);

            return $client;

    }

    private function validateOwner($owner_id, $user_id)
    {
        if ($owner_id != $user_id) {
            throw new InvalidOwnerException();
        }
    }

    public function updateClient(UpdateClientRequest $request, $client_id)
    {
        $client = $this->getClientById($client_id, $request->user()->id);
        $client->update($request->except('id', 'user_id'));
        return $client;
    }

    public function deleteClient($client_id, $user_id)
    {
        $client = $this->getClientById($client_id, $user_id);
        $client->delete();
    }
}