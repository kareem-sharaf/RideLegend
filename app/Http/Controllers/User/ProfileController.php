<?php

namespace App\Http\Controllers\User;

use App\Application\User\Actions\ChangePasswordAction;
use App\Application\User\Actions\UpdateUserProfileAction;
use App\Application\User\Actions\UploadUserAvatarAction;
use App\Application\User\DTOs\ChangePasswordDTO;
use App\Application\User\DTOs\UpdateUserProfileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(
        private UpdateUserProfileAction $updateUserProfileAction,
        private UploadUserAvatarAction $uploadUserAvatarAction,
        private ChangePasswordAction $changePasswordAction
    ) {}

    public function show()
    {
        $user = auth()->user();
        $domainUser = app(\App\Domain\User\Repositories\UserRepositoryInterface::class)
            ->findById($user->id);

        if (request()->expectsJson()) {
            return response()->json([
                'user' => new UserResource($domainUser),
            ]);
        }

        return view('user.profile.index', ['user' => $domainUser]);
    }

    public function showEdit()
    {
        return view('user.profile.edit');
    }

    public function showSettings()
    {
        return view('user.profile.settings');
    }

    public function update(UpdateProfileRequest $request)
    {
        $dto = UpdateUserProfileDTO::fromArray(auth()->user()->id, $request->validated());
        $user = $this->updateUserProfileAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => new UserResource($user),
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function uploadAvatar(UploadAvatarRequest $request)
    {
        $user = $this->uploadUserAvatarAction->execute(
            auth()->user()->id,
            $request->file('avatar')
        );

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Avatar uploaded successfully',
                'user' => new UserResource($user),
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Avatar uploaded successfully!');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $dto = ChangePasswordDTO::fromArray(auth()->user()->id, $request->validated());
        $this->changePasswordAction->execute($dto);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Password changed successfully',
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }
}

