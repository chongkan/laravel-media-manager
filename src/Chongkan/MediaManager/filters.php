<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/


/*
|--------------------------------------------------------------------------
| AFTER
|--------------------------------------------------------------------------
| To parse responses
*/
\Route::filter('CKPositions', function($route, $request, $response){
    $path = $route->getPath();
    dd();
    CKPositions::render($response, $path);
});