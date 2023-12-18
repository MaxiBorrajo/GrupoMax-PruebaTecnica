<?php
namespace App\Http\Services;

use App\Exceptions\EmailAlreadyTakenException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function getUsers(Request $request)
    {
        $users = User::query();

        $this->applyKeywordFilter($request, $users);
        $this->applySorting($request, $users);

        $users = $users->paginate(20)->appends($request->query());

        return $users;
    }

    private function applyKeywordFilter(Request $request, $query)
    {
        $keyword = $request->query('keyword');

        if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('first_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%");
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

    public function createUser(CreateUserRequest $request)
    {
        return User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $this->attemptLogin($request);

        $user = $this->getUserByEmail($request->email);

        return $user;
    }

    private function attemptLogin(LoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            throw new InvalidCredentialsException();
        }
    }

    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->firstOrFail();

    }

    public function getUserById($id)
    {
        return User::findOrFail($id);

    }

    private function validateUniqueEmail(Request $request, string $email)
    {
        if ($request->email && $request->email != $email && $this->getUserByEmail($request->email)) {
            throw new EmailAlreadyTakenException();
        }
    }

    public function updateUser(UpdateUserRequest $request, $user_id)
    {
        $user = $this->getUserById($user_id);
        $this->validateUniqueEmail($request, $user->email);
        $user->update($request->all());
        return $user;
    }

    public function deleteUser($user_id)
    {
        $user = User::find($user_id);
        $user->delete();
    }
}