<?php

namespace App\Transformers;

use App\Models\Mediafiles;
use League\Fractal\TransformerAbstract;

class MediafilesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Mediafiles $Mediafiles)
    {

        /**
        *visit_id,
        *order,
        *uuid,
        *path,
        *filename,
        *type,
        *url,
         */	


        return [
            'visit_id' => (int)$Mediafiles->visit_id,
            'order' => (int)$Mediafiles->order,
            'uuid' => (string)$Mediafiles->uuid,
            'path' => (string)$Mediafiles->path,
            'filename' => (string)$Mediafiles->filename,
            'type' => (string)$Mediafiles->type,
            'url' => (string)$Mediafiles->url
            
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'visit_id' => 'visit_id',
            'order' => 'order',
            'uuid' => 'uuid',
            'path' => 'path',
            'filename' => 'filename',
            'url' => 'url',
            'type' => 'type'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'visit_id' => 'visit_id',
            'order' => 'order',
            'uuid' => 'uuid',
            'path' => 'path',
            'filename' => 'filename',
            'url' => 'url',
            'type' => 'type'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
