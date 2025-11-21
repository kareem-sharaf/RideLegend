<?php

namespace App\Http\Controllers\Auth;

use App\Application\Auth\Actions\LoginUserAction;
use App\Application\Auth\DTOs\LoginUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(
        private LoginUserAction $loginUserAction
    ) {}

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $dto = LoginUserDTO::fromArray($request->validated());
        $user = $this->loginUserAction->execute($dto);

        // Log the user in
        $eloquentUser = \App\Models\User::find($user->getId());
        Auth::login($eloquentUser, $dto->remember);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Login successful',
                'user' => new UserResource($user),
            ]);
        }

        return redirect()->intended(route('dashboard'))->with('success', 'Login successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Logged out successfully',
            ]);
        }

        return redirect()->route('home');
    }
}

