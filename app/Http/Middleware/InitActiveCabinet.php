<?php

namespace App\Http\Middleware;

use Closure;

class InitActiveCabinet
{
    public function handle($request, Closure $next)
    {
        // Только для авторизованных
        if (auth()->check() && !session()->has('active_cabinet')) {
            // Берём первую роль пользователя (минимальный вариант)
            $cabinet = auth()->user()->roles->pluck('name')->first();

            // Сохраняем в сессию
            session(['active_cabinet' => $cabinet]);
        }

        return $next($request);
    }
}
