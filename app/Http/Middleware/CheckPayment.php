<?php

namespace App\Http\Middleware;

use Auth;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Session;

class CheckPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        if (Auth::user()->admin == 1) {
            return $next($request);
        }
        $date = Carbon::today()->subDays(31)->format('Y-m-d');
        $pagamentos = Auth::user()->ordensPagamento()->whereNotIn('status', ['Paga', 'Disponível'])->where('vencimento', '<=', $date)->where('referencia', 'mensalidade')->count();
        if ($pagamentos > 0) {
            return redirect()->route('blockedByPendingPayment');
        }
        return $next($request);

    }
}
