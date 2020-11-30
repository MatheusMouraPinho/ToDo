<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Config;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $db_config = Config::get('database.connections.'.Config::get('database.default'));
        $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
        mysqli_set_charset($conn, 'utf8');
    
        $sql = "DELETE FROM usuarios WHERE email_verified_at is NULL AND data_cadastro < (NOW() - INTERVAL 3 HOUR)";
        mysqli_query($conn, $sql);
        
        return Validator::make($data, [
            'usuario' => ['required', 'string', 'max:50'],
            'registro' => ['nullable', 'string', 'min:8', 'max:11'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:usuarios', 'unique:bloqueados'],
            'senha' => ['required', 'string', 'min:6', 'confirmed'],
            'check' => ['required'],
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
        return User::create([
            'usuario' => $data['usuario'],
            'registro' => $data['registro'],
            'email' => $data['email'],
            'nivel' => "1",
            'senha' => Hash::make($data['senha']),
        ]);
    }
}
