<?php

namespace App\Http\Controllers;

//use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUserRequest;
use App\Models\{User,Sortable,UserFilter,Role};
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $users = User::query()
            ->onlyTrashedIf(request()->routeIs('users.trashed'))
            //->whereRoleIs('user')
            ->applyFilters()
            ->paginate();


        return view('users.index', compact('users'));
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

    public function bann($id){
        $user = User::find($id);
        $user->banned = !$user->banned;
        $user->save();
        return redirect('users')->with('success','user banned');
    }

    public function trash(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->where('id', $id)->firstOrFail();

        $user->restore();

        return redirect()->route('users.trashed');
    }

    public function destroy($id){

        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->nre->update([
            'user_id' => null
        ]);
        $user->save();
        $user->forceDelete();

        return redirect()->route('users.trashed');
    }

}
