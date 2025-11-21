<?php

namespace App\Http\Controllers\Auth;

use App\Application\Auth\Actions\RegisterUserAction;
use App\Application\Auth\DTOs\RegisterUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(
        private RegisterUserAction $registerUserAction
    ) {}

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $dto = RegisterUserDTO::fromArray($request->validated());
        $user = $this->registerUserAction->execute($dto);

        // Log the user in
        $eloquentUser = \App\Models\User::find($user->getId());
        Auth::login($eloquentUser);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User registered successfully',
                'user' => new UserResource($user),
            ], 201);
        }

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }
}
