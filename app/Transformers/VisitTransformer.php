<?php

namespace App\Transformers;

use App\Models\Visit;
use League\Fractal\TransformerAbstract;


class VisitTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Visit $visit)
    {
        /**
        *id,
    	*uuid,
        *cuandomin, 
        *cancelacion, 
        *temporada,
        *mascotas,
        *accesibilidad,
        *duracionmin,
        *preciohoramin,
        *puntoencuentro,
        *name,
        *nummax,
        *descripcion,
        *titulo,
        *precio,
        */

        return [
            'id' => (int)$visit->id,
            'uuid' => (string)$visit->uuid,
            'cuandomin' => (string)$visit->cuandomin,
            'cancelacion' => $visit->cancelacion,
            'temporada' => $visit->temporada,
            'mascotas' => $visit->mascotas,
            'accesibilidad' => $visit->duracionmin,
            'duracionmin' => $visit->duracionmin,
            'preciohoramin' => ($visit->preciohoramin *1 ),
            'puntoencuentro' => $visit->puntoencuentro,
            'name' => $visit->name,
            'nummax' => $visit->nummax,
            'titulo' => $visit->titulo,
            'descripcion' => $visit->descripcion,
            'mediafiles' => $visit->mediafiles,
            'precio' => $visit->precio
            
        ];
    }

    public static function originalAttribute($index)
    {

        $attributes = [
            'id' => 'id',
            'uuid' => 'uuid',
            'cuandomin' => 'cuandomin',
            'cancelacion' => 'cancelacion',
            'temporada' => 'temporada',
            'mascotas' => 'mascotas',
            'accesibilidad' => 'accesibilidad',
            'duracionmin' => 'duracionmin',
            'preciohoramin' => 'preciohoramin',
            'recomendado' => 'recomendado',
            'name' => 'name',
            'nummax' => 'nummax',
            'puntodeencuentro' => 'puntodeencuentro',
            'titulo' => 'titulo',
            'descripcion' => 'descripcion',
            'precio' => 'precio'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'uuid' => 'uuid',
            'cuandomin' => 'cuandomin',
            'cancelacion' => 'cancelacion',
            'temporada' => 'temporada',
            'mascotas' => 'mascotas',
            'accesibilidad' => 'accesibilidad',
            'duracionmin' => 'duracionmin',
            'preciohoramin' => 'preciohoramin',
            'recomendado' => 'recomendado',
            'name' => 'name',
            'nummax' => 'nummax',
            'puntodeencuentro' => 'puntodeencuentro',
            'titulo' => 'titulo',
            'descripcion' => 'descripcion',
            'precio' => 'precio'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
