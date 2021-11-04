<?php

namespace App\Http\Controllers;

//use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function destroy($id){

        $user = User::find($id);

        $user->delete();

        return redirect('users')->with('success','user deleted successfully');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);
        return redirect(route('users.show', ['user' => $user]));
    }

}
