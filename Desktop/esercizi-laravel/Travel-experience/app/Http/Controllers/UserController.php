<?php

namespace App\Http\Controllers;


use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;


class UserController extends Controller
{


    public function index()
    {
        return UserResource::collection(User::paginate(10)); // Pagina con 10 utenti per pagina
    }


    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => new UserResource($user->fresh())
        ]);
    }


    public function show(User $user) {
        return new UserResource($user);
    }

    

    public function destroy(User $user) {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
            'data' => [],
        ]);
    }
}
