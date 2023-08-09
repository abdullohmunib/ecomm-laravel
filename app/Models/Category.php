<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // artinya semua kolom bisa diisi, lebih singkat daripada menulis satu per satu nama kolom dengan awalan fillable
    protected $guarded = [];
}
