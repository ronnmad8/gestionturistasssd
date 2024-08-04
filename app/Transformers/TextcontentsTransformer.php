<?php

namespace App\Transformers;

use App\Models\Textcontents;
use League\Fractal\TransformerAbstract;

class TextcontentsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Textcontents $textcontents)
    {

        /**
         * name nombre,
         * uuid,
         * content contenido,
         * url_id idurl
         * content type
         * language_id idlang
         */	


        return [
            'nombre' => (string)$textcontents->name,
            'contenido' => (string)$textcontents->content,
            'uuid' => (string)$textcontents->uuid,
            'idurl' => (int)$textcontents->url_id,
            'typecontent' => (string)$textcontents->content_type,
            'idlang' => (int)$textcontents->language_id
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'name' => 'nombre',
            'content' => 'contenido',
            'uuid' => 'uuid',
            'url_id' => 'idurl',
            'content_type' => 'typecontent',
            'language_id' => 'idlang'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'nombre' => 'name',
            'contenido' => 'content',
            'uuid' => 'uuid',
            'idurl' => 'url_id',
            'typecontent' => 'content_type',
            'idlang' => 'language_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
