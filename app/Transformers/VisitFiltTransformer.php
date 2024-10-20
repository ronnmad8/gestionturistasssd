<?php

namespace App\Transformers;

use App\Models\Visit;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Hours;
use App\Models\Mediafile;
use League\Fractal\TransformerAbstract;
use App\Transformers\MediafileTransformer;

class VisitFiltTransformer extends TransformerAbstract
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
        *recomendado,
        *preciohoramin,
        *puntoencuentro,
        *name,
        *nummax,
        *visitcategories,
        *visittags,
        *visithours
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
            'preciohoramin' => ($visit->preciohoramin *1),
            'precio' => $visit->precio,
            'puntoencuentro' => $visit->puntoencuentro,
            'titulo' => $visit->titulo,
            'descripcion' => $visit->descripcion,
            'name' => $visit->name,
            'nummax' => $visit->nummax,
            'visitcategories' => $visit->visitcategories,
            'visittags' => $visit->visittags,
            'mediafiles' => $visit->mediafiles,
            'visithours' => $visit->visithours,
            'visitlanguages' => $visit->visitlanguages,
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
            'puntodeencuentro' => 'puntodeencuentro',
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
            'puntodeencuentro' => 'puntodeencuentro',
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
