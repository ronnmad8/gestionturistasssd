<?php

namespace App\Transformers;

use App\Models\Languages;
use League\Fractal\TransformerAbstract;

class LanguagesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(languages $languages)
    {

        /**
         * hora
         */	


        return [
            'id' => (int)$languages->id,
            'name' => (string)$languages->name,
            'iso_code' => (string)$languages->iso_code,
            'iso' => (string)$languages->iso,
            'isolanguages' => (string)$languages->isolanguages,

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'iso' => 'iso',
            'iso_code' => 'iso_code',
            'isolanguages' => 'isolanguages'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'iso' => 'iso',
            'iso_code' => 'iso_code',
            'isolanguages' => 'isolanguages'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
