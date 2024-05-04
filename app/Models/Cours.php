<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model{
    use HasFactory;
    protected $fillable = [
        'techer_id',
        'catigorie_id',
        'cours_name',
        'title',
        'discription',
        'price',
        'price_crm',
        'length',
        'days',
        'image',
        'video',
    ];
}
