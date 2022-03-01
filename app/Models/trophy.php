<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trophy extends Model
{
    use HasFactory;
    protected $fillable = ['trophy_name', 'trophy_image','trophy_desc','trophy_won','deleted'];
}
