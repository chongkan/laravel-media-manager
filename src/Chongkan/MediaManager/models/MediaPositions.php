<?php

namespace Chongkan\MediaManager\Models;

class MediaPositions extends \Eloquent {
    // Add your validation rules here
    public static $rules = [
        'caption' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = array(
        'url',
        'file_path',
        'position',
        'start_date',
        'end_date',
        'order',
        'attr_class',
        'attr_id',
        'other_atts'
    );



    protected $table = 'media_positions';
}