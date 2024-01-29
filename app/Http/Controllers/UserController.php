<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("pages.users.index", compact("users"));
    }

    public function myProfile()
    {
        $user = auth()->user();
        return view("pages.users.profile", compact("user"));
    }

    public function create()
    {
        $roles = Role::all();
        return view("pages.users.create", compact("roles"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "username" => "required|string|unique:users,username",
            "fullname" => "required|string",
            "phone" => "required|string",
            "password" => "required",
            "roles" => "required|array",
        ]);


        $user = User::create([
            "username" => $request->username,
            "fullname" => $request->fullname,
            "phone" => $request->phone,
            "password" => bcrypt($request->password),
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route("users.index")->with("success", "Пользователь успешно создан");


    }

    public function show(User $user)
    {
        return view("pages.users.show", compact("user"));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view("pages.users.edit", compact("user", "roles"));
    }

    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            "username" => "required|string|unique:users,username," . $user->id,
            "fullname" => "required|string",
            "phone" => "required|string",
            "roles" => "required|array",
        ]);


        $user->update([
            "username" => $request->username,
            "fullname" => $request->fullname,
            "phone" => $request->phone,
            "password" => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route("users.index")->with("success", "Пользователь успешно обновлен");

    }

    public function destroy(string $id)
    {
        //
    }

    public function authAdmin(User $user)
    {

        // dd($user);
        if (hasRoles()) {
            auth()->login($user);
            toast('Вы успешно авторизовались как ' . $user->fullname, 'success');
            return redirect()->intended('/');
        }

        return back()->with('toast_error', 'У вас нет доступа!');
    }
}
