<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'ajax*',
        'anexo/removeTemp',
        'anexo/temp',
        'dashboard/usuario/upload/foto',
        'dashboard/apuracao/validate/anexo',
    ];
}
