<?php

namespace App\Transformers;

use App\Models\Visitcategory;
use League\Fractal\TransformerAbstract;

class VisitcategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Visitcategory $visitcategory)
    {

        /**
         * category_id
         * visit_id
         */	


        return [
            'id' => (int)$visitcategory->id,
            'category_id' => (int)$visitcategory->category_id,
            'visit_id' => (int)$visitcategory->visit_id
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id'=>'id',
            'visit_id' => 'visit_id',
            'category_id' => 'category_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id'=>'id',
            'visit_id' => 'visit_id',
            'category_id' => 'category_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
