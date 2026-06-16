<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Message;
use Throwable;

Route::get('/email', function () {
  
        Mail::raw('Mensagem de teste de RH MANGNT', function (Message $message) {
            $message->to('teste@gmail.com')
                ->subject('Teste de Email')
                ->from('rh@rh_mangnt.com');
        });

        echo 'Email enviado com sucesso!';
 
});
