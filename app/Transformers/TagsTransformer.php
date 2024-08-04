<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Tag $tag)
    {

        /**
         * name
         */	


        return [
            'id' => (int)$tag->id,
            'name' => (string)$tag->name,
            'uuid' => (string)$tag->uuid,

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'uuid' => 'uuid'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'uuid' => 'uuid'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
