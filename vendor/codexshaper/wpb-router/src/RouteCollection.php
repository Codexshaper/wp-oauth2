<?php

namespace CodexShaper\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection as IlluminateRouteCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteCollection extends IlluminateRouteCollection
{
    /**
     * Handle the matched route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Routing\Route|null  $route
     * @return \Illuminate\Routing\Route
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function handleMatchedRoute(Request $request, $route)
    {
        if (! is_null($route)) {
            return $route->bind($request);
        }

        // If no route was found we will now check if a matching route is specified by
        // another HTTP verb. If it is we will need to throw a MethodNotAllowed and
        // inform the user agent of which HTTP verb it should use for this route.
        $others = $this->checkForAlternateVerbs($request);

        if (count($others) > 0) {
            return $this->getRouteForMethods($request, $others);
        }

        // throw new NotFoundHttpException;

        return false;
    }
}
