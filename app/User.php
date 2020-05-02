<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmail;
use App\Notifications\ResetPassword;


class User extends Authenticatable implements MustVerifyEmail
{   
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail); //substituir notificão verificação de email
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario', 'registro', 'email',  'senha', 'nivel', 'img_usuarios', 
        'id_instituicao', 'id_area', 'id_regiao_cidade', 'telefone_usuario'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'usuarios'; //tabela que ira puxar os dados pra login

    public $timestamps = false; //retira data de criação/modif que é padrão no insert

    public function getAuthPassword() //função pra usar "senha" como password
    {
    return $this->senha;
    }

    const ADMIN_TYPE = '3';
    const AVALIADOR_TYPE = '2';
    const USUARIO_TYPE = '1';

    public function admin()    {        
        return $this->nivel == self::ADMIN_TYPE;  //função pra definir adm
    }

    public function Avaliador()    {        
        return $this->nivel == self::AVALIADOR_TYPE;  //ainda não utilizado
    }

}
