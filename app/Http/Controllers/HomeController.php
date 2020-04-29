<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function registro() //nome função do web.php
    {
        return view('auth.register'); //retorna da pasta view ('pasta.arquivo');
    }

    public function log_in()
    {
        return view('auth.login');
    }
      
    public function home()
    {
        return view('home'); 
    }

    public function pagina()
    {
        return view('otherpage');
    }

    public function logout() {
		
        Auth::logout();
        //seria bom colocar um aviso depois
        return view('auth.logout');
        
    }

}