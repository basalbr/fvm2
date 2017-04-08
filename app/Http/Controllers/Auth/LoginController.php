<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,ValidatesRequests;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Where to redirect users after registration.
     *
     */
    protected function redirectTo()
    {
        return route('dashboard');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return ['email' => $request->get('email'), 'password' => $request->get('senha')];
    }


    protected function validateLogin(Request $request)
    {
        /*
        * Valida a requisição, retorna json com erro de validação caso falhe
        */
        $rules = ['email' => 'required|email', 'senha' => 'required'];
        $niceNames = ['email' => 'E-mail', 'senha' => 'Senha'];
        $this->validate($request, $rules, [], $niceNames);
    }

}
