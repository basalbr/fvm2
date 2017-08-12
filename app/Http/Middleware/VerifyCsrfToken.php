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
        'cron*',
        'anexo/removeTemp',
        'anexo/temp',
        'notifications*',
        'dashboard/usuario/upload/foto',
        'dashboard/apuracao/validate/anexo',
        'admin/apuracao/validate/guia',
        'admin/pro-labore/validate/guia',
        'admin/processamento-folha/validate/arquivo',
    ];
}
