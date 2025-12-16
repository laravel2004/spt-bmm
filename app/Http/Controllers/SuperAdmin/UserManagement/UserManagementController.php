<?php

namespace App\Http\Controllers\SuperAdmin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UserAddFormRequest;
use App\Http\Requests\UserManagement\UserUpdateFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        try {
            $search  = trim((string) $request->query('search', ''));
            $perPage = (int) $request->query('perPage', 10);
            $perPage = max(1, min($perPage, 100));

            $query = $this->user->newQuery();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_num', 'like', "%{$search}%");
                });
            }

            $users = $query
                ->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

            return view('pages.superadmin.user-management.index', compact('users'));
        } catch (\Throwable $e) {
            Log::error('[UserManagementController@index] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load users');
        }
    }

    public function create()
    {
        try {
            return view('pages.superadmin.user-management.create');
        } catch (\Throwable $e) {
            Log::error('[UserManagementController@create] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load user creation form');
        }
    }

    public function store(UserAddFormRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('photo_text')) {
                $data['photo_text'] = $request->file('photo_text')->store('users', 'public');
            }

            $data['password'] = bcrypt($data['password']);

            $user = auth()->user();
            $data['created_by'] = $user->username;

            $user = $this->user->create($data);

            return $this->successResponse($user, 'User created successfully.', 201);
        } catch (\Throwable $e) {
            Log::error('[UserManagementController@store] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse("Failed to create user", 500);
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->user->findOrFail($id);
            return view('pages.superadmin.user-management.edit', compact('user'));
        } catch (\Throwable $e) {
            Log::error('[UserManagementController@edit] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            abort(500, 'Failed to load user edit form');
        }
    }

    public function update(UserUpdateFormRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $user = $this->user->findOrFail($id);

            if ($request->hasFile('photo_text')) {
                if (!empty($user->photo_text) && Storage::disk('public')->exists($user->photo_text)) {
                    Storage::disk('public')->delete($user->photo_text);
                }

                $data['photo_text'] = $request->file('photo_text')->store('users', 'public');
            } else {
                unset($data['photo_text']);
            }

            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }

            $authUser = auth()->user();
            $data['modified_by'] = $authUser?->username;

            $user->update($data);

            return $this->successResponse($user->fresh(), 'User updated successfully.', 200);
        } catch (\Throwable $e) {
            Log::error('[UserManagementController@update] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to update user', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->user->findOrFail($id);

            if (!empty($user->photo_text) && Storage::disk('public')->exists($user->photo_text)) {
                Storage::disk('public')->delete($user->photo_text);
            }

            $user->delete();

            return $this->successResponse(null, 'User deleted successfully.', 200);
        } catch (\Throwable $e) {
            Log::error('[UserManagementController@destroy] ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->errorResponse('Failed to delete user', 500);
        }
    }
}
