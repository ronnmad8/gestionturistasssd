<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserSecTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public static function transform(User $user)
    {

        /**
         * name,
         * email,
         * 
         */	


        return [
            'iduser' => (int)$user->id,
            'nombre' => (string)$user->name,
            'email' => (string)$user->email,
            'idrol' => (int)$user->rols_id,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'iduser' => 'id',
            'nombre' => 'name',
            'email' => 'email',
            'idrol' => 'rols_id',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'iduser',
            'name' => 'nombre',
            'email' => 'email',
            'rols_id' => 'idrol',
            
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
