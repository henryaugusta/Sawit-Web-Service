<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellRequest extends Model
{
    use HasFactory;
    protected $table = "request_sell";

    protected $fillable = [
        "user_id",
        "staff_id",
        "driver_id",
        "updated_by",
        "est_weight",
        "est_price",
        "est_margin",
        "address",
        "lat",
        "long",
        "contact",
        "status",
        "file_name",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];
}
