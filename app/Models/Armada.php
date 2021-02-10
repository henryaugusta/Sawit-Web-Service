<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    use HasFactory;
    protected $table ="armadas";
//d	merk_mobil	nopol	no-mesin	max-cap	max-weight	photo_1	photo_2	photo_3	photo_4	photo_5	created_at	updated_at
    protected $fillable = [
        "merk_mobil",
        "nopol",
        "no-mesin",
        "max-cap",
        "max-weight",
        "photo_1",
        "photo_2",
        "photo_3",
        "photo_4",
        "photo_5",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
