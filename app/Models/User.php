<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Transformers\UserTransformer;
use App\Transformers\UserSecTransformer;
use App\Models\Disponibility;
use App\Models\Nodisponibility;
use App\Models\Guialanguages;

class User extends Authenticatable
{
    use SoftDeletes;

    public $transformer = UserTransformer::class;
    public $transformerSec = UserSecTransformer::class;

    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'password',
        'name',
        'email',
        'surname',
        'prefijo',
        'telefono',
        'state',
        'country',
        'city',
        'number',
        'address',
        'rol_id',
        'particular'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtolower($valor);
    }

    public function getNameAttribute($valor)
    {
        return ucwords($valor);
    }

    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public function esAdministrador()
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificationToken()
    {
        return Str::random(40);
    }


    public function disponibilities()
    {
        return $this->hasMany(Disponibility::class);
    }

    public function nodisponibilities()
    {
        return $this->hasMany(Nodisponibility::class);
    }
    
    
    public function guialanguages()
    {
        return $this->hasMany(Guialanguages::class);
    }

}
