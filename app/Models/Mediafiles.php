<?php

namespace App\Models;
use App\Transformers\MediafilesTransformer;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediafiles extends Model
{
    use SoftDeletes;

    public $transformer = MediafilesTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'visit_id',
    	'order',
        'path',
        'filename',
        'type',
        'url'
    ];
    protected $hidden = [
        'pivot'
    ];

    public function visit(){
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }
    


}
