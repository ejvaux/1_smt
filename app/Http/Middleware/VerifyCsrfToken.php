<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'models',
        'models/*',
        'components',
        'components/*',
        'feeders',
        'feeders/*',
        'lines',
        'lines/*',
        'employees',
        'employees/*',
        'machines',
        'machines/*',
        'linenames',
        'linenames/*',
        'feederupdate/*',
        'fl',
        'del_mount',
        'change_mount',
        'transfer_mount',
        'del_machine',
        'processes',
        'processes/*',
        'defects',
        'defects/*',
        'process/*',
        'api/*',
        'ajax/*',
        'materialload',
        'loadsnpn',
        'exportsnpn',
        'update_usage',
        'scanpinemp',
        'lcu',
        'testt'
    ];
}
