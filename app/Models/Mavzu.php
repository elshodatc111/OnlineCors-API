<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mavzu extends Model{
    use HasFactory;
    protected $fillable = [
        'cours_id',
        'mavzu_name',
        'discription',
        'lenth',
        'number',
        'video',
    ];
}
