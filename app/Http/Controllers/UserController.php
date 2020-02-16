<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        $validated = $this->validate($request, [
            'searchTerm' => 'required|string'
        ]);

        $users = User::search($validated['searchTerm'])->get();
        return $users;
    }

    public function results()
    {
        return view('user.search');
    }
}
