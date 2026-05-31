<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Create User
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'nullable',
            'image' => 'nullable',
            'note' => 'nullable',
            'password' => 'required|min:6',
        ]);

        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }

    // Update User (password optional)
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes',
            'email' => 'sometimes|email',
            'username' => 'nullable',
            'image' => 'nullable',
            'note' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);

            // logout all tokens when password changes
            $user->tokens()->delete();
        }

        $user->update($data);

        return response()->json($user);
    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password incorrect'], 400);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        // logout after password change
        $user->tokens()->delete();

        return response()->json(['message' => 'Password changed']);
    }

    public function index()
    {
        return User::all();
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}