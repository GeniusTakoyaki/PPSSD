<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesticide extends Model
{
    protected $primaryKey = 'Pesticide ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['name'];
    public $timestamps = false;
}