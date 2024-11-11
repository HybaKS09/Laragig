<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register/crete form
    public function create()
    {
        return view('users.register');
    }

    //store the new user
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required','email', Rule::unique('users', 'email')],
            'password' => ['required' , 'confirmed' , 'min:6']
        ]);

        //hash the password
        $formFields['password'] = bcrypt($formFields['password']);

        //create the user
       $user = User::create($formFields);

        //login the user
        auth()->login($user);

        //redirect to home
        return redirect('/listings')->with('message', 'User created and logged in successfully');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/listings')->with('message', 'You are logged out');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/listings')->with('message', 'You are logged in successfully');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');


    }
}
