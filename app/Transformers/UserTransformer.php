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
         * cuota
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
            'particular' => (string)$user->particular,
            'postalcode' => (string)$user->postalcode,
            'number' => (string)$user->number,
            'address' => (string)$user->address,
            'rol_id' => (string)$user->rol_id,
            'cuota' => (int)$user->cuota
        
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'email' => 'email',
            'password' => 'password',
            'name' => 'name',
            'surname' => 'surname',
            'prefijo' => 'prefijo',
            'telefono' => 'telefono',
            'state' => 'state',
            'country' => 'country',
            'city' => 'city',
            'particular' => 'particular',
            'postalcode' => 'postalcode',
            'number' => 'number',
            'address' => 'address',
            'rol_id' => 'rol_id',
            'cuota' => 'cuota'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'email' => 'email',
            'password' => 'password',
            'name' => 'name',
            'surname' => 'surname',
            'prefijo' => 'prefijo',
            'telefono' => 'telefono',
            'state' => 'state',
            'country' => 'country',
            'city' => 'city',
            'particular' => 'particular',
            'postalcode' => 'postalcode',
            'number' => 'number',
            'address' => 'address',
            'rol_id' => 'rol_id',
            'cuota' => 'cuota'
            
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    
}
