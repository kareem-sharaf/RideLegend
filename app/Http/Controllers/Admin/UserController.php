<?php

namespace App\Http\Controllers\Admin;

use App\Application\Admin\Users\Actions\BanUserAction;
use App\Application\Admin\Users\Actions\DeleteUserAction;
use App\Application\Admin\Users\Actions\ListUsersAction;
use App\Application\Admin\Users\Actions\ShowUserAction;
use App\Application\Admin\Users\Actions\UnbanUserAction;
use App\Application\Admin\Users\Actions\UpdateUserAction;
use App\Application\Admin\Users\DTOs\BanUserDTO;
use App\Application\Admin\Users\DTOs\DeleteUserDTO;
use App\Application\Admin\Users\DTOs\ListUsersDTO;
use App\Application\Admin\Users\DTOs\ShowUserDTO;
use App\Application\Admin\Users\DTOs\UpdateUserDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        private ListUsersAction $listUsersAction,
        private ShowUserAction $showUserAction,
        private UpdateUserAction $updateUserAction,
        private DeleteUserAction $deleteUserAction,
        private BanUserAction $banUserAction,
        private UnbanUserAction $unbanUserAction,
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $dto = new ListUsersDTO(
            role: $request->input('role'),
            search: $request->input('search'),
            status: $request->input('status'),
            sortBy: $request->input('sort_by', 'created_at'),
            sortDirection: $request->input('sort_direction', 'desc'),
            page: $request->input('page', 1),
            perPage: $request->input('per_page', 15),
        );

        $users = $this->listUsersAction->execute($dto);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $dto = new ShowUserDTO(userId: (int)$id);
        $result = $this->showUserAction->execute($dto);

        return view('admin.users.show', [
            'user' => $result['user'],
            'stats' => $result['stats'],
        ]);
    }

    public function edit($id)
    {
        $dto = new ShowUserDTO(userId: (int)$id);
        $result = $this->showUserAction->execute($dto);
        $roles = Role::all();

        return view('admin.users.edit', [
            'user' => $result['user'],
            'stats' => $result['stats'],
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'roles' => 'nullable|array',
        ]);

        $dto = new UpdateUserDTO(
            userId: (int)$id,
            firstName: $validated['first_name'],
            lastName: $validated['last_name'],
            email: $validated['email'],
            phone: $validated['phone'] ?? null,
            roles: $validated['roles'] ?? null,
        );

        $this->updateUserAction->execute($dto);

        return redirect()->route('admin.users.show', $id)
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $dto = new DeleteUserDTO(
            userId: (int)$id,
            adminId: auth()->id(),
        );

        try {
            $this->deleteUserAction->execute($dto);
        } catch (\DomainException $e) {
            return redirect()->route('admin.users.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function toggleStatus($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        if ($user->email_verified_at) {
            $dto = new BanUserDTO(userId: (int)$id);
            $this->banUserAction->execute($dto);
            $message = 'User banned successfully';
        } else {
            $dto = new BanUserDTO(userId: (int)$id);
            $this->unbanUserAction->execute($dto);
            $message = 'User unbanned successfully';
        }

        return redirect()->back()->with('success', $message);
    }
}
