<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(Category $category)
    {

        /**
         * name
         * uuid
         */


        return [
            'id' => (int)$category->id,
            'name' => (string)$category->name ?? "",
            'uuid' => (string)$category->uuid ?? "",
            'content' => (string)$category->content ?? ""
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'uuid' => 'uuid',
            'content' => 'content',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'uuid' => 'uuid',
            'content' => 'content',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
