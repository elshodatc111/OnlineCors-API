<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catigory extends Model
{
    use HasFactory;
    protected $fillable = [
        'catigory',
        'number'
    ];
}
