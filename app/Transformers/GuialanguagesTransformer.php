<?php

namespace App\Transformers;

use App\Models\Guialanguages;
use League\Fractal\TransformerAbstract;

class GuialanguagesTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Guialanguages $guialanguages)
    {

        /**
         * id,
         * language_id,
         * user_id,
         */	


        return [
            'id' => (int)$guialanguages->id,
            'language_id' => (int)$guialanguages->language_id,
            'user_id' => (int)$guialanguages->user_id,

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'language_id' => 'language_id',
            'user_id' => 'user_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'language_id' => 'language_id',
            'user_id' => 'user_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
