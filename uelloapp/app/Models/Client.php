<?php

namespace Uello\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'birthday',
        'document_number',
    ];

    public function address ()
    {
        return $this->hasOne( Address::class );
    }
}
