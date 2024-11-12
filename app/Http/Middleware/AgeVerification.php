<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

use Log;

class AgeVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // セッションに年齢確認情報がない場合、welcomeページにリダイレクト
        // age_verified セッションがない場合、welcomeページにリダイレクト
        // ↓現状インデックス登録のクロールのため無効化しておく
        // if (!Session::has('age_verified')) {
        //     return redirect()->route('welcomePage');
        // }

        return $next($request);
    }
}
