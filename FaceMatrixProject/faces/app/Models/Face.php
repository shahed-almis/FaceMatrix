<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Face extends Model
{
    protected $fillable = ['name', 'email', 'ref_no', 'date_of_birth', 'data', 'gender'];
    use HasFactory;
}
