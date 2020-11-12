<?php

namespace App\Http\Controllers\Auth;
use Config;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    public function username()
    {
        return 'email';
    }

    protected function authenticated(Request $request, $user)
    {

    $db_config = Config::get('database.connections.'.Config::get('database.default'));
    $conn = mysqli_connect($db_config["host"], $db_config["username"], $db_config["password"], $db_config["database"]);
    mysqli_set_charset($conn, 'utf8');

    $sql = "DELETE FROM usuarios WHERE email_verified_at is NULL AND data_cadastro < (NOW() - INTERVAL 3 HOUR)";
    mysqli_query($conn, $sql);

    if(auth()->user()->admin()){
        return redirect('home');
    }else
        return redirect('home');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
