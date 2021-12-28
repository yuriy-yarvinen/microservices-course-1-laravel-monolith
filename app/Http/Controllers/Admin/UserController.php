<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    public function index()
    {
        Gate::authorize('view', 'users');

        $users = User::paginate(); 

        return UserResource::collection($users);
    }

    public function show($id)
    {
        Gate::authorize('view', 'users');

        $user = User::findOrFail($id);

        return new UserResource($user);
    }

    public function store(Request $request)
    {
        Gate::authorize('edit', 'users');

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create(
            $request->only(['first_name', 'last_name', 'email', 'role_id']) +
                [
                    'password' => Hash::make(1234),
                    // 'password' => Hash::make($request->input('password')),
                ]
        );

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    {
        Gate::authorize('edit', 'users');

        $request->validate([
            'email' => 'email',
        ]);

        $user = User::findOrfail($id);
        $user->update($request->only(['first_name', 'last_name', 'email', 'role_id']));


        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }


    public function destroy($id)
    {

        Gate::authorize('edit', 'users');

        User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}