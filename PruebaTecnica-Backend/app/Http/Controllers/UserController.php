<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(Request $request): JsonResponse
    {

        $users = $this->userService->getUsers($request);

        return response()->json(['resource' => $users], 200);

    }

    public function store(CreateUserRequest $request): JsonResponse
    {

        $user = $this->userService->createUser($request);

        return response()->json([
            'message' => 'User created successfully',
            'resource' => new UserResource($user),
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 201);

    }

    public function login(LoginRequest $request): JsonResponse
    {

        $user = $this->userService->login($request);

        return response()->json([
            'message' => 'User logged successfully',
            'resource' => new UserResource($user),
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);

    }

    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);

    }

    public function show(Request $request): JsonResponse
    {

        $user_id = $request->user()->id;
        return response()->json(['resource' => new UserResource(User::find($user_id))], 200);

    }
    public function update(UpdateUserRequest $request): JsonResponse
    {

        $user_id = $request->user()->id;

        $user = $this->userService->updateUser($request, $user_id);

        return response()->json(['message' => 'User updated succesfully',
            'resource' => new UserResource($user)], 200);

    }
    public function destroy(Request $request): JsonResponse
    {
        $this->userService->deleteUser($request->user()->id);

        return response()->json(['message' => 'User deleted succesfully'], 200);

    }


}
