<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;
use Illuminate\Container\Attributes\Storage\Log;
class IdentifyTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $host = $request->getHost(); // e.g. abc.parivahanlink.test
        $subdomain = explode('.', $host)[0];


        
        $company = Company::where('subdomain', $subdomain)->first();
        \Log::info('Tenant subdomain: '.$subdomain);
\Log::info('Company found: '.($company ? $company->name : 'none'));


        app()->instance('company', $company);

        return $next($request);
    }
}
