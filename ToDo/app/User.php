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
        'id_instituicao', 'id_area', 'id_regiao_cidade', 'telefone_usuario',
        'conteudo_comentarios', 'id_usuario', 'data_comentarios', 'img_capa', 'id_regiao_estado'
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

    const BLOCK = '4';
    const ADMIN = '3';
    const USUARIO = '1';

    public function admin()    {        
        return $this->nivel == self::ADMIN;  //função define num adm
    }

    public function bloqueado()    {        
        return $this->nivel == self::BLOCK;  //função define num block
    }
}
