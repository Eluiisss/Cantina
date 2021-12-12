<?php

namespace App\Http\Controllers;

//use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\CreateEmployeeRequest;
use App\Models\{User,Sortable,UserFilter,Role,Nre};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        return redirect()->back();
    }

    public function bann($id){
        $user = User::find($id);
        $user->banned = !$user->banned;
        if(!$user->banned){
            $user->ban_strikes = 0;
        }
        $user->save();
        return redirect()->route('users.index')->with('success','user banned');
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

    public function createEmployee(User $user)
    {
        return view('users.employee',['user' => $user]);
    }

    public function storeEmployee(CreateEmployeeRequest $request)
    {   
        $request->createEmp();
        return redirect(route('users.index'));
    }



}
