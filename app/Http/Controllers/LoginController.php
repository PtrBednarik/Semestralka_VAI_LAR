<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Display a view for the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user_login');
    }

     /**
     * Handle account login request
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Zadaj prihlasovacie meno.',
            'password.required' => 'Zadaj heslo.',
        ]);

        $credentials = $request->only('username', 'password');

        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors( ['Nepodarilo sa prihlásiť, skúste to prosím znovu.']);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

     /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }


}
