<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagementAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'photo' => 'nullable|image',
            'role'  => 'required|in:admin,superadmin',
            'verified_at'   => 'nullable'
        ]);

        $data['password'] = Hash::make($data['password']);

        if (isset($data['photo'])) {
            $data['photo'] = $data['photo']->store('users/images');
        }

        $user = \App\Models\User::create($data);

        if (isset($data['verified_at'])) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('accounts.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $account)
    {
        return view('users.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $account)
    {
        $data = $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $account->id,
            'password' => 'nullable|confirmed',
            'photo' => 'nullable|image',
            'role'  => 'required|in:admin,superadmin',
            'verified_at'   => 'nullable'
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['photo'])) {
            $data['photo'] = $data['photo']->store('users/images');
        }

        $account->update($data);

        if (isset($data['verified_at'])) {
            $account->markEmailAsVerified();
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $account)
    {
        $account->delete();

        return response()->json(['status' => 'ok']);
    }
}
