<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class GoogleAnalyticsMiddleware
 *
 * @package App\Http\Middleware
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class GoogleAnalyticsMiddleware
{
    const COOKIE_KEY = '_ga';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \Auth::user();

        // Save _ga to database
        $clientId = $this->loadClientIdFromRequest($request);
        if ($clientId) {
            $this->syncClientIdWithUser($clientId, $user);
        }

        /** @var Response $response */
        $response = $next($request);

        // Send _ga cookie if we have one stored and none @ the client
        if (!isset($clientId)) {
            $response = $this->attachCookieToResponse($response, $user);
        }

        return $response;
    }

    protected function loadClientIdFromRequest(Request $request)
    {
        return $request->cookie(self::COOKIE_KEY);
    }

    protected function syncClientIdWithUser($clientId, Model $user = null)
    {
        // Skip if we don't have a user
        if (!isset($user)) {
            return;
        }

        // No need to proceed if we already have the client ID
        if ($user->analytics_client_id === $clientId) {
            return;
        }

        // Save
        $user->analytics_client_id = $clientId;
        $user->save();
    }

    protected function attachCookieToResponse(Response $response, User $user)
    {
        if (!empty($user->analytics_client_id)) {
            $response = $response->cookie(self::COOKIE_KEY, $user->analytics_client_id);
        }

        return $response;
    }
}