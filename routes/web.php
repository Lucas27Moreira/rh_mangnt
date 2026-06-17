<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Message;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email', function () {
    try {
        Mail::raw('Mensagem de teste de RH MANGNT', function (Message $message) {
            $message->to('teste@gmail.com')
                ->subject('Teste de Email')
                ->from('rh@rh_mangnt.com');
        });

        return 'Email enviado com sucesso!';
    } catch (\Exception $e) {
        Log::error('Erro ao enviar email: ' . $e->getMessage());
        return 'Erro ao enviar email. Verifique os logs.';
    }
});

Route::get('/admin', function () {
    $admin = User::with(['userDetail', 'department'])->find(1);
    
    if (!$admin) {
        return 'Administrador não encontrado.';
    }

    dd($admin->toArray());
});
