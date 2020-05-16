<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            "username" => "min:4|max:32|regex:/^[a-zA-Z0-9\-\_]+$/",
            "password" => "required_with:confirmPassword|same:confirmPassword|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d\-\_]{8,50}$/",
        ]);
        User::create($request->all());
        return response("created", 201);;
    }
}
