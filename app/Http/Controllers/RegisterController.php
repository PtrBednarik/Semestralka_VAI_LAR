<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a view for the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user_register');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required'
        ], [
            'first_name.required' => 'Zadaj meno.',
            'last_name.required' => 'Zadaj priezvisko.',
            'email.required' => 'Zadaj email.',
            'email.unique:users' => 'Takyto email uz existuje.',
            'username.required' => 'Zadaj prihlasovacie meno.',
            'username.unique:users,username' => 'Taketo meno uz existuje.',
            'password.required' => 'Zadaj heslo.',
        ]);
//        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);
        auth()->login($user);
        return redirect('/')->with('success', "Account successfully registered.");
    }


}
