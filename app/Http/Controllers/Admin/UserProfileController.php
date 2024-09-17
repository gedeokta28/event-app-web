<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            '_id'       => 'required|exists:users,id',
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $request->get('_id'),
            'password'  => 'nullable|confirmed',
            'photo'     => 'nullable|image',
            'role'      => 'required|in:admin,superadmin',
            'verified_at'   => 'nullable'
        ]);

        $account = User::findOrFail($data['_id']);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['photo'])) {
            $data['photo'] = $data['photo']->store('users/images');
        }

        $account->update(array_filter($data));

        if (isset($data['verified_at'])) {
            $account->markEmailAsVerified();
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }
}
