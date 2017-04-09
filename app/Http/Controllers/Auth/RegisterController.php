<?php

namespace App\Http\Controllers\Auth;

use App\Services\RegisterUsuario;
use App\User;
use App\Http\Controllers\Controller;
use App\Validation\UsuarioValidation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers, AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function validateAjax(Request $request)
    {
        /*
        * Valida a requisição, retorna json com erro de validação caso falhe
        */
        $this->validate($request, UsuarioValidation::getRules(), [], UsuarioValidation::getNiceNames());
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
     * Registers users
     * @param Request $request
     * @return Redirect
     */
    protected function register(Request $request)
    {
        $this->validate($request, UsuarioValidation::getRules(), [], UsuarioValidation::getNiceNames());
        if ($usuario = RegisterUsuario::handle($request->all())) {
            $this->guard()->login($usuario);
            return redirect($this->redirectPath());

        }

        return redirect(route('home'));
    }
}
