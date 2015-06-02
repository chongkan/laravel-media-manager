<?php namespace Chongkan\MediaManager;

use Chongkan\MediaManager\Controllers\MediasController;

class MediaManager {

    public static function greeting(){
        return "What up dawg";
    }

    public static function render($response, $path){
        MediasController::render($response, $path);
    }

}