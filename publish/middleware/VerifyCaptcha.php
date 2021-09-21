<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponse;
use Closure;
use Illuminate\Support\Facades\Http;

class VerifyCaptcha
{
    use JsonResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() == "POST" && $request->has('g-recaptcha-response')) {
            $captchaResp = $request->input('g-recaptcha-response');
            if (!empty($captchaResp)) {
                $data = [
                    "secret" => config("captcha.secret_key"),
                    "response" => $captchaResp,
                ];

                $resp = Http::withHeaders([
                    "Content-Type" => "application/x-www-form-urlencoded"
                ])->post("https://www.google.com/recaptcha/api/siteverify?secret={$data['secret']}&response={$data['response']}");
                if (!$resp->json()["success"]) {
                    if ($request->expectsJson()) {
                        return $this->error(__("crud.captcha_invalid"));
                    } else {
                        return redirect()->back()->withErrors(['captcha' => __("crud.captcha_invalid")]);
                    }
                }
            } else {
                return redirect()->back()->withErrors(['captcha' => __("crud.captcha_invalid")]);
            }
        };
        return $next($request);
    }
}
