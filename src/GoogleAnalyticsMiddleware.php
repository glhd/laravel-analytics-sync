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
     * @var string
     */
    protected $columnName;

    public function __construct()
    {
        $this->columnName = $this->getColumnNameFromConfig();
    }

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

    /**
     * @param Request $request
     * @return string
     */
    protected function loadClientIdFromRequest(Request $request)
    {
        return $request->cookie(self::COOKIE_KEY);
    }

    /**
     * @param string $clientId
     * @param Model|null $user
     * @return void
     */
    protected function syncClientIdWithUser($clientId, Model $user = null)
    {
        // Skip if we don't have a user
        if (!isset($user)) {
            return;
        }

        // No need to proceed if we already have the client ID
        if ($user->{$this->columnName} === $clientId) {
            return;
        }

        // Save
        $user->{$this->columnName} = $clientId;
        $user->save();
    }

    /**
     * @param Response $response
     * @param Model $user
     * @return Response
     */
    protected function attachCookieToResponse(Response $response, Model $user)
    {
        if (!empty($user->{$this->columnName})) {
            $response = $response->cookie(self::COOKIE_KEY, $user->{$this->columnName});
        }

        return $response;
    }

    /**
     * @return string
     */
    protected function getColumnNameFromConfig()
    {
        return \Config::get('analytics.column');
    }
}

