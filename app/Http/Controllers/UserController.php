<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            "username" => "min:4|max:32|regex:/^[a-zA-Z0-9\-\_]+$/",
            "password" => "required_with:confirmPassword|same:confirmPassword|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\-\_]{8,50}$/",
            "roles.*" => "not_in:1",
        ]);
        $user = User::create($request->all());
        $user->roles()->sync($request->roles);
        return response("created", 201);;
    }

    public function update(Request $request, $user_id) {
        $this->validate($request, [
            "username" => "min:4|max:32|regex:/^[a-zA-Z0-9\-\_]+$/",
            "password" => "required_with:confirmPassword|same:confirmPassword|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\-\_]{8,50}$/",
            "roles.*" => "not_in:1",
        ]);
        $user = User::find($user_id);
        $user->update($request->all());
        $user->roles()->sync($request->roles);
        return response("updated", 201);
    }

    public function show($user_id) {
        return new UserResource(User::find($user_id));
    }

    public function destroy($user_id) {
        $user = User::find($user_id);
        $user->delete();
    }

    
}
