<?php

namespace Yugo\FilamentQuran\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class SetQuranLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $provider = $route?->parameter('provider');
        $locale = $route?->parameter('locale');
        $providers = config('quran.providers', []);

        if ($provider === null) {
            $provider = config('quran.provider');
        } elseif (! array_key_exists($provider, $providers)) {
            if ($locale !== null || ! preg_match('/^[a-z]{2}(?:[-_][A-Z]{2})?$/', $provider)) {
                throw new NotFoundHttpException;
            }

            $locale = $provider;
            $provider = config('quran.provider');
        }

        $locale = (string) ($locale ?: config('app.locale'));

        $route?->setParameter('provider', $provider);
        $route?->setParameter('locale', $locale);
        config()->set('quran.provider', $provider);

        app()->setLocale($locale);

        return $next($request);
    }
}
