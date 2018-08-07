<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Mail;
use App\Mail\EmailConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'confirmation_code' => str_random(25),
        ]);

        Mail::to($user)->send(new EmailConfirmation($user));

//        return redirect()->back();
        return $user;
    }

    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();

        if (! $user){
            return redirect()->route('login')->with('warning', 'Lo sentimos, tu email no puede ser identificado');
        }
        //else
        if(!$user->confirmed) {
            $user->confirmed = 1;
//            $user->confirmation_code = null;
            $user->save();
            $status = 'Tu email ha sido verificado. Ahora puedes iniciar sesión';
        }
        else{
            $status = 'Tu email ya está verificado. Ahora puedes iniciar sesión';
        }

        return redirect()->route('login')->with('success', $status);

    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')->with('success', 'Te hemos enviado un código de activación. Revisa tu correo electrónico y haz clic en el enlace para verificar');
    }
}
