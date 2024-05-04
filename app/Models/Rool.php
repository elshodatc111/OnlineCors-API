<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Photo;
class Rool extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_id',
        'rool'
    ];
}
