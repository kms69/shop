<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnvMiddleware
{

    function decrypt($string)
    {
        $secret_key = $_ENV['APP_KEY'];
        $key = openssl_digest(" $secret_key", 'SHA256', TRUE);
        $c = base64_decode($string);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
        if (hash_equals($hmac, $calcmac))

            return $original_plaintext . "\n";
    }


    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('Authorization');
        if (!$key) {
            abort(401, 'Unauthorized');
        }
        if (!$this->decrypt($key)) {
            abort(401, 'Unauthorized');
        }
        return $next($request);
    }
}
