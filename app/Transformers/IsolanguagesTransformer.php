<?php

namespace App\Transformers;

use App\Models\Isolanguages;
use League\Fractal\TransformerAbstract;

class IsolanguagesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Isolanguages $isolanguages)
    {

        /**
         * title
         * language_id
         * iso
         */	


        return [
            'id' => (int)$isolanguages->id,
            'title' => (string)$isolanguages->title,
            'language_id' => (string)$isolanguages->language_id,
            'iso' => (string)$isolanguages->iso,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'title' => 'title',
            'language_id' => 'language_id',
            'iso' => 'iso'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'title' => 'title',
            'language_id' => 'language_id',
            'iso' => 'iso',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
