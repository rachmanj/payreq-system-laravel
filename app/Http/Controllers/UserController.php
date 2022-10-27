<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name'          => 'required|min:3|max:255',
            'username'      => 'required|min:3|max:20|unique:users',
            'password'      => 'min:6',
            'password_confirmation' => 'required_with:password|same:password|min:6'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        $user->is_active = 1;
        $user->save();

        $user->assignRole('user');

        return redirect()->route('users.index')->with('success', 'New User successfuly created!!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->getRoleNames()->toArray();

        return view('users.edit', compact(['user', 'roles', 'userRoles']));
    }

    public function roles_user_update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->password) {
            $validatedData = $this->validate($request, [
                'name'          => 'required|min:3|max:255',
                'password'      => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user->update($validatedData);
        } else {
            $validatedData = $this->validate($request, [
                'name'          => 'required|min:3|max:255',
            ]);

            $user->update($validatedData);
        }

        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = 1;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User activated successfully');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = 0;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User deactivated successfully');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->password) {
            $validatedData = $this->validate($request, [
                'name'          => 'required|min:3|max:255',
                'password'      => 'min:6',
                'password_confirmation' => 'required_with:password|same:password|min:6'
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            $user->update($validatedData);
        } else {
            $validatedData = $this->validate($request, [
                'name'          => 'required|min:3|max:255',
            ]);

            $user->update($validatedData);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function data()
    {
        $users = User::all();

        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('action', 'users.action')
            ->rawColumns(['action'])
            ->toJson();
    }
}
