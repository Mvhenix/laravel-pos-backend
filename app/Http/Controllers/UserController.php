<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // index
    public function index(Request $request){
        // Get users with pagination
        $users = DB::table('users')
        ->when($request->search, function($query) use ($request){
            $query->where('name', 'like', "%{$request->search}%")
            ->orwhere('email', 'like', "%{$request->search}%");
        })
        ->paginate(5);
        return view ('pages.user.index', compact('users'));
    }

    // create
    public function create(){
        return view ('pages.user.create');
    }

    // store
    public function store(StoreUserRequest $request){
        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
        User::create($data);
        return redirect()->route('user.index');
    }

    // show
    public function show($id){
        return view ('pages.dashboard');
    }

    // edit
    public function edit($id){
        $user = User::findOrFail($id);
        return view ('pages.user.edit', compact('user'));
    }

    // update
    public function update(Request $request, $id){
        $data = $request->all();
        $user = User::findOrFail($id);
        // check if password not empty
        if ($request->input('passord')){
            $data['password'] = Hash::make($request->input('password'));
        } else {
            // if password is empty, the use old password
            $data['password'] = $user->password;
        }
        $user->update($data);
        return redirect()->route('user.index');
    }

    // destroy
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index');
    }
}
