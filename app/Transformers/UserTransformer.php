<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
         * password
         * surname
         * prefijo
         * telefono
         * state
         * country
         * city
         * number
         * address
         * rol_id
         */	


        return [
            'id' => (int)$user->id,
            'email' => (string)$user->email,
            'password' => (string)$user->password,
            'name' => (string)$user->name,
            'surname' => (string)$user->surname,
            'prefijo' => (string)$user->prefijo,
            'telefono' => (string)$user->telefono,
            'state' => (string)$user->state,
            'country' => (string)$user->country,
            'city' => (string)$user->city,
            'number' => (string)$user->number,
            'address' => (string)$user->address,
            'rol_id' => (string)$user->rol_id,
            'deleted_at' => isset($user->deleted_at) ? (string) $user->deleted_at : null,
        
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'email' => 'email',
            'name' => 'name',
            'surname' => 'surname',
            'prefijo' => 'prefijo',
            'telefono' => 'telefono',
            'state' => 'state',
            'country' => 'country',
            'city' => 'city',
            'number' => 'number',
            'address' => 'address',
            'rol_id' => 'rol_id'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'email' => 'email',
            'name' => 'name',
            'surname' => 'surname',
            'prefijo' => 'prefijo',
            'telefono' => 'telefono',
            'state' => 'state',
            'country' => 'country',
            'city' => 'city',
            'number' => 'number',
            'address' => 'address',
            'rol_id' => 'rol_id'
            
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
