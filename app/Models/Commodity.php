<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $primaryKey = 'Commodity ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['name', 'type', 'subtype'];
    public $timestamps = false;
}