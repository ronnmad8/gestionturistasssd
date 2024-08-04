<?php

namespace App\Transformers;

use App\Models\Visittag;
use League\Fractal\TransformerAbstract;

class VisittagsTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Visittag $visittag)
    {

        /**
         * visit_id
         * tags_id
         */	


        return [
            'id' => (int)$visittag->id,
            'visit_id' => (int)$visittag->visit_id,
            'tags_id' => (int)$visittag->tags_id

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'visit_id' => 'visit_id',
            'tags_id' => 'tags_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'visit_id' => 'visit_id',
            'tags_id' => 'tags_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
