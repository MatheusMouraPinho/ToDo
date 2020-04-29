<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
//    use Queueable;

    // muda oq é escrito no email, poderia ter mudado tbm em vendor/illuminate/auth/notifications/VerifyEmail
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->greeting(Lang::get('Ola!'))
            ->subject(Lang::get('Comfirmar Verificação'))
            ->line(Lang::get('Por favor Comfirme seu cadastro para ter acesso ao nosso site.'))
            ->action(
                Lang::get('Comfirmar Verificação'),
                $this->verificationUrl($notifiable)
            )
            ->line(Lang::get('Se não foi você não criou a conta não sera necessario a confirmação.'))
            ->salutation(Lang::get('Repositorio De Ideias ToDo.'));
    }
}