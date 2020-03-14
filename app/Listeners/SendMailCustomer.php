<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use App\Notifications\ClienteCriado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMailCustomer implements ShouldQueue
{
    use InteractsWithQueue;
    
    /*public function __construct()
    {
        //
    } */

    
    public function handle($event)
    {
        //ta sta ciente ta escuta hrs k si event executado pe fz si trabadju k nes casu é: MANDA EMAIL PA CLIENTE CRIADO i NOTIFICASON PA USER K CRIA TAL CLIENTE

        $to_mail = $event->cliente->email;
        $to_name = $event->cliente->nome;

        $dadosmail = array("name"=>$to_name, "body"=> "Seu registo foi feito com sucesso. Agora já es um dos nossos cliente! Agradecemos desde já pela sua preferência, Obrigado");

        Mail::send('mail', $dadosmail,function ($message) use ($to_name, $to_mail){
            $message->to($to_mail)
            ->subject('Notificação registo como cliente da WashCar Tarrafal');
        });

        // $user = \App\User::find(auth()->user()->id);

        // \Notification::send($user, new ClienteCriado($event->cliente));
        
    }
}
