<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);
  
        $user = User::create($formFields);

        //authenticate 
        auth()->login($user);

        return redirect('/')->with('message','User created and logged in');

    }

    /**
     * Lougout User
     *
     * @return void
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','User successfully logout');
    }

    public function login()
    {
        return view('users.login');
    }

    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields))
        {
            $request->session()->regenerate();

            return redirect('/')->with('message','You are now logged in');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email','password');
    }

}
