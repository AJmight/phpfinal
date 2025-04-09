<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
// use App\Models\Role; // If you create a Role model/table later
// use App\Models\Permission; // If you create a Permission model/table later
use Illuminate\Http\Request; // Use specific Request classes later
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // For unique checks on update

class UserAdminController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        // View: resources/views/admin/users/index.blade.php
        // Note: You might already have users/index.blade.php, consider moving admin user management to admin namespace
         return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Define available roles (based on your enum)
        $roles = ['admin', 'team_manager', 'player', 'spectator'];
        // View: resources/views/admin/users/create.blade.php
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with StoreUserRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // Replace with StoreUserRequest
    {
        // Basic validation example (move to StoreUserRequest)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
             // Ensure your User migration has 'username' if using it here
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'team_manager', 'player', 'spectator'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
         // Optional: View: resources/views/admin/users/show.blade.php
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
         $roles = ['admin', 'team_manager', 'player', 'spectator'];
         // View: resources/views/admin/users/edit.blade.php
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with UpdateUserRequest
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user) // Replace with UpdateUserRequest
    {
        // Basic validation example (move to UpdateUserRequest)
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required','string','max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'team_manager', 'player', 'spectator'])],
            'password' => 'nullable|string|min:8|confirmed', // Optional password change
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
             unset($validated['password']); // Don't update password if empty
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Add authorization checks (e.g., cannot delete self, cannot delete last admin)
        if (auth()->id() === $user->id) {
             return back()->withErrors(['delete' => 'You cannot delete your own account.']);
        }

        $user->delete(); // Use soft delete if enabled

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }
}