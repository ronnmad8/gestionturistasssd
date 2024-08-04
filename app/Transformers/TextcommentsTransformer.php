<?php

namespace App\Transformers;

use App\Models\Textcomments;
use League\Fractal\TransformerAbstract;

class TextcommentsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Textcomments $textcomments)
    {

        /**
         * name,
         * titulo,
         * uuid,
         * content,
         * content_type
         * language_id
         */	


        return [
            'name' => (string)$textcomments->name,
            'titulo' => (string)$textcomments->titulo,
            'content' => (string)$textcomments->content,
            'uuid' => (string)$textcomments->uuid,
            'content_type' => (string)$textcomments->content_type,
            'language_id' => (int)$textcomments->language_id,
            'visit_id' => (int)$textcomments->visit_id,
            'image' => (string)$textcomments->image,
            'visit' => $textcomments->visit->visitlanguages
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'name' => 'name',
            'titulo' => 'titulo',
            'content' => 'content',
            'uuid' => 'uuid',
            'visit_id' => 'visit_id',
            'image' => 'image',
            'content_type' => 'content_type',
            'language_id' => 'language_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'name' => 'name',
            'titulo' => 'titulo',
            'content' => 'content',
            'uuid' => 'uuid',
            'visit_id' => 'visit_id',
            'image' => 'image',
            'content_type' => 'content_type',
            'language_id' => 'language_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
