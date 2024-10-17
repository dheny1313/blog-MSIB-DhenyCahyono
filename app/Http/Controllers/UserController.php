<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
