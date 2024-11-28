<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Las rutas que deberían ser excluidas de la verificación CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/webhook/mercadopago', // Reemplaza con tu URL de webhook
        'https://e63a-131-108-143-234.ngrok-free.app/webhook/mercadopago',          // Opcional: Si usas Ngrok, puedes excluir todas las URLs de Ngrok
    ];
}
