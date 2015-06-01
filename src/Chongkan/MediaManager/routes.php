<?php
/**
 *  Extends PingPong Admin functionality
 */



Route::group(array('prefix' => 'admin'), function ()
{
    Route::group(['before' => 'admin.guest', 'namespace' => 'Pingpong\Admin\Controllers'], function ()
    {
        Route::resource('login', 'LoginController', ['only' => ['index', 'store']]);
    });

    Route::group(['before' => 'admin.auth'], function ()
    {
        // Package Namespace
        Route::group(['namespace' => '\Chongkan\MediaManager\Controllers'], function ()
        {
            Route::resource('medias', 'MediasController', array('only' => array('index')));
            Route::get('medias/get-all', function(){
                return View::make('media-manager::admin.medias.partials.directory-listing');
            });
            // REST TODO CSRF
            Route::post('medias/get-data', array('as' => 'media-manager::admin.medias.getData', 'uses' => 'MediasController@getData'));
            Route::post('medias/save', array('as' => 'admin.medias.save', 'uses' => 'MediasController@save'));
            Route::post('medias/upload', array('as' => 'admin.medias.upload', 'uses' => 'MediasController@upload'));
        });


    });
});