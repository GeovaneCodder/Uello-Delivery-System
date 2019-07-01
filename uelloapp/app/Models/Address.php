<?php

namespace Uello\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'zip_code',
        'latitude',
        'longitude',
    ];
}
